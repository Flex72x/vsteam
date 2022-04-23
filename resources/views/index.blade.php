@include('layouts.header')
<!-- Контент -->
<div class="container-fluid " style="font-family: 'UnitSlab';">
	<div class="row" id="main_block">
		<div class="main1 col-6 col-sm-4" id="news_addoptation" >

			<div class="col-12" style="height:50%;  padding: 0px 10px 10px 10px;">
				<div id="news_block_1" class="news" style="background-image: url(./img/news.jpg);">
					<div class="slideshow-item-text2">
						<div class="test">
				        <h5 >Заголовок</h5>
				        </div>
				    </div>
				</div>
			</div>

			<div class="col-12" style="height:50%; padding: 0px 10px 0px 10px;">
				<div class="news" id="news_block_2" style="background-image: url(./img/news2.jpg);">
					<div class="thumb-wrapper" >
						<div class="slideshow-item-text2">
						<div class="test">
				        <h5 >Заголовок</h5>
				        </div>
				    </div>
					</div>
				</div>
			</div>

		</div>

		<div class="main1 col-6 col-sm-3" id="news_addoptation4">
			<div class="thumb-wrapper" id="news_addoptation2" style="overflow: hidden;">
				<div class="img-box p-2 ">
					<img src="img/news2.jpg" class="img-fluid" alt="">
				</div>
				<div class="thumb-content p-2 ">
					<h4 class="name_news">London don don</h4>
					<div style="overflow: hidden;"><p class="text-ellipsis" style="font-size:20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit.  consectetur adipiscing elit.  consectetur adipiscing eli</p></div>
				</div>
			</div>
		</div>
		<div class="main1 col-12 col-sm-5" id="news_addoptation3" >

		<div style="height: 50%;padding: 0px 10px 10px 10px;">
			<div class="news" id="news_block_2" style="background-image: url(./img/news2.jpg);">
				<div class="thumb-wrapper" >
					<div class="slideshow-item-text2">
						<div class="test">
				    		<h5 >Заголовок</h5>
				    	</div>
				    </div>
				</div>
			</div>
		</div>

		<div class="d-flex" style="height: 50%;">
			<div class="col-5" style=" padding: 0px 0px 0px 10px;">
				<div class="news" id="news_block_2" style="background-image: url(./img/2.jpg);">
					<div class="thumb-wrapper" >
						<div class="slideshow-item-text2">
							<div class="test">
				        		<h5 >Заголовок</h5>
				        	</div>
				    	</div>
					</div>
				</div>
			</div>

			<div style="width: 100%; padding: 0px 10px 0px 10px;">
				<div class="news" id="news_block_2" style="background-image: url(./img/3.jpg);">
					<div class="thumb-wrapper" >
						<div class="slideshow-item-text2">
							<div class="test">
				        		<h5 >Заголовок</h5>
				        	</div>
				    	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
<!-- Конец Контент -->

<!-- БУДЕТ ИНЕТРЕСНО -->
<div class="container " >
	<div class="row">
		<div class="certificate_name_block p-3 text-center col-12 mt-5 mb-3" style="margin: 0px">
			<a>БУДЕТ ИНТЕРЕСНО</a>
		</div>
	</div>
@foreach ($news as $new)

	<a href="news/{{$new->slug}}" style="color:black">
		<div class="row int_block m-2 p-2 ">
			<div class="col-12 col-sm-9">
				<h4 >{{$new->title}}</h4>
				{{$new->description}}
			</div>
			<div class="col-12 col-sm-3">
				<img src="storage/{{$new->img}}" width="100%" alt="">
			</div>
		</div>
	</a>
	<div class="m-2" style="border: 1px solid rgba(114, 195, 171, 0.75);"></div>
@endforeach
</div>




<!-- БУДЕТ ИНЕТРЕСНО END -->

<!-- СЕРТИФИКАТЫ -->
<div class="container mt-5">
	<div class="row">

		<div class="certificate_name_block p-3 text-center col-12">
			<a>СЕРТИФИКАТЫ</a>
		</div>

		<div class="certificate_block col-12 col-sm-6 p-5">
			<div class="certificate">
				<img src="img/certificate.jpg" width="100%" height="100%" alt="">
			</div>
		</div>

		<div class="certificate_block col-12 col-sm-6 p-5">
			<div class="certificate">
				<img src="img/certificate.jpg" width="100%" height="100%" alt="">
			</div>
		</div>

		<div class="certificate_block col-12 col-sm-4 p-5">
			<div class="certificate">
				<img src="img/certificate2.jpg" width="100%" height="100%" alt="">
			</div>
		</div>

		<div class="certificate_block col-12 col-sm-4 p-5">
			<div class="certificate">
				<img src="img/certificate2.jpg" width="100%" height="100%" alt="">
			</div>
		</div>

		<div class="certificate_block col-12 col-sm-4 p-5">
			<div class="certificate">
				<img src="img/certificate2.jpg" width="100%" height="100%" alt="">
			</div>
		</div>

	</div>
</div>
<!-- СЕРТИФИКАТЫ END-->
@include('layouts.footer')
