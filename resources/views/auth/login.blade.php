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

<style>
    .header {
        display: none;
    }
</style>

<body class="hold-transition login-page">

<div class="container">

    @include('navigation')
    <div class="login row justify-content-around align-items-center">
        <div class="login__left col-lg-6">
            <div class="login-box">
                <div class="row justify-content-around">
                    <div class="col-10 col-sm-8">
                        <h2 class="login__title">Log in</h2>
                        <p class="login-box-msg"></p>
                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach
                        @endif
                        @if (session('status'))
                        <div class="alert alert-primary" role="alert">{{ session('status') }}</div>
                        @endif

                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <input type="text" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" id="password-input1" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <a href="#" class="pwdControl ctrl1"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-login mainButton btn-block text-bold">Log in</button>
                                </div>
                            </div>
                        </form>
                        <div class="mt-3 text-right">
                            <a href="{{ route('password.request') }}" class="text-white">I forgot my password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10 col-lg-4 mt-5 mt-lg-0">
            <h2>Register your interest</h2>
            <p class="login-reg-text">
                The registration is commitment-free and only allows us to prioritise your needs. You can delete your profile at any time.
            </p>
            <a class="btn btn-login mainButton btn-login-reg" href="{{ route('register') }}">Register</a>
        </div>
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
<script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
