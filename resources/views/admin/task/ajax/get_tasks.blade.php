@foreach($tasks as $task)
	<div class="row my-4">
		<div class="col-1 col-xxl-2 text-center">{{$task->id}}</div>
		<div class="col-1 col-xxl-1"><img class="img-fluid" src="/storage/{{$task->img}}" alt=""></div>
		<div class="col-11 col-xxl-3 text-start">{{$task->title}}</div>
		<div class="col-6 col-xxl-3 text-center">{{$task->disciplines->name}}</div>
		<div class="col-5 col-xxl-2 text-center">
			<a href="" class="btn btn-sm btn-warning taskEdit aDisabled" data-id='{{$task->id}}'><i class="bi bi-pencil"></i></a>
			<a href="" class="btn btn-sm btn-danger taskDelete aDisabled" data-id='{{$task->id}}'><i class="bi bi-trash"></i></a>
		</div>
	</div>
@endforeach