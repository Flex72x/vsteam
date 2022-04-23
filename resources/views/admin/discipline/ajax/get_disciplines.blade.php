@foreach($disciplines as $discipline)
	<div class="row my-4">
		<div class="col-1 col-xxl-2 text-center">{{$discipline->id}}</div>
		<div class="col-11 col-xxl-3 text-start">{{$discipline->name}}</div>
		<div class="col-6 col-xxl-3 text-center">{{$discipline->groups->name}}</div>
		<div class="col-6 col-xxl-4 text-center">
			<a href="" class="btn btn-sm btn-warning disciplineEdit aDisabled" data-id='{{$discipline->id}}'><i class="bi bi-pencil"></i></a>
			<a href="" class="btn btn-sm btn-danger disciplineDelete aDisabled" data-id='{{$discipline->id}}'><i class="bi bi-trash"></i></a>
		</div>
	</div>
@endforeach