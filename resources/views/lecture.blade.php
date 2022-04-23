@include('layouts.header')
<!-- Контент -->
<input type="checkbox" id="nav-toggle" hidden>

    <nav class="nav">

        <label for="nav-toggle" class="nav-toggle" onclick></label>
        <div>
				<div class="accordion accordion-flush p-3 mt-4" id="accordionFlushExample">
					@foreach ($disciplines as $disciplin)
				  	<div class="accordion-item2 accordion-item">
				    	<h2 class="accordion-header" id="flush-heading{{$disciplin->id}}">
				      	<a class="accordion-button2 accordion-button collapsed"  type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$disciplin->id}}" aria-expanded="false" aria-controls="flush-collapse{{$disciplin->id}}">
				        {{$disciplin->name}}</a>
				    	</h2>
				    	<div id="flush-collapse{{$disciplin->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$disciplin->id}}" data-bs-parent="#accordionFlushExample">

				        <a href="{{route('task.index', ['groupSlug' => $group->slug,'disciplineSlug' => $disciplin->slug, 'typeSlug' => 'practica' ])}}" class="accordion-text2">+ Задания</a><br>
				        <a href="{{route('task.index', ['groupSlug' => $group->slug,'disciplineSlug' => $disciplin->slug, 'typeSlug' => 'lecture' ])}}" class="accordion-text2">+ Лекции</a><br>


				   		</div>
				  	</div>
				  	@endforeach
				</div>
			</div>


    </nav>
<div class="container-fluid" style="font-family: 'UnitSlab';">

	<div class="row " id="main_block">

		<div class="lev-main col-12 col-sm-3 justify-content-center" >

<!-- Левое меню "акардион" -->

			<div class="p-3" style=" box-shadow: 0px 0px 0 1px #f2f2f2; width:250px; height: 100%;">
				<h3 class="widget-tittle">Предметы</h3>
				@foreach ($disciplines as $disciplin)
				<div class="accordion accordion-flush" id="accordionFlushExample">
				  	<div class="accordion-item">
				    	<h2 class="accordion-header" id="flush-heading{{$disciplin->id}}">
				      	<a class="accordion-button collapsed" style="padding: 6px;font-size: .857rem;" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$disciplin->id}}" aria-expanded="false" aria-controls="flush-collapse{{$disciplin->id}}">
				        {{$disciplin->name}}</a>
				    	</h2>
				    	<div id="flush-collapse{{$disciplin->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$disciplin->id}}" data-bs-parent="#accordionFlushExample">

				        <a href="{{route('task.index', ['groupSlug' => $group->slug,'disciplineSlug' => $disciplin->slug, 'typeSlug' => 'practica' ])}}" class="accordion-text">+ Задания</a><br>
				        <a href="{{route('task.index', ['groupSlug' => $group->slug,'disciplineSlug' => $disciplin->slug, 'typeSlug' => 'lecture' ])}}" class="accordion-text">+ Лекции</a><br>


				   		</div>
				  	</div>

				</div>
				@endforeach
			</div>
		</div>

<!-- Основное меню с постами -->
	    <div class="col-12 col-sm-9" style="min-height: 100vh;">

			<div class="row">
				<div class="nesting col-12 pb-2 pt-3 " style="font-size:18px;">
					<i class="bi bi-house-fill"></i>
					<i class="bi bi-arrow-right"></i>
					<a href="{{route('group.show', ['slug' => $group->slug])}}">{{$group->name}}</a>
					<i class="bi bi-arrow-right"></i>
					<a>{{$disciplin->name}}</a>
					<i class="bi bi-arrow-right"></i>
					<a>ЛЕКЦИИ</a>
				</div>
				@foreach ($tasks as $task)
				<div class="col-12 col-sm-6 col-lg-4 d-flex justify-content-center mb-4">
					<div class="post">
						<!-- <img src="/img/1648533712.jpg" height="195" width="100%" alt=""> -->
						<div class="p-4"><div class="post-text"><a href="#" style="font-size: 20px;">{{$task->title}}</a><p style="font-size: 15px;margin-top: 20px;">{!!$task->text!!}</p></div><div class="post-view">57 просмотров</div></div>
					</div>

				</div>
				@endforeach
			</div>
	    </div>
	</div>
</div>


<!-- Конец Контент -->
@include('layouts.footer')
