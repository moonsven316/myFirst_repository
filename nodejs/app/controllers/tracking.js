const amazonPaapi = require('amazon-paapi');
const { default: axios } = require('axios');
const { products, users, errors, machines } = require("../models");

exports.updateInfo = async () => {
	await users.findAll({where: {is_permitted: 1}})
	.then(async users => {
		for (let user of users) {
			await machines.findAll({where:{user_id : user.id}})
			// await machines.findAll({where:{id : 70}})
			.then(async machines => {
				// console.log(machines);
				for (let machine of machines) {
					// console.log(machine.id);
					amazonTracking(user, machine);
				}
			});
			
		}
	}).catch(err => {
		console.log("Cannot access user data", err);
	});
};  

const amazonTracking = async (user, machine) => {
	// console.log(machine.id);
	await products.findAll({ where: { machine_id: machine.id } })
	.then(items => {
		var index = 0;
		var len = items.length;
		// if (len == 0) return;
		console.log(index);
		var asins = [];
		for (const i of items) {
			asins.push(i.asin);
		}

		let checkInterval = setInterval(() => {
			// console.log(user);
			machines.findByPk(machine.id)
			.then((data) => {
				let query = {};
				if (data.stop == 0 && data.is_reg == 0) {
					query.len = len;
					if (index < len) {
						let checkItemInfo = new CheckItemInfo(user, machine, asins.slice(index, (index + 10)));
						checkItemInfo.main();
						index += 10;
						
						query.trk_num = Math.min(len, index);
						query.round = data.round;
					} else {
						clearInterval(checkInterval);
						amazonTracking(user, machine);
						index = 0;

						query.round = data.round + 1;
					}
				} else if (data.stop == 1 || data.is_reg == 1) {
					index = 0;
					query.round = 0;
					query.trk_num = 0;
				}
				machines.update(query, {where: {id: machine.id}});
			});
		}, 10000);
	}).catch (err => {
		console.log(err);
	});
};

class CheckItemInfo {
	constructor(user, machine, code) {
		this.machine = machine;
		this.user = user;
		this.code = code;
	}

	async main() {
		const commonParameters = {
			AccessKey: this.machine.access_key,
			SecretKey: this.machine.secret_key,
			PartnerTag: 'gnem03010a-22', // yourtag-20
			PartnerType: 'Associates', // Default value is Associates.
			Marketplace: 'www.amazon.co.jp', // Default value is US. Note: Host and Region are predetermined based on the marketplace value. There is no need for you to add Host and Region as soon as you specify the correct Marketplace value. If your region is not US or .com, please make sure you add the correct Marketplace value.
		};
			console.log(commonParameters);
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
			if (amazonData.Errors !== undefined && amazonData.Errors.length > 0) {
				var error = amazonData.Errors;
				for (const e of error) {
					var query = {
						machine_id: this.machine.id,
						asin: e.Message.substr(11, 10),
						error: '無効な ASIN コード'
					};
					
					var condition = {
						machine_id: this.machine.id,
						asin: e.Message.substr(11, 10),
					};
					
					products.update(query, { where: condition });
				}
			}

			var items = amazonData.ItemsResult.Items;
			for (const item of items) {
				try {
					let query = {};
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

					let condition = {
						machine_id: this.machine.id,
						asin: item.ASIN,
					};

					products.update(query, { where: condition });

					//------------------- send line notification -------------------
					products.findAll({ where: condition })
					.then(data => {
						if (query.price > (data[0].reg_price / 5) && query.price < data[0].tar_price) {
							if (query.in_stock == '在庫あり。' && data[0].is_notified == 0) {
								var amazonUrl = "https://www.amazon.co.jp/gp/offer-listing/" + data[0].asin;
								var notification = "現在価格[" + query.price + "円]が目標価格[" + data[0].tar_price + "円]以下になりました。";
								var keepaUrl = "https://keepa.com/#!product/5-" + data[0].asin;
	
								// var lineNotify = require('line-notify-nodejs')(this.user.access_token);
								// lineNotify.notify({
								// 	message: '\n\n' + amazonUrl + '\n\n' + notification + '\n\n' + keepaUrl,
								// }).then(() => {
								// 	query.is_notified = 1;
								// 	products.update(query, { where: condition });
	
								// 	var note = {
								// 		code: amazonUrl + ' ' + notification + ' ' + keepaUrl
								// 	}
								// 	errors.create(note);
								// });

								var axios = require('axios');
								var data = JSON.stringify({
									"content": amazonUrl + '\n' + notification + '\n' + keepaUrl
								});

								var config = {
									method: 'post',
									maxBodyLength: Infinity,
									url: this.machine.web_hook,
									headers: { 
										'Content-Type': 'application/json', 
										// 'Cookie': '__cfruid=68593421b99a0e123dc9290741b529d4df486440-1676047037; __dcfduid=828fce4ea96511ed8bea1adcd3d353f2; __sdcfduid=828fce4ea96511ed8bea1adcd3d353f2c0690237379bd5a6163a7d5044df73d84966d8efed1bbb31c5201fa46dbcfd40'
									},
									data : data
								};

								axios(config)
								.then(function (response) {
									console.log(JSON.stringify(response.data));
									query.is_notified = 1;
									products.update(query, { where: condition });
								})
								.catch(function (error) {
									console.log(error);
								});
							}
						}
					});
				} catch (err) {
					console.log('forof item error', err);
				}
			}
		}).catch(err => {
			console.log('amazon tracking error', err);
		});
	}
}