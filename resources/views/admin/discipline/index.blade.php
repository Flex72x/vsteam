@extends('admin.layouts.app')

@section('title', 'Дисциплины')

@section('script')

<script>
	var inProgressAddDiscipline = false;
	var inProgressGetDisciplines = false;
	var disciplineId;
	var page = 0;
	var groupId = null;
	var text = null;

	$(document).ready(function() {
		getDisciplines();
	})

	$('#formAddDiscipline').submit(function() {
		if(!inProgressAddDiscipline) {
			inProgressAddDiscipline = true;
			var oldBtn = $('#btnAddDiscipline').html();
			$('#btnAddDiscipline').html('<div class="spinner-border spinner-border-sm text-light" role="status"></div> Отправка..');
			$('#btnAddDiscipline').attr('disabled', true);
			$.ajax({
				url: '{{route('admin.discipline.store')}}',
				method: 'POST',
				data: $('#formAddDiscipline').serialize(),
				success: function(response) {
					getDisciplines();
					inProgressAddDiscipline = false;
					if(response.error) {
						alert('Есть незаполненные поля');
					}
					if(response.success) {
						alert('Success');
					}
					$('#btnAddDiscipline').html(oldBtn);
					$('#btnAddDiscipline').attr('disabled', false);
				}
			});
		}

		return false;
	});

	$('#btnSearch').click(function() {
		page = 0;
		$('#inputPageDisciplines').val(1);
		getDisciplines();
	})

	$('#textSearch').change(function() {
		text = $(this).val();
	})

	$('#groupSearch').change(function() {
		groupId = $('#groupSearch').val();
		page = 0;
		$('#inputPageDisciplines').val(1);
		getDisciplines();
	})

	$('body').on('click', '.disciplineEdit', function() {
		disciplineId = $(this).attr('data-id');
		$('#disciplineEditModal').modal('show');
		$.ajax({
			url: '{{route('admin.discipline.edit')}}',
			method: 'POST',
			data: {id:$(this).attr('data-id')},
			success: function(response) {
				$('#disciplineNameInput').val(response.data.name);
				$('#disciplineGroupSelect option[value='+response.group+']').attr('selected', true);
				$('#disciplineGroupSelect option').not('#disciplineGroupSelect option[value='+response.group+']').attr('selected', false);
			}
		})
	});

	$('#btnSaveDiscipline').click(function() {
		$.ajax({
			url: '{{route('admin.discipline.update')}}',
			method: 'POST',
			data: {id:disciplineId, name: $('#disciplineNameInput').val(), group_id:$('#disciplineGroupSelect').val()},
			success: function(response) {
				$('#disciplineEditModal').modal('hide');
				getDisciplines();
			}
		});
	});

	function getDisciplines() {
		if(!inProgressGetDisciplines) {
			$('#bodyDisciplines').html('<div class="position-absolute top-50 start-50 spinner-border text-light" role="status"></div>');
			$.ajax({
				url: '{{route('admin.discipline.get_disciplines')}}',
				method: 'POST',
				data: {page: page, text: text, group_id: groupId},
				success: function(response) {
					$inProgressGetDisciplines = true;
					$('#bodyDisciplines').html(response.data);
					page == 0 ? $('#btnPrevDisciplines').attr('disabled', true) : $('#btnPrevDisciplines').attr('disabled', false);
					response.end == true ? $('#btnNextDisciplines').attr('disabled', true) : $('#btnNextDisciplines').attr('disabled', false);
				}
			})
		}
	}
</script>

@endsection

@section('content')

	<div class="container-fluid row d-flex justify-content-xxl-start align-items-xxl-start">

		<div class="modal fade" id="disciplineEditModal" tabindex="-1">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalHeader"></h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <div class="mb-3">
		        	<label for="">Название</label>
		        	<input id="disciplineNameInput" type="text" class="form-control">
		        </div>

		        <div class="mb-3">
		        	<label for="">Группа</label>
		        	<select name="group_id" id="disciplineGroupSelect" class="form-select">
						@foreach($groups as $group)
							<option value="{{$group->id}}">{{$group->name}}</option>
						@endforeach
					</select>
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
		        <button type="button" id="btnSaveDiscipline" class="btn btn-primary">Сохранить</button>
		      </div>
		    </div>
		  </div>
		</div>

		<form id="formAddDiscipline" action="" class="col-xxl-4 rounded p-3 m-3" style="background: #4f5b66;">
			<div class="mb-1">
				<label for="name" class="form-label text-white">Название</label>
				<input name="name" id="name" type="text" class="form-control" placeholder="Введите название">
			</div>

			<div class="mb-3">
				<label for="group" class="form-label text-white">Название</label>
				<select name="group_id" id="group" class="form-select">
					<option value=""></option>
					@foreach($groups as $group)
						<option value="{{$group->id}}">{{$group->name}}</option>
					@endforeach
				</select>
			</div>

			<div class="mb-1 text-end">
				<button id="btnAddDiscipline" type="submit" class="btn btn-success">Добавить</button>
			</div>
		</form>

		<div class="col-xxl-5 p-3 rounded m-3 text-white" style="background: #4f5b66;">
				<div class="head_table">
					<div class="row">
						<div class="col-1 col-xxl-2 text-center">ID</div>
						<div class="col-11 col-xxl-3 text-start">Name</div>
						<div class="col-6 col-xxl-3 text-center">Group</div>
						<div class="col-6 col-xxl-4 text-center">Action</div>
						<hr class="my-1">
					</div>
				</div>
				<div class="body_table position-relative" id="bodyDisciplines" style="min-height: 140px;">
					
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
						<select name="" id="groupSearch" class="form-select">
							<option value="">Группы</option>
							@foreach($groups as $group)
								<option value="{{$group->id}}">{{$group->name}}</option>
							@endforeach
						</select>
					</div>
					

					<div class="d-flex flex-row col-12 justify-content-center col-xxl-4 my-2 my-xxl-0">
						<button id="btnPrevDisciplines" class="btn btn-primary">Prev</button>
						<input style="width: 5rem;" type="text" class="form-control mx-2 text-center" id="inputPageDisciplines" value="1">
						<button id="btnNextDisciplines" class="btn btn-primary">Next</button>
					</div>
				</div>
			</div>
		</div>

@endsection