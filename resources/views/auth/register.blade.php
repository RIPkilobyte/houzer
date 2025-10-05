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
<body class="hold-transition register-page">

@include('navigation')

<div class="registration">

    <h1 class="text-center mb-4">Register your interest</h1>

    <a class="registration__already" href="{{ route('login') }}">Already registered?</a>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">{{ $error }}</div>
        @endforeach
    @endif
    @if(session('status'))
        <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
    @endif

    <form action="{{ route('register') }}" method="post">
        @csrf
        <div class="form-group row">
            <label for="first_name" class="col-sm-4 col-form-label">First name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name">
            </div>
        </div>
        <div class="form-group row">
            <label for="last_name" class="col-sm-4 col-form-label">Last name:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">Your email:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Enter your email">
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-4 col-form-label">Phone:</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="Including country code">
            </div>
        </div>
        <div class="form-group row">
            <label for="password-input1" class="col-sm-4 col-form-label">Set password:</label>
            <div class="col-sm-8">
                <div class="input-group">
                    <input type="password" class="form-control " name="password" id="password-input1" placeholder="Create your password (8 characters min.)">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <a href="#" class="pwdControl ctrl1"></a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-sm-8 offset-sm-4">
                <button type="submit" class="btn btn-primary btn-block mainButton registration__btn">Register</button>
            </div>
        </div>
        <div class="col-12 text-center mt-4">
            We will send you an activation link on the provided email
        </div>
    </form>


</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
