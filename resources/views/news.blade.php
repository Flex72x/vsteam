@include('layouts.header')
<!-- Контент -->
<div class="container justify-content-center d-flex" style="font-family: 'UnitSlab';">
		<div class="row col-sm-10 col-12 " id="main_block" style="">
			<div class="nesting col-12 pb-2 pt-3">
				<i class="bi bi-house-fill"></i>
				<i class="bi bi-arrow-right"></i>
				<a href="index.html" title="Посмотреть все Новости">Новости</a>
				<i class="bi bi-arrow-right"></i>
				{{$news->title}}
			</div>

			<div class="article_block col-12">
				<img src="/storage/{{$news->img}}" width="100%" style="border-radius: 5px;">
				<h1 style="font-weight:bold;">{{$news->title}}</h1>
				<div class="features">
					<div>
						<i class="bi bi-eye-fill"></i> 2 297
					</div>
					<div>
						<i class="bi bi-clock"></i> 01 апреля 2022 в 17:03
					</div>
				</div>
				<div class="text ck-content">
					{!! $news->text !!}
				</div>
			</div>

		</div>
</div>

<!-- Конец Контент -->
@include('layouts.footer')
