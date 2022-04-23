@extends('admin.layouts.app')

@section('title', 'Группы')

@section('script')
	<script>
		var inProgressAddGroup = false;
		var btnAddGroup = $('#btnAddGroup');
		$('#formAddGroup').submit(function() {
			if(!inProgressAddGroup) {
				inProgressAddGroup = true;
				var oldBtn = btnAddGroup.html();
				btnAddGroup.html('<div class="spinner-border spinner-border-sm text-light" role="status"></div> Отправка..');
				btnAddGroup.attr('disabled', true);
				var formData = $('#formAddGroup').serialize();
				$.post("{{route('admin.group.store')}}", formData, function(response) {
					console.log(response);
					inProgressAddGroup = false;
					btnAddGroup.html(oldBtn);
					btnAddGroup.attr('disabled', false);
					if(response.success) {
						getGroups();
					}
				});
			}
			return false;
		});

		var inProgressGroups = false;
		var inputPageGroups = $('#inputPageGroups');
		var bodyGroups = $('#bodyGroups');
		var page = 0;
		var text = null;
		var idGroup = null;

		function getGroups() {
			if(!inProgressGroups) {
				inProgressGroups = true;
				bodyGroups.html('<div class="position-absolute top-50 start-50 spinner-border text-light" role="status"></div>')
				$.post("{{route('admin.group.get_groups')}}", {page:page, text:text}, function(response) {
					page == 0 ? $('#btnPrevGroups').attr('disabled', true) : $('#btnPrevGroups').attr('disabled', false);
					response.end == true ? $('#btnNextGroups').attr('disabled', true) : $('#btnNextGroups').attr('disabled', false);
					bodyGroups.html(response.data);
					inProgressGroups = false;
				});
			}
		}

		$(document).ready(function() {
			getGroups();
		});

		$('#btnPrevGroups').click(function() {
			page--;
			inputPageGroups.val(page+1);
			getGroups();
		})

		$('#btnNextGroups').click(function() {
			page++;
			inputPageGroups.val(page+1);
			getGroups();
		})

		$('#inputPageGroups').change(function() {
			page = inputPageGroups.val()-1;
			getGroups();
		})

		$('#textSearch').change(function() {
			text = $(this).val();
		});

		$('#btnSearch').click(function() {
			page = 0;
			$('#inputPageGroups').val(0+1);
			getGroups();
		});

		$('body').on('click', '.groupEdit', function() {
			idGroup = $(this).attr('data-id');
			$.post("{{route('admin.group.edit')}}", {id:idGroup}, function(response) {
				$('#groupEditForm').modal('show');
				$('#modalHeader').html(response.data.name);
				$('#groupNameInput').val(response.data.name);
			});
		});

		$('body').on('click', '#btnSaveGroup', function() {
			$.post("{{route('admin.group.update')}}", {id:idGroup, name:$('#groupNameInput').val()}, function(response) {
				$('#groupEditForm').modal('hide');
				getGroups();
			});
		});

		$('body').on('click', '.groupDelete', function() {
			idGroup = $(this).attr('data-id');
			$.post("{{route('admin.group.delete')}}", {id:idGroup}, function(response) {
				getGroups();
			});
		});
	</script>
@endsection

@section('content')
	<div class="container-fluid row d-flex justify-content-xxl-start align-items-xxl-start">

		<div class="modal fade" id="groupEditForm" tabindex="-1">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="modalHeader"></h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      </div>
		      <div class="modal-body">
		        <div class="mb-3">
		        	<label for="">Название</label>
		        	<input id="groupNameInput" type="text" class="form-control">
		        </div>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
		        <button type="button" id="btnSaveGroup" class="btn btn-primary">Сохранить</button>
		      </div>
		    </div>
		  </div>
		</div>

		<form id="formAddGroup" class="col-xxl-3 rounded p-3 text-white m-3" style="background: #4f5b66;">
			<div class="mb-2 text-center lead fw-bold">
				Add group
			</div>

			<div class="mb-3">
				<label for="name" class="form-label">Group name</label>
				<input name="name" id="name" type="text" class="form-control" placeholder="ИСП-2-19">
			</div>

			<div class="mb-3 text-end">
				<button id="btnAddGroup" type="submit" class="btn btn-success">Добавить группу</button>
			</div>
		</form>

		<div class="col-xxl-6 p-3 rounded m-3 text-white" style="background: #4f5b66;">
			<div class="head_table">
				<div class="row">
					<div class="col-2">ID</div>
					<div class="col-3">Name</div>
					<div class="col-3">Slug</div>
					<div class="col-4">Action</div>
					<hr class="my-1">
				</div>
			</div>
			<div class="body_table position-relative" id="bodyGroups" style="min-height: 140px;">
				
			</div>
			<hr>
			<div class="footer_table d-flex justify-content-between align-items-center">
				<div class="input-group mx-2 w-25">
					<input id="textSearch" type="text" class="form-control" placeholder="ИСП-2-19">
					<button id="btnSearch" class="btn btn-primary"><i class="bi bi-search"></i></button>
				</div>
				<div class="d-flex flex-row mx-2">
					<button id="btnPrevGroups" class="btn btn-primary">Prev</button>
					<input style="width: 5rem;" type="text" class="form-control mx-2 text-center" id="inputPageGroups" value="1">
					<button id="btnNextGroups" class="btn btn-primary">Next</button>
				</div>
			</div>
		</div>
	</div>
@endsection