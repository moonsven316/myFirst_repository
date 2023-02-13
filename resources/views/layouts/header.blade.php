<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>AMAZON出品</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

</head>

<body>
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img src="assets/images/amazon_affiliate.png" width="25" alt="Amazon">
        <span class="d-none d-lg-block">Amazon</span>
      </a>
<!--       <i class="bi bi-list toggle-sidebar-btn"></i> -->
    </div>

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->family_name}}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Auth::user()->family_name}}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="./users_profile">
                <i class="bi bi-person"></i>
                <span>プロフィール</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="./logout">
                <i class="ri-logout-box-line"></i>
                <span>ログアウト</span>
              </a>
            </li>

          </ul>
        </li>
      </ul>
    </nav>

  </header>

</body>

</html>