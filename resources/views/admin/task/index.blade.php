@extends('admin.layouts.app')

@section('title', 'Раделы')

@section('script')

<script src='/CKEditor5/build/ckeditor.js'></script>
<script>
	var inProgressAddTask = false;
	var inProgressGetTasks = false
	var page = 0;
	var text = 0;
	var disciplineId;
	var taskId;

	var addTaskEditor;
	var editTaskEditor;

	ClassicEditor.create(document.getElementById('taskAddTextarea')).then(newEditor => {
		addTaskEditor = newEditor;
	});

	ClassicEditor.create(document.getElementById('taskEditTextarea')).then(newEditor => {
		editTaskEditor = newEditor;
	});

	$(document).ready(function() {
		getTasks();
	});

	$('#formAddTask').submit(function() {
		if(!inProgressAddTask) {
			var formData = new FormData(this)
			inProgressAddTask = true;
			var oldBtn = $('#btnAddTask').html();
			$('#btnAddTask').html('<div class="spinner-border spinner-border-sm text-light" role="status"></div> Отправка..');
			$('#btnAddTask').attr('disabled', true);
			$.ajax({
				url: '{{route('admin.task.store')}}',
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					getTasks();
					inProgressAddTask = false;
					if(response.error) {
						alert('Есть незаполненные поля');
					}
					if(response.success) {
						alert('Success');
					}
					$('#btnAddTask').html(oldBtn);
					$('#btnAddTask').attr('disabled', false);
				}
			});
		}

		return false;
	});

	$('body').on('click', '.taskDelete', function() {
		$.post('{{route('admin.task.delete')}}', {id:$(this).attr('data-id')}, function(response) {

		});
		getTasks();
	});

	$('body').on('click', '.taskEdit', function() {
		taskId = $(this).attr('data-id');
		$.ajax({
			method: 'POST',
			data: {id:taskId},
			url: '{{route('admin.task.edit')}}',
			success: function(response) {
				$('#taskEditModal').modal('show');
				$('#taskEditForm input[name=title]').val(response.data.title);
				editTaskEditor.setData(response.data.text);
				$('#imgEditForm').attr('src', '/storage/'+response.data.img);
				$('#taskEditForm select option[value='+response.data.discipline_id+']').attr('selected', true);
				$('#taskEditForm select option').not('#taskEditForm select option[value='+response.data.discipline_id+']').attr('selected', false);
				response.data.type == 1 ? ($('#flexRadioDefault1').attr('checked', true), $('#flexRadioDefault2').attr('checked', false)) : ($('#flexRadioDefault1').attr('checked', false), $('#flexRadioDefault2').attr('checked', true));
			}
		});
	});

	$('#btnUpdateTask').click(function() {
			var formData = new FormData();
			formData.append('id', taskId);
			formData.append('title', $('#taskEditForm input[name=title]').val());
			formData.append('text', editTaskEditor.getData());
			formData.append('discipline_id', $('#taskEditForm select').val());
			formData.append('type', $('#taskEditForm input[name=type]').val());
			if($('#taskEditForm input[name=img]').val()) {
				formData.append('img', $('#taskEditForm input[name=img]')[0].files[0]);
			}
			$.ajax({
				method: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				url: '{{route('admin.task.update')}}',
				success: function(response) {
					$('#taskEditModal').modal('hide');
					getTasks();
				}
			});
		});

	function getTasks() {
		if(!inProgressGetTasks) {
			inProgressGetTasks = true;
			$('#bodyTasks').html('<div class="position-absolute top-50 start-50 spinner-border text-light" role="status"></div>');
			$.ajax({
				url: '{{route('admin.task.get_tasks')}}',
				method: 'POST',
				data: {page: page, text: text, discipline_id: disciplineId},
				success: function(response) {
					inProgressGetTasks = false;
					$('#bodyTasks').html(response.data);
					page == 0 ? $('#btnPrevTasks').attr('disabled', true) : $('#btnPrevTasks').attr('disabled', false);
					response.end == true ? $('#btnNextTasks').attr('disabled', true) : $('#btnNextTasks').attr('disabled', false);
				}
			})
		}
	}
</script>

@endsection

