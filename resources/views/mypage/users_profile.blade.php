@extends("layouts.sidebar")

@php
  $user = Auth::user();
@endphp

@section('content')
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>プロフィール</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="\">Amazon</a></li>
          <li class="breadcrumb-item active">プロフィール</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-settings">設定</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">パスワード変更</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade pt-3 active show" id="profile-settings">

                    <div class="row mb-3 ">
                      <section class="content">
                        <div class="body_scroll">
                          
                          <!-- <div class="container-fluid">
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
                          </div> -->

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

                          <!-- <div class="container-fluid">
                            <div class="row clearfix">
                              <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="alert alert-warning" role="alert">
                                  <strong>DISCORD</strong>
                                </div>
                                <div class="card">
                                  <div class="body">
                                    <div class="row clearfix">
                                      <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
                                        <label for="email_address_2">DISCORD ID:</label>
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
                          </div> -->

                        </div>
                      </section>
                    </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
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
                  </section><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
        <div class="col-lg-2"></div>
      </div>
    </section>

  </main><!-- End #main -->
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
