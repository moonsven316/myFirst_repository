@extends("layouts.sidebar")

@php
	$user = Auth::user();
@endphp

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>商品登録</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Amazon</a></li>
          <li class="breadcrumb-item active">商品登録</li>
        </ol>
      </nav>
    </div>
	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-lg-2 col-md-12"></div>
				<div class="col-lg-8 col-md-12">
					<div class="card">
			            <div class="card-body">
			             @if (count($machines)) {{ $machines->onEachSide(1)->links('mypage.pagination') }} @endif


			              <!-- <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
						  @foreach ($machines as $m)
			                <li class="" style="margin-right: -15px;">
			                  <button class="nav-link @if ($loop->iteration == 1) active @endif" id="{{'tab' . $m->id}}" data-tab="{{$m->id}}" data-bs-toggle="tab" data-bs-target="#{{'m' . $m->id}}" type="button" role="tab" aria-controls="{{$m->id}}" aria-selected="true">{{$loop->iteration}}</button>
			                </li>
			              @endforeach
			              </ul> -->
			              <div class="tab-content pt-2" id="borderedTabContent">
			              	@foreach ($machines as $m)
			                <div class="tab-pane fade  @if ($loop->iteration == 1) show active @endif" id="{{'m' . $m->id}}" role="tabpanel" aria-labelledby="{{'tab' . $m->id}}">
			                	<div class="table-responsive">
									<table class="table table-hover product_item_list c_table theme-color mb-0">
										<thead>
											
										</thead>
										<tbody> 
											<tr>
												<td>【カテゴリー】:</td>
												<td><input type="text" id="category{{$m->id}}" name="category{{$m->id}}" class="form-control" placeholder="カテゴリー" value="{{$m->category}}"/></td>
											</tr>
											<tr>
												<td>アックスキー:</td>
												<td><input type="text" id="access_key{{$m->id}}" name="access_key{{$m->id}}" class="form-control" placeholder="アックスキー" value="{{ $m->access_key }}" /></td>
											</tr>
											<tr>
												<td>シークレットキー:</td>
												<td><input type="text" id="secret_key{{$m->id}}" name="secret_key{{$m->id}}" class="form-control" placeholder="シークレットキー" value="{{ $m->secret_key }}" /></td>
											</tr>
											<tr>
												<td>CSVファイル:</td>
												<td>
													<input type="file" class="form-control csv_event" style="cursor: pointer;" placeholder="CSVファイルを選択してください。" id="csv{{$m->id}}" name="csv{{$m->id}}" />
												</td>
											</tr>
											<tr>
												<td>下落(%):</td>
												<td><input type="number" class="form-control" placeholder="50" id="down{{$m->id}}" name="down{{$m->id}}" min="0" max="100" value="30" /></td>
											</tr>
											<tr>
												<td>Web Hook:</td>
												<td><input type="text" class="form-control" id="web_hook{{$m->id}}" name="web_hook{{$m->id}}" value="{{$m->web_hook}}" /></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="col-lg-12 mt-4" id="register-status{{$m->id}}" style="display: block;">
									<div class="row">
										<div class="col text-center">
											<span id="progress-num{{$m->id}}">0</span> 件/ <span id="total-num{{$m->id}}">0</span> 件
										</div>
										<div class="col text-center">
											<span id="round{{$m->id}}">0</span>回目
										</div>
									</div>
									<div class="row mt-4">
										<div class="progress col-12" id="count{{$m->id}}">
											<div class="progress-bar progress-bar-animated bg-danger progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 20px;" id="progress{{$m->id}}">
												<span id="percent-num{{$m->id}}">0%</span>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-12 mt-4" id="track-status{{$m->id}}" style="display: none;">
									<div class="row">
										<div class="col text-center">
											<span id="progress-num1{{$m->id}}">0</span> 件/ <span id="total-num1{{$m->id}}">0</span> 件
										</div>
										<div class="col text-center">
											<span id="round1{{$m->id}}">0</span>回目
										</div>
									</div>
									<div class="row mt-4">
										<div class="progress col-12" id="count1{{$m->id}}">
											<div class="progress-bar progress-bar-animated bg-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%; height: 20px;" id="progress1{{$m->id}}">
												<span id="percent-num1{{$m->id}}">0%</span>
											</div>
										</div>
									</div>
								</div>

								<div class="col-12 text-center mt-4">
									<button type="button" id="register" class="btn btn-raised btn-primary waves-effect @if ($loop->iteration > 1) disabled @endif" onclick="register({{$m->id}})">登 録</button>
									<button type="button" id="stop" class="btn btn-raised btn-warning waves-effect @if ($loop->iteration > 1) disabled @endif" onclick="stop({{$m->id}})">停 止</button>
									<button type="button" id="restart" class="btn btn-raised btn-warning waves-effect @if ($loop->iteration > 1) disabled @endif" onclick="restart({{$m->id}})">起 動</button>
								</div>
			                </div>
			                @endforeach

			              </div>

			            </div>

			        </div>
				</div>
				<div class="col-lg-2 col-md-12"></div>
			</div>
		</div>
	</section>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
		var scanInterval = setInterval(scan, 5000);
		$(document).ready(function () {

			var machine = <?php echo $machines[0]; ?>;
			console.log(machine);
			if (machine.is_reg == 1) {
				$('#register-status'+ machine.id).css('display', 'block');
				$('#track-status'+ machine.id).css('display', 'none');

				$('#total-num'+ machine.id).html(machine.len);
				$('#round'+ machine.id).html(0);
				$('#progress-num'+ machine.id).html(machine.reg_num);

				$('#csv'+ machine.id).attr('disabled', true);
				$('#register'+ machine.id).attr('disabled', true);
			} else if (machine.is_reg == 0) {
				$('#register-status'+ machine.id).css('display', 'none');
				$('#track-status'+ machine.id).css('display', 'block');

				$('#total-num1'+ machine.id).html(machine.len);
				$('#round1'+ machine.id).html(machine.round);
				$('#progress-num1'+ machine.id).html(machine.trk_num);

				$('#csv'+ machine.id).attr('disabled', false);
				$('#register'+ machine.id).attr('disabled', false);
			}
		});

		function scan() {
			$.ajax({
				url: "{{ route('scan') }}",
				type: "get",
				data: {
					machine_id:$('.page-item.active').data('tab')
				},
				success: function(response) {
					var response = response[0];
					console.log(response);
					if (response.is_reg == 1) {
						$('#register-status'+ response.id).css('display', 'block');
						$('#track-status'+ response.id).css('display', 'none');

						$('#total-num'+ response.id).html(response.len);
						$('#progress-num'+ response.id).html(response.reg_num);
						var percent = Math.floor(response.reg_num / response.len * 100);
						$('#percent-num'+ response.id).html(percent + '%');
						$('#progress'+ response.id).attr('aria-valuenow', percent);
						$('#progress'+ response.id).css('width', percent + '%');
						$('#round'+ response.id).html(0);
					} else if (response.is_reg == 0) {
						$('#register-status'+ response.id).css('display', 'none');
						$('#track-status'+ response.id).css('display', 'block');

						$('#total-num1'+ response.id).html(response.len);
						$('#progress-num1'+ response.id).html(response.trk_num);
						var percent = Math.floor(response.trk_num / response.len * 100);
						$('#percent-num1'+ response.id).html(percent + '%');
						$('#progress1'+ response.id).attr('aria-valuenow', percent);
						$('#progress1'+ response.id).css('width', percent + '%');
						$('#round1'+ response.id).html(response.round);
					}

					if (percent == 100) {
						if (response.round == 0) {
							toastr.success('正常に登録されました。');
							location.href = "{{ route('list_product') }}";
						}
					}
				}
			})
		}

		const register = async (mId) => {
			var user = <?php echo $user; ?>;

			// if (user.is_permitted == 0) {
			// 	toastr.error('管理者からの許可をお待ちください。');
			// 	return;
			// }

			if (csvFile === undefined) {
				toastr.error('CSVファイルを選択してください。');
				return;
			}

			let postData = {
				machine_id:mId,
				access_key: $('input[name="access_key' + mId + '"]').val(),
				secret_key: $('input[name="secret_key' + mId + '"]').val(),
				category: $('input[name="category' + mId + '"]').val(),
				down: $('input[name="down' + mId + '"]').val(),
				web_hook: $('input[name="web_hook' + mId + '"]').val(),
				file_name: csvFile.name,
				len: newCsvResult.length,
			};
			console.log(postData);
			// first save user exhibition setting
			await $.ajax({
				url: 'save_machine',
				type: 'post',
				headers: {
					"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr("content")
				},
				data: {
					exData: JSON.stringify(postData)
				},
				success: function () {
					scanInterval = setInterval(scan, 5000);
					toastr.info('商品登録を開始します。');

					$('#register-status'+ mId).css('display', 'block');
					$('#track-status'+ mId).css('display', 'none');
			
					$('#csv'+ mId).attr('disabled', true);
					$('#register'+ mId).attr('disabled', true);
				}
			});

			// then start registering products with ASIN code
			postData = {
				user_id: '{{ Auth::user()->id }}',
				machine_id: mId,
				codes: newCsvResult
			};

			$.ajax({
				// url: "http://localhost:32768/api/v1/amazon/getInfo",
				url: "http://amazon123.xsrv.jp/fmproxy/api/v1/amazon/getInfo",
				type: "post",
				data: {
					asin: JSON.stringify(postData)
				},
			});
		};

		const stop = (stopmId) => {
			clearInterval(scanInterval);
			$.ajax({
				url: "{{ route('stop') }}",
				type: "get",
				data:{
					id:JSON.stringify(stopmId)
				},
				success: function () {
					toastr.info('サーバーが停止されました。');

					$('#round1'+ stopmId).html(0);
					$('#round1'+ stopmId).html(0);
					$('#progress-num1'+ stopmId).html(0);
					$('#percent-num1'+ stopmId).html('0%');
					$('#progress1'+ stopmId).attr('aria-valuenow', );
					$('#progress1'+ stopmId).css('width', '0%');
				}
			});
		};

		const restart = (restartmId) => {
			scanInterval = setInterval(scan, 5000);
			$.ajax({
				url: "{{ route('restart') }}",
				type: "get",
				data:{
					id:JSON.stringify(restartmId)
				},
				success: function () {
					toastr.info('サーバーが起動されました。');
				}
			});
		}

		var newCsvResult, csvFile;
		// select csv file and convert its content into an array of ASIN code
		$('.csv_event').on('change', function(e) {
			result = e.target.id;
			let mId = result.match(/\d+/g)[0];
			clearInterval(scanInterval);

			csvFile = e.target.files[0];
			newCsvResult = [];

			$('#progress-num'+ mId).html('0');
			$('#percent-num'+ mId).html('0%');
			$('#progress'+ mId).attr('aria-valuenow', 0);
			$('#progress'+ mId).css('width', '0%');

			var ext = $('#csv'+ mId).val().split(".").pop().toLowerCase();
			if ($.inArray(ext, ["csv", "xlsx"]) === -1) {
				toastr.error('CSV、XLSXファイルを選択してください。');
				return false;
			}
			
			if (csvFile !== undefined) {
				reader = new FileReader();
				reader.onload = function (e) {
					$('#count'+ mId).css('visibility', 'visible');
					csvResult = e.target.result.split(/\n/);

					for (const i of csvResult) {
						let code = i.split('\r');
						code = i.split('"');

						if (code.length == 1) {
							code = i.split('\r');
							if (code[0] != '') {
								newCsvResult.push(code[0]);
							}
						} else {
							newCsvResult.push(code[1]);
						}
					}
					
					if (newCsvResult[0] == 'ASIN') { newCsvResult.shift(); }

					// $('#csv-name').html(csvFile.name);
					$('#total-num'+ mId).html(newCsvResult.length);
				}
				reader.readAsText(csvFile);
			}
			// if (csvFile !== undefined) {
			// 	reader = new FileReader();
			// 	reader.onload = function (e) {
			// 		$('#count'+ mId).css('visibility', 'visible');
			// 		csvResult = e.target.result.split(/\n/);

			// 		for (let i = 1, len = csvResult.length - 1; i < len; i++) {
			// 			let productInfo = {};
			// 			let code = csvResult[i].split('\r')[0].split(',');
			// 			productInfo.asin = code[0];
			// 			productInfo.price = code[1];
			// 			productInfo.pro = code[2];
			// 			newCsvResult.push(productInfo);
			// 		}
			// 		// if (newCsvResult[0].asin == 'ASIN' || newCsvResult[0].asin == 'Asin' || newCsvResult[0].asin == 'asin') { newCsvResult.shift(); }

			// 		$('#total-num'+ mId).html(newCsvResult.length);
			// 	}
			// 	reader.readAsText(csvFile);
			// }








			// var newCsvResult = [];
			// var scanInterval;
			// var csvFile = '';
			// $('body').on('change', '#csv_load', async function(e) {
			// 	await $.ajax({
			// 		url: 'get_registering_state',
			// 		type: 'get',
			// 		success: function(response) {
			// 			isReg = response;
			// 		}
			// 	});
				
			// 	if (isReg == 1) {
			// 		toastr.error('別のファイルのアップロードが進行中です。<br/>少々お待ちください。');
			// 		return;
			// 	} else if (isReg == 0 || isReg == 2) {
			// 		newCsvResult = [];
			// 		var csv = $('#csv_load');
			// 		csvFile = e.target.files[0];

			// 		$('#progress-num').html('0');
			// 		$('#percent-num').html('0%');
			// 		$('#progress').attr('aria-valuenow', 0);
			// 		$('#progress').css('width', '0%');

			// 		var ext = csv.val().split(".").pop().toLowerCase();
			// 		if ($.inArray(ext, ["csv"]) === -1) {
			// 			toastr.error('CSVファイルを選択してください。');
			// 			return false;
			// 		}
					
					
			// 	}
			// });
		});
	</script>
@endpush