<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="/css/admin/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin/bootstrap-icons.css">
	<link rel="stylesheet" href="/css/admin//styles.css">
	<link rel="icon" href="/img/admin/logo.svg" type=" image/svg+xml">
	@yield('link')
	<title>@yield('title')</title>
</head>
<body>
	<div class="main">
		@include('admin.layouts.header')
		@include('admin.layouts.sidebar')
		@include('admin.layouts.footer')
		<div class="content">
			@yield('content')
		</div>
		
	</div>
	
	<script src="/js/admin/jquery-3.6.0.min.js"></script>
	<script src="/js/admin/scripts.js"></script>
	<script src="/js/admin/bootstrap.min.js"></script>

	@yield('script')
</body>
</html>