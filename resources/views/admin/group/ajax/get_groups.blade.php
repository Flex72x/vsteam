@foreach($groups as $group)
	<div class="row my-2">
		<div class="col-2">{{$group->id}}</div>
		<div class="col-3">{{$group->name}}</div>
		<div class="col-3">{{$group->slug}}</div>
		<div class="col-4">
			<a href="" class="btn btn-sm btn-warning groupEdit aDisabled" data-id='{{$group->id}}'><i class="bi bi-pencil"></i></a>
			<a href="" class="btn btn-sm btn-danger groupDelete aDisabled" data-id='{{$group->id}}'><i class="bi bi-trash"></i></a>
		</div>
	</div>
@endforeach