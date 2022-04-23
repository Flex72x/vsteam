<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
	<link rel="stylesheet" href="/css/ckeditor.css">
	<link rel="stylesheet" href="/css/left-nav-style.css">
	<title>Главная</title>
</head>
<body>

<!-- Шапка -->
<div class="header container-fluid bg-light d-grid align-items-center">
	<div class="row justify-content-center align-items-center">
		<div class="logo col-sm-3 col-12 d-flex justify-content-center align-items-center"><a href="{{route('index')}}"><img src="/img/logo.png" height="80px" alt=""></a></div>
		<div class="row col-12 col-sm-9 justify-content-center align-items-center">
			@foreach ($groups as $group)
			<div class="group col-sm-3 col-4 text-center p-2"><a href="{{route('group.show', ['slug' => $group->slug])}}" class="fw-bold fs-6" href="">{{$group->name}}</a></div>
			@endforeach
		</div>
	</div>
</div>