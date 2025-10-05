<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Houzer</title>
    <link rel="icon" href="https://houzer.uk/wp-content/uploads/2023/02/cropped-favicon-32x32.png" sizes="32x32" />
    <link rel="icon" href="https://houzer.uk/wp-content/uploads/2023/02/cropped-favicon-192x192.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://houzer.uk/wp-content/uploads/2023/02/cropped-favicon-180x180.png" />
    <meta name="msapplication-TileImage" content="https://houzer.uk/wp-content/uploads/2023/02/cropped-favicon-270x270.png" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="hold-transition login-page overflow-hidden">
<div class="login-box">
    <div class="row">
        <div class="col-lg-4 offset-lg-4">
          <div class="card card-outline card-primary">
            <div class="card-header text-center">
              <a href="/" class="h1">{{__('Houzer')}}</a>
            </div>
            <div class="card-body">
              <p class="login-box-msg">Reset password</p>
              @if ($errors->any())
                  @foreach ($errors->all() as $error)
                     <div class="alert alert-danger" role="alert">{{ $error }}</div>
                  @endforeach
              @endif
              @if (session('status'))
                <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
              @endif

              <form action="{{ route('password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <div class="input-group mb-3">
                  <input type="email" class="form-control" name="email" placeholder="Email address" id="email" value="{{ old('email', $request->email)}}">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" id="password-input1" class="form-control" name="password" placeholder="Password" id="password">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <a href="#" class="pwdControl ctrl1"></a>
                    </div>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input type="password" id="password-input2" class="form-control" name="password_confirmation" placeholder="Confirm password" id="password_confirmation">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <a href="#" class="pwdControl ctrl2"></a>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block mainButton">Set new password</button>
                  </div>
                </div>
              </form>

              <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">Login</a>
              </p>
            </div>
          </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
