<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="/css/admin/bootstrap.min.css">
	<link rel="stylesheet" href="/css/admin/bootstrap-icons.css">
	<link rel="stylesheet" href="/css/admin/styles.css">
	<title>Авторизация</title>
</head>
<body>
	<div class="row login-main d-flex justify-content-center align-items-start m-0">
		<form id="formLogin" action="" class="col-10 col-lg-4 col-xxl-2 p-3 rounded text-white m-5">
			<div class="mb-2 text-center lead fw-bold">
				Login
			</div>

			<div id="error" class="mb-2 text-danger">
				
			</div>

			<div class="mb-2">
				<label for="login" class="form-label">Username</label>
				<input id="login" name="login" type="text" class="form-control" placeholder="ivan_ivanov">
			</div>

			<div class="mb-2">
				<label for="password" class="form-label">Password</label>
				<input id="password" name="password" type="password" class="form-control" placeholder="*********">
			</div>

			<div class="mb-2">
				<div class="form-check">
				  <input class="form-check-input" name="rememberMe" type="checkbox" value="1" id="flexCheckDefault">
				  <label class="form-check-label" for="flexCheckDefault">
				    Запомнить?
				  </label>
				</div>
			</div>	

			<div class="text-center">
				<button id="btnLogin" class="btn btn-success px-4" type="submit">Войти</button>
			</div>
		</form>
	</div>
	
	<script src="/js/admin/jquery-3.6.0.min.js"></script>
	<script src="/js/admin/scripts.js"></script>
	<script src="/js/admin/bootstrap.min.js"></script>

	<script>
		function validate(input, truefalse=true) {
			if(truefalse) {
				input.addClass('is-valid');
				input.removeClass('is-invalid');
			} else {
				input.addClass('is-invalid');
				input.removeClass('is-valid');
			}
		}

		var inProgress = false;
		var btnLogin = $('#btnLogin');
		var inputLogin = $('#login')
		var inputPassword = $('#password');
		var error = $('#error');

		$('#formLogin').submit(function() {
			if(!inProgress) {
				var oldBtn = $('#btnLogin').html();
				btnLogin.html('<div class="spinner-border spinner-border-sm text-light" role="status"></div> Отправка..');
				btnLogin.attr('disabled', true);
				var formData = $('#formLogin').serialize();
				$.post("{{route('user.login-post')}}",formData, function(response) {
					if(response.success) {
						validate(inputLogin);
						validate(inputPassword);
						error.html('');
						window.location.href = "{{route('admin.index')}}";
					} else {
						btnLogin.html(oldBtn);
						btnLogin.attr('disabled', false);
						validate(inputLogin, false);
						validate(inputPassword, false);
						error.html('Неверный логин или пароль');
					}
				});
			}
			return false;
		});
	</script>
</body>
</html>