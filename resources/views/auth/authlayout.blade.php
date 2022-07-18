<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ config('app.name') }} | Admin</title>
	<link href="{{ asset('public/frontend') }}/images/1533546995.ico" rel="icon" type="image/x-icon">

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	@if (! config('app.debug', true))
			<link rel="stylesheet" href="{{ assetPath('css/admin-all.css') }}">
	@else
			<!-- Vendors -->
			<link rel="stylesheet" href="{{ assetPath('css/admin-vendor.css') }}">
			<link rel="stylesheet" href="{{ assetPath('css/admin-custom.css') }}">
	@endif

	@yield('css')

</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a href="{{ url('/admin') }}"><b>{{ config('app.name') }}</b></a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">

			@yield('content')

		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<script src="{{ assetPath('js/admin-vendor.js') }} "></script>
	<script src="{{ assetPath('js/admin-validate.js') }} "></script>

	<script>
		$(function () {
			$('input').iCheck({
				checkboxClass: 'icheckbox_square-blue',
				radioClass: 'iradio_square-blue',
				increaseArea: '20%' // optional
			});
		});
	</script>
</body>
</html>
