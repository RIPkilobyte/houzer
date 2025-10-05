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

@include('navigation')
<div class="container">

    <div class="forgot">
        <h1>Forgot your password?</h1>

        <h2 class="forgot__noproblem">No problem!</h2>
        <p class="mt-4 mb-4">Please enter your e-mail (the one you used to register with us) below, and we will e-mail you a reset code.</p>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">{{ $error }}</div>
            @endforeach
        @endif
        @if(session('status'))
            <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
        @endif

        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Enter your e-mail">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-block mainButton btn-bluedark">Reset password</button>
                </div>
            </div>
        </form>

        <p class="mt-3 text-center">
            <a class="text-white" href="{{ route('register') }}">Would you like to register with us?</a>
        </p>
    </div>

    <div class="row">
        <div class="col-12 mt-2 mt-lg-5 text-center mb-4">
            <a href="https://app.houzer.com/" target="_blank">app.houzer.com</a>
        </div>
    </div>

</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>
