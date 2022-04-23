<div class="container-fluid pt-2 pb-2" style="background: #222222;">
	<div class="row justify-content-center pb-3">
		@foreach ($groups as $group)
		<a href="{{route('group.show', ['slug' => $group->slug])}}" class="col-3 col-sm-1 nav-link px-2 text-muted text-center">{{$group->name}}</a>
		@endforeach
	</div>
    <p class="text-center text-muted">&copy; 2022 Company, R.V.S.</p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>