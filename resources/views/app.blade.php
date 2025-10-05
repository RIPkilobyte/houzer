<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $title }} - Houzer</title>
	<link rel="icon" href="{{ asset('img/favicon.png') }}" />

	<? /*<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">*/ ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="{{ asset('css/all.css') }}">
	<link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.css') }}">
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

	@stack('styles')
</head>
<body>
<div class="wrapper">
	@include('navigation')

	<div class="">
		<section class="content">
			<div class="container">
				<div class="row">
					<div class="col-12 container">
						@if ($errors->any())
							@foreach ($errors->all() as $error)
								<div class="alert alert-danger" role="alert">{{ $error }}</div>
							@endforeach
						@endif
						@if (session('status'))
							<div class="alert alert-primary" role="alert">{{ session('status') }}</div>
						@endif
                        @if (session('success'))
                            <div class="alert alert-success text-center" role="alert"><h3 class="m-0">{{ session('success') }}</h3></div>
                        @endif
						@if (session('error'))
							<div class="alert alert-danger" role="alert">{{ session('error') }}</div>
						@endif

						@yield('content')
					</div>
				</div>
			</div>
		</section>
	</div>

	@include('footer')
</div>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
<script src="{{ asset('js/adminlte.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

@stack('scripts')

</body>
</html>
