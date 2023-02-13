@extends("layouts.sidebar")

@php
	$user = Auth::user();
@endphp

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>パスワード変更</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Amazon</a></li>
          <li class="breadcrumb-item active">パスワード変更</li>
        </ol>
      </nav>
    </div>
	<section class="content">
		<div class="body_scroll">
			<div class="container-fluid">
				<!-- Input -->
				<div class="row clearfix">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="alert alert-warning" role="alert">
							<strong>パスワード変更</strong>
						</div>
						<div class="card">
							<div class="body">                            
								<div class="row clearfix">
									<div class="col-sm-12">
										<div class="input-group mb-3">
											<input type="password" name="current-password" id="current-password" class="form-control" placeholder="現在パスワード">
											<div class="input-group-append">                                
												<span class="input-group-text" style="cursor: pointer;" onclick="showPwd(event);"><i class="bi bi-lock"></i></span>
											</div> 
										</div>                                    
									</div>
									<div class="col-sm-12">
										<div class="input-group mb-3">
											<input type="password" name="new-password" id="new-password" class="form-control" placeholder="新しいパスワード">
											<div class="input-group-append">
												<span class="input-group-text" style="cursor: pointer;" onclick="showPwd(event);"><i class="bi bi-lock"></i></span>
											</div> 
										</div>                                    
									</div>
									<div class="col-sm-12">
										<div class="input-group mb-3">
											<input type="password" name="con-password" id="con-password" class="form-control" placeholder="パスワード確認">
											<div class="input-group-append">
												<span class="input-group-text" style="cursor: pointer;" onclick="showPwd(event);"><i class="bi bi-lock"></i></span>
											</div> 
										</div>                                    
									</div>
									<div class="col-sm-12">
										<button type="button" class="btn btn-raised btn-primary btn-round waves-effect" onclick="savePass()">保管</button>
									</div>
								</div>                           
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>


<script>
	const savePass = async () => {
		let curPass = $('input[name="current-password"]').val();
		let newPass = $('input[name="new-password"]').val();
		let conPass = $('input[name="con-password"]').val();

		if (curPass == '') {
			toastr.error('現在パスワードは必須です。');
			return;
		} else if (curPass != '') {
			let confirmData = {
				password: curPass
			};

			await $.ajax({
				url: '{{ route("check_pwd") }}',
				type: 'post',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: {
					postData: JSON.stringify(confirmData)
				},
			});
		}

		if (curPass == '' && newPass != conPass) {
			toastr.error('新しいパスワードと確認パスワードが一致しません。');
			return;
		}

		$.ajax({
			url: '{{ route("change_pwd") }}',
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				postData: newPass
			},
			success: function () {
				toastr.success('パスワードが正常に変更されました。');
				location.href = "{{ route('login') }}";
			}
		});
	};

	const showPwd = (event) => {
		event.preventDefault();
		let passInput = $(event.target).parent().parent().prev().attr('type');
		if (passInput == 'text') {
			$(event.target).parent().parent().prev().attr('type', 'password');
		} else if (passInput == 'password') {
			$(event.target).parent().parent().prev().attr('type', 'text');;
		}
	};
</script>
@endsection