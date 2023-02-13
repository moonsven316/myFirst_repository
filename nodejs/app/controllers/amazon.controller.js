const amazonPaapi = require('amazon-paapi');
const { products, machines} = require("../models");

class GetProductInfo {
	constructor(machine, code) {
		this.machine = machine;
		this.code = code;
	}

	async main() {
		// get the lowest price and image of product from ASIN code using PA-API
		const commonParameters = {
			AccessKey: this.machine.access_key,
			SecretKey: this.machine.secret_key,
			PartnerTag: 'gnem03010a-22', // yourtag-20
			PartnerType: 'Associates', // Default value is Associates.
			Marketplace: 'www.amazon.co.jp', // Default value is US. Note: Host and Region are predetermined based on the marketplace value. There is no need for you to add Host and Region as soon as you specify the correct Marketplace value. If your region is not US or .com, please make sure you add the correct Marketplace value.
		};
		// const commonParameters = {
		// 	AccessKey: 'AKIAISP56OZ77IPJFU4Q',
		// 	SecretKey: 'vckvzNFD5Oqu1FpWVerwPelLEPkbcPb1qeJrIEsN',
		// 	PartnerTag: 'gnem03010a-22', // yourtag-20
		// 	PartnerType: 'Associates', // Default value is Associates.
		// 	Marketplace: 'www.amazon.co.jp', // Default value is US. Note: Host and Region are predetermined based on the marketplace value. There is no need for you to add Host and Region as soon as you specify the correct Marketplace value. If your region is not US or .com, please make sure you add the correct Marketplace value.
		// };

		let requestParameters = { // this is the parameter to get information with asin from amazon
			ItemIds: this.code,
			ItemIdType: 'ASIN',
			Condition: 'New',
			Resources: [
				'Offers.Summaries.LowestPrice',
				'Offers.Listings.Availability.Message',
				'Images.Primary.Small'
			],
		};

		await amazonPaapi.GetItems(commonParameters, requestParameters)
		.then((amazonData) => { // save data into db
			// console.log(amazonData);
			if (amazonData.Errors !== undefined && amazonData.Errors.length > 0) {
				var errors = amazonData.Errors;
				for (const e of errors) {
					var query = {
						machine_id: this.machine.id,
						user_id: this.machine.user_id,
						asin: e.Message.substr(11, 10),
						error: '無効な ASIN コード'
					};
					
					products.create(query);
				}
			}

			var items = amazonData.ItemsResult.Items;
			for (const item of items) {
				try {
					let query = {};
					query.user_id = this.machine.user_id;
					query.machine_id = this.machine.id;
					query.asin = item.ASIN;
					query.url = item.DetailPageURL;

					if (item.Images !== undefined) {
						query.image = item.Images.Primary.Small.URL;
					} else {
						query.image = '';
					}

					let price = 0;
					if (item.Offers !== undefined) {
						if (item.Offers.Listings[0].Availability !== undefined) {
							query.in_stock = item.Offers.Listings[0].Availability.Message;
						} else {
							query.in_stock = 'x';
						}
						
						if (item.Offers.Summaries[0].Condition.Value == 'New') {
							price = item.Offers.Summaries[0].LowestPrice.Amount;
						} else if (item.Offers.Summaries.length > 1 && item.Offers.Summaries[1].Condition.Value == 'New') {
							price = item.Offers.Summaries[1].LowestPrice.Amount;
						}
					} else {
						query.in_stock = 'x';
						price = 0;
					}

					query.price = price;
					query.reg_price = price;
					
					query.pro = this.machine.down;
					query.tar_price = Math.floor(price * (1 - query.pro / 100));
					
					products.create(query);
				} catch (err) {
					console.log('forof item error', err);
				}
			}
		}).catch(err => {
			console.log('amazon data err', err);
			for (const c of this.code) {
				let query = {};
				query.machine_id = this.machine.id;
				query.user_id = this.machine.user_id;
				query.asin = c;
				query.reg_price = 0;
				query.pro = this.machine.down;
				query.tar_price = 0;
				products.create(query);
			}
		});
	}
}

const amazonInfo = async (machine, codeList) => {
	try {
		await products.destroy({where: {'machine_id': machine.id}});

		var index = 0;
		var len = codeList.length;

		var inputInterval = setInterval(() => {
			if (index < len) {
				let getProductInfo = new GetProductInfo(machine, codeList.slice(index, (index + 10)));
				getProductInfo.main();
				index += 10;

				let query = {};
				query.is_reg = 1;
				query.len = len;
				query.reg_num = Math.min(len, index);
				
				machines.update(query, {where: {id: machine.id}});
			} else {
				let query = {};
				query.is_reg = 0;
				query.round = 0;				
				setTimeout(() => {
					machines.update(query, {where: {id: machine.id}});
				}, 5000);
				clearInterval(inputInterval);
			}
		}, 2000);
	} catch (err) {
		console.log(err);
	}
};

exports.getInfo = (req, res) => {
	let reqData = JSON.parse(req.body.asin);
	machines.findByPk(reqData.machine_id)
	.then(machine => {
		amazonInfo(machine, reqData.codes);
	}).catch(err => {
		console.log('Cannot get machine information.', err);
	});
};