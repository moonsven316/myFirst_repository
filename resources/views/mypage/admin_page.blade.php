@extends("layouts.sidebar")


@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>管理者ページ</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Amazon</a></li>
          <li class="breadcrumb-item active">管理者ページ</li>
        </ol>
      </nav>
    </div>
	<section class="content">
		<div class="body_scroll">
			<div class="container-fluid">
				<div class="row clearfix">
					<div class="col-12">
						<div class="card card-info card-outline">
							<div class="table-responsive">
								<table class="table table-hover product_item_list c_table theme-color mb-0">
									<thead>
										<!-- <tr>{{$machines['1'][0]->email}}</tr> -->
										<tr>
											<th></th>
											<th>メールgit</th>
											<th>1111111111111111111111111111</th>
											<th>222222222222222222222222222222222</th>
											<th>3</th>
											<th>4</th>
											<th>5</th>
											<th>user</th>
										</tr>
									</thead>
									<tbody>
									@foreach($machines as $m)
									@if ($m[0]->role == 'admin') @continue @endif
										
										<tr data-id={{$m[0]->user_id}}>
											<td>
												<button class="btn btn-icon" type="button" onclick="deleteAccount(event);"><i class="bi bi-trash"></i></button>
											</td>
											<td rowspan="1" colspan="1">{{$m[0]->email}}</td>
											<td rowspan="1" colspan="1">{{$m[0]->reg_num}}件/{{$m[0]->round}}回目</td>
											<td rowspan="1" colspan="1">{{$m[1]->reg_num}}件/{{$m[1]->round}}回目</td>
											<td rowspan="1" colspan="1">{{$m[2]->reg_num}}件/{{$m[2]->round}}回目</td>
											<td rowspan="1" colspan="1">{{$m[3]->reg_num}}件/{{$m[3]->round}}回目</td>
											<td rowspan="1" colspan="1">{{$m[4]->reg_num}}件/{{$m[4]->round}}回目</td>
											<td rowspan="1" colspan="1">
												<div class="form-check form-switch" style="margin-top: 10px;">
													<input type="checkbox" class="form-check-input" id={{"customSwitch".$m[0]->user_id}} @if ($m[0]->is_permitted) checked @endif onchange="permitAccount(event);">
													<label class="custom-control-label" for={{"customSwitch".$m[0]->user_id}}></label>
												</div>

											</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection

@push("scripts")
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>:
	<script>
		const deleteAccount = (event) => {
			if (!window.confirm('デターを本当に削除しますか？')) {
				return;
			}
			let _tr = $(event.target).parents('tr');
			let userId = _tr.data('id');
			
			$.ajax({
				url: '{{ route("delete_account") }}',
				type: 'get',
				data: {
					id: userId
				},
				success: function() {
					toastr.success("アカウントは正常に削除されました。");
					_tr.remove();
				}
			});
		};

		const permitAccount = (event) => {
			let isPermitted = (event.target.checked == true) ? 1 : 0;
			$.ajax({
				url: '{{ route("permit_account") }}',
				type:'get',
				data: {
					id: event.target.id.replace('customSwitch', ''),
					isPermitted: isPermitted
				},
				success: function(response) {
					toastr.success("アカウントが許可されました。");
				}
			});
		};
	</script>
@endpush
