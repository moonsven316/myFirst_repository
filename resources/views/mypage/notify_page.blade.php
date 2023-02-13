@extends("layouts.sidebar")

@php
	$errors = App\Models\Error::paginate(10);
	$user = Auth::user();
	$machine = App\Models\Machine::all();
@endphp

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>ログ一覧</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Amazon</a></li>
          <li class="breadcrumb-item active">ログ一覧</li>
        </ol>
      </nav>
    </div>
	<section class="content">
		<div class="container-fluid">
			<div class="row clearfix">
				<div class="col-12">
					<div class="card widget_2 big_icon">
						<div class="body">
							<div class="table-responsive">
								<table class="table table-hover table-striped product_item_list c_table theme-color mb-0">
									<thead>
										<tr>
											<th colspan="1" rowspan="1" style="text-align: center;">No</th>
											<th colspan="1" rowspan="1" style="text-align: center;">日付</th>
											<th colspan="1" rowspan="1" style="text-align: center;">通知内容</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($errors as $e)
											<tr data-id="{{ $e->id }}">
												<!-- <td colspan="1" rowspan="1" style="text-align: center;">{{ $loop->iteration }}</td> -->
												<td colspan="1" rowspan="1" style="text-align: center;">{{ $loop->iteration + ($errors->currentPage() - 1) * 10 }}</td>
												<td colspan="1" rowspan="1" style="text-align: center;">{{ $e->created_at}}</td>
												<td colspan="1" rowspan="1" style="text-align: center;">
													<a href="{{ substr($e->code, -40) }}" target="_blank">{{ $e->code }}</a>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@if (count($errors)) {{ $errors->onEachSide(1)->links('mypage.pagination') }} @endif

					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection
