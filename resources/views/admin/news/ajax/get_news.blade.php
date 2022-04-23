@foreach($news as $li)
	<div class="row my-2">
		<div class="col-1">{{$li->id}}</div>
		<div class="col-3"><img class="img-fluid w-50" src="/storage/{{$li->img}}" alt=""></div>
		<div class="col-5 text-truncate">{{$li->title}}</div>
		<div class="col-3">
			<a href="" class="btn btn-sm btn-warning newsEdit aDisabled" data-id='{{$li->id}}'><i class="bi bi-pencil"></i></a>
			<a href="" class="btn btn-sm btn-danger newsDelete aDisabled" data-id='{{$li->id}}'><i class="bi bi-trash"></i></a>
		</div>
	</div>
@endforeach