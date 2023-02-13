<!DOCTYPE html>
<html class="no-js " lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="description" content="Amazon Track">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AMAZON出品</title>
  

  <!-- Favicons -->
  <link href="assets/favicon.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  
  

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/quill/quill.snow.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendor/simple-datatables/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
  <!-- spinning CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/loader-4.css') }}" />
<!--   <link rel="stylesheet" href="{{ asset('assets/vendor/style.css') }}" /> -->
  <div class="loader-wrapper" id="loader-4" style="display: inherit; width: 100%; height: 100%; background: lightgrey; position:fixed; top: 0; left: 0; z-index: 10000;">
        <div id="loader">少</div>
        <div id="loader">々</div>
        <div id="loader">お</div>
        <div id="loader">待</div>
        <div id="loader">ち</div>
        <div id="loader">く</div>
        <div id="loader">だ</div>
        <div id="loader">さ</div>
        <div id="loader">い</div>
        <div id="loader">。</div>
  </div>
</head>
<body>
@include("layouts.header")
  <!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
      <a href="./register_product" <?php if(strpos(url()->current(), "register_product")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>>
        <i class="bx bx-duplicate"></i>
        <span>商品登録</span>
      </a>
    </li>

    <li class="nav-item">
      <a  href="./list_product"<?php if(strpos(url()->current(), "list_product")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>>
        <i class="bi bi-cart3"></i>
        <span>商品一覧</span>
      </a>
    </li>

    <!-- <li class="nav-item">
      <a  href="./change_pwd"<?php if(strpos(url()->current(), "change_pwd")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>>
        <i class="bi bi-key"></i>
        <span>パスワード変更</span>
      </a>
    </li>

    <li class="nav-item">
      <a  href="./change_info"<?php if(strpos(url()->current(), "change_info")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>>
        <i class="bi bi-person"></i>
        <span>ユーザー情報入力</span>
      </a>
    </li> -->

    @if ( Auth::user()->role == 'admin')
        <li class="nav-item">
            <a  href="./admin_page"<?php if(strpos(url()->current(), "admin_page")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>>
              <i class="bi bi-gear"></i>
              <span>管理者ページ</span>
            </a>
        </li>

        <!-- <li class="nav-item">
            <a href="{{ route('notify_page') }}" <?php if(strpos(url()->current(), "logout")) echo 'class="nav-link"'; else echo 'class="nav-link collapsed"';?>><i class="bi bi-gear"></i><span>discordログページ</span></a>
        </li> -->
    @endif

    <!-- <li class="nav-item">
        <a href="./logout" class="nav-link collapsed">
          <i class="ri-logout-box-line"></i>
          <span>ログアウト</span>
        </a>
    </li> -->

  </ul>

</aside><!-- End Sidebar-->
<div id="toast-container" class="toast-top-right"></div>
 @yield('content')

  <!-- Vendor JS Files -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

@stack('scripts')

<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(removeSpinner, 1000); //wait for page load PLUS time.
    });

    function removeSpinner() {
        $("#loader-4").fadeOut(70, function () { // fadeOut complete. Remove the loadingSpinner
            $("#loader-4").hide(); //makes page more lightweight 
        });
    }

</script>

</body>

</html>