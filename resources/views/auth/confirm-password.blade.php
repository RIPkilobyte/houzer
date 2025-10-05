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
<body class="hold-transition login-page">
<div class="login-box">
  @include('navigation')
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1">{{__('Houzer')}}</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Please confirm your password to this action</p>
      @if ($errors->any())
          @foreach ($errors->all() as $error)
             <div class="alert alert-danger" role="alert">{{ $error }}</div>
          @endforeach
      @endif
      @if(session('status'))
        <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
      @endif

      <form action="{{ route('password.confirm') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="text" id="password-input1" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <a href="#" class="pwdControl ctrl1"></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block mainButton">Confirm</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="{{ route('login') }}">Login</a>
      </p>
    </div>
  </div>
</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
