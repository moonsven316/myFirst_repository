@extends("layouts.mypage")

@php
	$user = Auth::user();
@endphp

@section('content')
<section class="content">
	<div class="body_scroll">
		<div class="block-header">
			<div class="row">
				<div class="col-lg-7 col-md-6 col-sm-12">
					<h2>ユーザー情報入力</h2>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="./"><i class="zmdi zmdi-home"></i> Amazon</a></li>
						<li class="breadcrumb-item">ユーザー情報入力</li>
					</ul>
				</div>
				<div class="col-lg-5 col-md-6 col-sm-12">
					<button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<!-- Input -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="alert alert-warning" role="alert">
						<strong>AMAZON情報入力</strong>
					</div>
					<div class="card">
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
									<label for="email_address_2">アックスキー:</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8">
									<div class="form-group">
										<input type="text" id="access-key" name="access-key" class="form-control" placeholder="アックスキー" value="{{ $user->access_key }}" />
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
									<label for="email_address_2">シークレットキー:</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8">
									<div class="form-group">
										<input type="text" id="secret-key" name="secret-key" class="form-control" placeholder="シークレットキー" value="{{ $user->secret_key }}" />
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-sm-8 offset-sm-2">
									<button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="saveAmazon()">保管</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<!-- Input -->
			<div class="row clearfix">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="alert alert-warning" role="alert">
						<strong>LINE情報入力</strong>
					</div>
					<div class="card">
						<div class="body">
							<div class="row clearfix">
								<div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
									<label for="email_address_2">LINE NOTIFY ID:</label>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-8">
									<div class="form-group">
										<input type="text" id="access-token" name="access-token" class="form-control" placeholder="" value="{{ $user->access_token }}" />
									</div>
								</div>
							</div>
							<div class="row clearfix">
								<div class="col-sm-8 offset-sm-2">
									<button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="saveLine()">保管</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
	const saveAmazon = () => {
		let userInfo = {
			access: $('input[name="access-key"]').val(),
			secret: $('input[name="secret-key"]').val()
		};

		$.ajax({
			url: "{{ route('change_info') }}",
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				postData: JSON.stringify(userInfo)
			},
			success: function () {
				toastr.success('AMAZON情報が正常に保存されました。');
			}
		});
	};

	const saveLine = () => {
		let userInfo = {
			access: $('input[name="access-token"]').val()
		};

		$.ajax({
			url: "{{ route('change_line') }}",
			type: "post",
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				postData: JSON.stringify(userInfo)
			},
			success: function () {
				toastr.success('LINE情報が正常に保存されました。');
			}
		});
	};

</script>
@endsection
