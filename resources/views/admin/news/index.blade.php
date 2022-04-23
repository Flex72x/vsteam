@extends('admin.layouts.app')

@section('title', 'Новости')

@section('link')


@endsection

@section('script')
	<script src='/CKEditor5/build/ckeditor.js'></script>
	<script>
		var addNewsEditor;
		var editNewsEditor;

		ClassicEditor.create(document.getElementById('text')).then(newEditor => {
			addNewsEditor = newEditor;
		});
		ClassicEditor.create(document.getElementById('newsEditTextarea')).then(newEditor => {
			editNewsEditor = newEditor;
		});

		var inProgressNews = false;
		var inProgressAddNews = false;
		var page = 0;
		var text = '';
		var newsId;

		$(document).ready(function() {
			getNews();
		});

		$('#formAddNews').submit(function() {
			if(!inProgressAddNews) {
				inProgressAddNews = true;
				var formData = new FormData(this);
				var oldBtn = $('#btnAddNews').html();
				$('#btnAddNews').html('<div class="spinner-border spinner-border-sm text-light" role="status"></div> Отправка..');
				$('#btnAddNews').attr('disabled', true);
				$.ajax({
					url:"{{route('admin.news.store')}}",
					method: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
						inProgressAddNews = false;
						$('#btnAddNews').html(oldBtn);
						$('#btnAddNews').attr('disabled', false);
						if(response.error) {
							alert('Есть незаполненные поля');
						} else {
							getNews();
						}
					}
				});
			}

			return false;
		})

		$('#btnSearch').click(function() {
			text = $('#textSearch').val();
			page = 0;
			getNews();
		});

		$('#btnPrevNews').click(function() {
			page--;
			getNews();
		});

		$('#btnNextNews').click(function() {
			page++;
			getNews();
		});

		$('body').on('click', '.newsDelete', function() {
			newsId = $(this).attr('data-id');
			$.ajax({
				method: 'POST',
				data: {id:newsId},
				url: '{{route('admin.news.delete')}}',
				success: function(response) {
					getNews();
				}
			});
		});

		$('body').on('click', '.newsEdit', function() {
			newsId = $(this).attr('data-id');
			$.ajax({
				method: 'POST',
				data: {id:newsId},
				url: '{{route('admin.news.edit')}}',
				success: function(response) {
					$('#newsEditModal').modal('show');
					$('#newsEditForm input[name=title]').val(response.data.title);
					$('#newsEditForm textarea[name=description]').val(response.data.description);
					editNewsEditor.setData(response.data.text);
					$('#newsEditForm img').attr('src', '/storage/'+response.data.img);
				}
			});
		});

		$('#btnUpdateNews').click(function() {
			var formData = new FormData();
			formData.append('id', newsId);
			formData.append('title', $('#newsEditForm input[name=title]').val());
			formData.append('description', $('#newsEditForm textarea[name=description]').val());
			formData.append('text', editNewsEditor.getData());
			if($('#newsEditForm input[name=img]').val()) {
				formData.append('img', $('#newsEditForm input[name=img]')[0].files[0]);
			}
			$.ajax({
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				url: '{{route('admin.news.update')}}',
				success: function(response) {
					$('#newsEditModal').modal('hide');
					getNews();
				}
			});
		});

		function getNews() {
			if(!inProgressNews) {
				inProgressNews = true;
				$('#bodyNews').html('<div class="position-absolute top-50 start-50 spinner-border text-light" role="status"></div>');
				$.ajax({
					url: "{{route('admin.news.get_news')}}",
					method: "POST",
					data: {page: page, text: text},
					success: function(response) {
						page == 0 ? $('#btnPrevNews').attr('disabled', true) : $('#btnPrevNews').attr('disabled', false);
						response.end == true ? $('#btnNextNews').attr('disabled', true) : $('#btnNextNews').attr('disabled', false);
						inProgressNews = false;
						$('#bodyNews').html(response.data);
					}
				});
			}
		}
	</script>
@endsection

@section('content')

	<div class="container-fluid row d-flex justify-content-xxl-start align-items-xxl-start">

		<div class="modal fade" id="newsEditModal" tabindex="-1">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalHeader"></h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form action="" id='newsEditForm'>
		        	<div class="mb-3">
		        		<label for="inputEditImg"><img src="" alt="" class="img-fluid w-50" style="min-height: 50px; min-width: 50px;"></label>
		        		<input id="inputEditImg" type="file" class="d-none" name="img">
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Заголовок</label>
		        		<input type="text" name='title' class="form-control">
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Описание</label>
		        		<textarea name="description" class="form-control"></textarea>
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Текст</label>
		        		<textarea name="text" id="newsEditTextarea" cols="30" rows="10" class="form-control">
		        			
		        		</textarea>
		        	</div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
		        <button type="button" id="btnUpdateNews" class="btn btn-primary">Обновить</button>
		      </div>
		    </div>
		  </div>
		</div>

		<form id="formAddNews" action="" class="col-xxl-6 rounded p-3 m-3" style="background: #4f5b66;">
			<div class="mb-1">
				<label for="title" class="form-label text-white">Заголовок</label>
				<input name="title" id="title" type="text" class="form-control" placeholder="Введите заголовок">
			</div>

			<div class="mb-1">
				<label for="description" class="form-label text-white">Описание</label>
				<textarea name="description" id="description" placeholder="Введите описание" class="form-control" rows="3"></textarea>
			</div>

			<div class="mb-1">
				<label for="text" class="form-label text-white">Текст</label>
				<textarea name="text" id="text" placeholder="Введите текст" class="form-control" rows="15"></textarea>
			</div>

			<div class="mb-2">
				<label for="img" class="form-label text-white">Превью</label>
				<input id="img" type="file" name="img" class="form-control">
			</div>

			<div class="mb-1 text-end">
				<button id="btnAddNews" type="submit" class="btn btn-success">Опубликовать</button>
			</div>
		</form>

		<div class="col-xxl-5 p-3 m-3 text-white" style="background: #4f5b66;">
			<div class="head_table">
				<div class="row">
					<div class="col-1">ID</div>
					<div class="col-3">Img</div>
					<div class="col-5">Title</div>
					<div class="col-3">Action</div>
					<hr class="my-1">
				</div>
			</div>

			<div class="body_table position-relative" style="min-height: 140px;" id="bodyNews">
				
			</div>

			<hr class="my-1">
			<div class="footer_table d-flex flex-row justify-content-xxl-between">
				<div class="input-group mx-2 w-50">
					<input id="textSearch" type="text" class="form-control" placeholder="Новое оборудование..">
					<button id="btnSearch" class="btn btn-primary"><i class="bi bi-search"></i></button>
				</div>

				<div class="d-flex flex-row mx-2">
					<button id="btnPrevNews" class="btn btn-primary">Prev</button>
					<input style="width: 5rem;" type="text" class="form-control mx-2 text-center" id="inputPageNews" value="1">
					<button id="btnNextNews" class="btn btn-primary">Next</button>
				</div>
			</div>
		</div>
	</div>
	
@endsection