@extends("layouts.sidebar")

@php
	$user = Auth::user();
@endphp

@section('content')
<main id="main" class="main">
	<div class="row">
		
			<div class="col-lg-2">
			    <div class="pagetitle">
					<h1>商品一覧</h1>
					<nav>
						<ol class="breadcrumb">
						  <li class="breadcrumb-item"><a href="/">Amazon</a></li>
						  <li class="breadcrumb-item active">商品一覧</li>
						</ol>
					</nav>
			    </div>
			</div>
			<div class="col-lg-8"></div>
			<div class="col-lg-2 float-right">

					<a style="color: white;" href="{{ route('csv_down') }}" class="btn btn-primary btn-icon float-right">
						<i class="bi bi-download"></i>
					</a>
					<button class="btn btn-danger btn-icon float-right" type="button" onclick="deleteProduct('{{$user->id}}')">
						<i class="bi bi-trash"></i>
					</button>
				
			</div>
		
	</div>

	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-12">
					<div class="card">
			            <div class="card-body">
			              <!-- <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">

			                <li class="nav-item" role="presentation">
			                  <button class="nav-link active" id="1111" data-bs-toggle="tab" data-bs-target="#a" type="button" role="tab" aria-controls=" " aria-selected="true">1111</button>
			                </li>

			                <li class="nav-item" role="presentation">
			                  <button class="nav-link" id="2222" data-bs-toggle="tab" data-bs-target="#b" type="button" role="tab" aria-controls=" " aria-selected="false">2222</button>
			                </li>

			                <li class="nav-item" role="presentation">
			                  <button class="nav-link" id="3333" data-bs-toggle="tab" data-bs-target="#c" type="button" role="tab" aria-controls=" " aria-selected="false">3333</button>
			                </li>

			                <li class="nav-item" role="presentation">
			                  <button class="nav-link" id="4444" data-bs-toggle="tab" data-bs-target="#d" type="button" role="tab" aria-controls=" " aria-selected="false">4444</button>
			                </li>

			                <li class="nav-item" role="presentation">
			                  <button class="nav-link" id="5555" data-bs-toggle="tab" data-bs-target="#e" type="button" role="tab" aria-controls=" " aria-selected="false">5555</button>
			                </li>

			              </ul> -->
			              <div class="tab-content pt-2" id="borderedTabContent">

			                <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="1111">
			                	<div class="table-responsive">
													<table class="table table-hover table-striped product_item_list c_table theme-color mb-0">
														<thead>
															<tr>
																<th colspan="1" rowspan="1" style="text-align: center;">No</th>
																<th colspan="1" rowspan="1" style="text-align: center;">画像</th>
																<th colspan="1" rowspan="1" style="text-align: center;">ASIN</th>
																<th colspan="1" rowspan="1" style="text-align: right;">登録価格</th>
																<th colspan="1" rowspan="1" style="text-align: right;">現在価格</th>
																<th colspan="1" rowspan="1" style="text-align: center;">下落％<br/>（目標価格）</th>
																<!-- <th colspan="1" rowspan="1" data-breakpoints="md sm xs">再通知間隔</th> -->
																<th colspan="1" rowspan="1" data-breakpoints="md sm xs" style="text-align: center;">Keepa URL</th>
																<th colspan="1" rowspan="1" style="text-align: center;"></th>
															</tr>
														</thead>
														<tbody>
															@foreach ($products as $product)
																<tr data-id="{{ $product->id }}">
																	<td colspan="1" rowspan="1" style="text-align: center;">{{ $loop->iteration + ($products->currentPage() - 1) * 10 }}</td>
																	<td colspan="1" rowspan="1" style="text-align: center;">
																		<a href="{{ $product->url }}" target="_blank"><img src="{{ $product->image }}" title="{{ $product->url }}" alt="image" /></a>
																	</td>
																	<td colspan="1" rowspan="1" style="text-align: center;">{{ $product->asin }}</td>
																	<td colspan="1" rowspan="1" style="color: #e47297; font-size: 16px; text-align: right;">¥{{ number_format($product->reg_price) }}</td>
																	<td colspan="1" rowspan="1" style="color: #5cc5cd; font-size: 16px; text-align: right;">¥{{ number_format($product->price) }}</td>
																	<td colspan="1" rowspan="1" style="text-align: center;">{{ $product->pro }}%<br/>(¥{{ number_format($product->tar_price) }})</td>
																	<!-- <td colspan="1" rowspan="1">{{ $user->interval }}</td> -->
																	<td colspan="1" rowspan="1" style="text-align: center;">
																		<a href="{{ 'https://keepa.com/#!product/5-' . $product->asin }}" target="_blank"><img style="width: 200px;" title="{{ 'https://keepa.com/#!product/5-' . $product->asin }}" src={{ 'https://graph.keepa.com/pricehistory.png?asin=' . $product->asin . '&domain=co.jp&salesrank=1'}} /></a>
																	</td>
																	<!-- <td colspan="1" rowspan="1">
																		<a href="{{ 'https://keepa.com/#!product/5-' . $product->asin }}" target="_blank">{{ 'https://keepa.com/#!product/5-' . $product->asin }}</a>
																	</td> -->
																	<td colspan="1" rowspan="1" style="text-align: center;"><button class="btn btn-danger btn-icon" type="button" onclick="removeProduct('{{$product->id}}')"><i class="bi bi-trash"></i></button></td>
																</tr>
															@endforeach
														</tbody>
													</table>
										</div>
			                </div>

			                <!-- <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="2222">
			                	aaaaaaaaaaaaaaaaaaaaaaaaa
			                </div>

			                <div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="3333">
			                    bbbbbbbbbbbbbbbbbbbbbbbbbbbbb
			                </div>

			                <div class="tab-pane fade" id="d" role="tabpanel" aria-labelledby="4444">
			                    ccccccccccccccccccccccccccccccc
			                </div>

			                <div class="tab-pane fade" id="e" role="tabpanel" aria-labelledby="5555">
			                    ddddddddddddddddddddddddc
			                </div> -->

			              </div>
										@if (count($products)) {{ $products->onEachSide(1)->links('mypage.pagination') }} @endif
			            </div>
			          </div>

								<div class="card widget_2 big_icon">
									<div class="body">
									
									</div>
								</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection

@push('scripts')
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			setInterval(() => {
				location.href = '{{ route("list_product") }}';
			}, 300000);	
		});

		function deleteProduct(id) {
			if (!window.confirm('データを本当に削除しますか？')) {
				return;
			}
			toastr.info('少々お待ちください。')
			$.ajax({
				url: '{{ route("delete_product") }}',
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					user_id: id
				},
				success: function () {
					toastr.success('データが正常に削除されました。');
					setTimeout(() => {
						location.href = '{{ route("list_product") }}';
					}, 3000);
				}
			})
		}

		function removeProduct(id) {
			if (!window.confirm('データを本当に削除しますか？')) {
				return;
			}
			$.ajax({
				url: '{{ route("remove_product") }}',
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					product_id: id
				},
				success: function () {
					toastr.success('データが正常に削除されました。');
					$('tr[data-id=' + id + ']').remove();
				}
			})
		}
	</script>
@endpush