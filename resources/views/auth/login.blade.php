@extends("layouts.auth")

@section("content")
  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/images/logo.svg" width="25" alt="Amazon">
                  <span class="d-none d-lg-block">AMAZON</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">ログイン</h5>
                  </div>

                  <form method="POST" action="{{ route('login') }}" role="form" class="row g-3 needs-validation" novalidate>
                      @csrf
                    <div class="col-12">
                      <label for="yourUsername" class="form-label">メールアドレス</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" id="email" class="form-control" id="yourUsername" placeholder="Email" required>
                        <div class="invalid-feedback">メールアドレスを入力してください。</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">パスワード</label>
                      <input type="password" name="password" id="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">パスワードを入力してください。</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">ログイン</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0"><a href="{{ url('/register') }}">新規登録はこちらから</a></p>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  @endsection



