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

<div class="container">
    <div class="thankyou">
        <h1 class="text-center mb-4">Thank you for registering!</h1>
        <p>Please check your email inbox for the message we have just sent to the address you have provided. You need to open this email and click on the link in it to activate your registration.</p>
        <p>If you did not receive our email, please check your Junk (Spam) folder.</p>
        <p>If you still didn’t receive our message, please send us a direct email to <a href="mailto:office@houzer.uk">office@houzer.uk</a> including your full name, and the problem description:</p>
        <p>“I haven’t received my activation link”.</p>
        <div class="thankyou__img"></div>
    </div>
</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
</body>
</html>