@section('content')

	<div class="container-fluid row d-flex justify-content-xxl-start align-items-xxl-start">

		<div class="modal fade" id="taskEditModal" tabindex="-1">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalHeader"></h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <form action="" id='taskEditForm'>
		        	<div class="mb-3">
		        		<label for="inputEditImg"><img id="imgEditForm" src="" alt="" class="img-fluid w-50" style="min-height: 50px; min-width: 50px;"></label>
		        		<input id="inputEditImg" type="file" class="d-none" name="img">
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Заголовок</label>
		        		<input type="text" name='title' class="form-control">
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Дисциплина</label>
		        		<select name='discipline_id' class="form-select">
		        			@foreach($disciplines as $discipline)
								<option value="{{$discipline->id}}">{{$discipline->name}} ({{$discipline->groups->name}})</option>
							@endforeach
		        		</select>
		        	</div>

		        	<div class="mb-3">
		        		<div class="form-check">
						  <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value='1'>
						  <label class="form-check-label" for="flexRadioDefault1">
						    Лекция
						  </label>
						</div>
						<div class="form-check">
						  <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="2">
						  <label class="form-check-label" for="flexRadioDefault2">
						    Практика
						  </label>
						</div>
		        	</div>

		        	<div class="mb-3">
		        		<label for="" class="form-label">Текст</label>
		        		<textarea name="text" id="taskEditTextarea" cols="30" rows="10" class="form-control">
		        			
		        		</textarea>
		        	</div>
		        </form>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
		        <button type="button" id="btnUpdateTask" class="btn btn-primary">Обновить</button>
		      </div>
		    </div>
		  </div>
		</div>

		<form id="formAddTask" action="" class="col-xxl-6 rounded p-3 m-3" style="background: #4f5b66;">
			<div class="mb-1">
				<label for="title" class="form-label text-white">Заголовок</label>
				<input name="title" id="title" type="text" class="form-control" placeholder="Введите заголовок">
			</div>

			<div class="mb-3">
				<label for="type" class="form-label text-white">Тип</label>
				<select name="type" id="type" class="form-select">
					<option value="1">Лекция</option>
					<option value="2">Задание</option>
				</select>

			</div>

			<div class="mb-3">
				<label for="group" class="form-label text-white">Дисциплина</label>
				<select name="discipline_id" id="group" class="form-select">
					<option value=""></option>
					@foreach($disciplines as $discipline)
						<option value="{{$discipline->id}}">{{$discipline->name}} ({{$discipline->groups->name}})</option>
					@endforeach
				</select>
			</div>

			<div class="mb-3">
				<label for="" class="form-label text-white">Текст</label>
		        <textarea name="text" id="taskAddTextarea" cols="30" rows="10" class="form-control">
		        			
		        </textarea>
			</div>

			<div class="mb-2">
				<label for="img" class="form-label text-white">Превью</label>
				<input id="img" type="file" name="img" class="form-control">
			</div>

			<div class="mb-1 text-end">
				<button id="btnAddTask" type="submit" class="btn btn-success">Добавить</button>
			</div>
		</form>

		<div class="col-xxl-5 p-3 rounded m-3 text-white" style="background: #4f5b66;">
				<div class="head_table">
					<div class="row">
						<div class="col-1 col-xxl-2 text-center">ID</div>
						<div class="col-1 col-xxl-1">Img</div>
						<div class="col-11 col-xxl-3 text-start">Name</div>
						<div class="col-6 col-xxl-3 text-center">Discipline</div>
						<div class="col-5 col-xxl-3 text-center">Action</div>
						<hr class="my-1">
					</div>
				</div>
				<div class="body_table position-relative" id="bodyTasks" style="min-height: 140px;">
					
				</div>
				<hr>
				<div class="footer_table d-flex row my-2 justify-content-xxl-center">
					<div class=" col-12 col-xxl-4 my-2 my-xxl-0">
						<div class="input-group">
							<input id="textSearch" type="text" class="form-control" placeholder="МДК 05.01">
							<button id="btnSearch" class="btn btn-primary"><i class="bi bi-search"></i></button>
						</div>
					</div>
					

					<div class=" col-12 col-xxl-3 my-2 my-xxl-0">
						<select name="" id="disciplineSearch" class="form-select">
							<option value="">Дициплины</option>
							@foreach($disciplines as $discipline)
								<option value="{{$discipline->id}}">{{$discipline->name}}</option>
							@endforeach
						</select>
					</div>
					

					<div class="d-flex flex-row col-12 justify-content-center col-xxl-4 my-2 my-xxl-0">
						<button id="btnPrevTasks" class="btn btn-primary">Prev</button>
						<input style="width: 5rem;" type="text" class="form-control mx-2 text-center" id="inputPageTasks" value="1">
						<button id="btnNextTasks" class="btn btn-primary">Next</button>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection