@extends('layouts.master')

@section('content')

<div class="container-wrap">
	<div class="container main-content">
		<div class="parallax_slider_outer">
			<div data-flexible-height="true" data-fullscreen="false" data-autorotate="" data-parallax="true" data-full-width="true" class="nectar-slider-wrap" id="slider">
				<div class="swiper-container" data-loop="true" data-height="725" data-min-height="250" data-arrows="true" data-bullets="true" data-desktop-swipe="true">
					
					<div class="swiper-wrapper">
					
						<div class="swiper-slide" style="background-image: url({{ asset('images/1.jpg') }});" data-bg-alignment="center" data-x-pos="centered" data-y-pos="middle"> 
							<div class="container">
								<div class="content">
									<h2>Radisson Blu Hotel</h2>
									<p><span>Radisson SAS Hotel este situat în centrul oraşului</span></p>
									<div class="buttons">
										<div class="button transparent">
											<a class="extra-color-3" href="#">Detalii hotel</a>
										</div>
										<div class="button solid_color">
											<a class="extra-color-1" href="#">Rezervaţi acum</a>
										</div>
									</div>
								</div>
							</div><!--/container-->
						</div><!--/swiper-slide-->
						
						<div class="swiper-slide" style="background-image: url({{ asset('images/2.jpg') }});" style="background-image: url(img/1.jpg);" data-bg-alignment="center" data-x-pos="centered" data-y-pos="middle"> 
							<div class="container">
								<div class="content">
									<h2>Marshal Garden Hotel</h2>
									<p><span>Situat în Dorobanţi, o zonă rezidenţială centrală din București</span></p>
									<div class="buttons">
										<div class="button transparent">
											<a class="extra-color-3" href="#">Detalii hotel</a>
										</div>
										<div class="button solid_color">
											<a class="extra-color-1" href="#">Rezervaţi acum</a>
										</div>
									</div>
								</div>
							</div><!--/container-->
						</div><!--/swiper-slide-->
						
						<div class="swiper-slide" style="background-image: url({{ asset('images/3.jpg') }});" data-bg-alignment="center" data-x-pos="centered" data-y-pos="middle"> 
							<div class="container">
								<div class="content">
									<h2>Ramada</h2>
									<p><span>Situat în centrul istoric al oraşului Sibiu</span></p>
									<div class="buttons">
										<div class="button transparent">
											<a class="extra-color-3" href="#">Detalii hotel</a>
										</div>
										<div class="button solid_color">
											<a class="extra-color-1" href="#">Rezervaţi acum</a>
										</div>
									</div>
								</div>
							</div><!--/container-->
						</div><!--/swiper-slide-->
						
					</div>
					
					<a href="" class="slider-prev">
						<i class="icon-left-arrow"></i>
						<div class="slide-count">
							<span class="slide-current">1</span>
							<i class="icon-right-line"></i>
							<span class="slide-total"></span>
						</div>
					</a>
					<a href="" class="slider-next">
						<i class="icon-right-arrow"></i>
						<div class="slide-count">
							<span class="slide-current">1</span>
							<i class="icon-right-line"></i>
							<span class="slide-total"></span>
						</div>
					</a>
					<div class="slider-pagination"></div>
				</div> 
			</div>
		</div>
		
		<div id="first_page">
			<section id="search">
				<h3>Căutare:</h3>
				<form action="" method="post" name="search_form">
					<label for="location">Locaţie:</label>
					<input type="text" name="location" id="location" class="location" required />
					
					<label for="check-in">Dată check-in:</label>
					<input type="text" name="check-in" id="txtStartDate" required />
					
					<label for="check-out">Dată check-out:</label>
					<input type="text" name="check-out" id="txtEndDate" required />
					
					<label for="guests">Număr persoane:</label>
					<input type="text" name="guests" required />
					
					<a id="add_options">Adăugaţi opţiuni suplimentare</a>
					<div id="facilities">
						<div id="hotel_facility">
							<label for="facility">Facilităţi hotel:</label>
							<ul>
							@foreach ($data['facilities'] as $facility)
								<li>
									<div class="checkbox">
										<input type="checkbox" id="cbF{{ $facility->facility_id }}" name="facility[]" value="{{ $facility->facility_id }}" /><label for="cbF{{ $facility->facility_id }}"></label>
									</div>
									<label for="cbF{{ $facility->facility_id }}" class="text">{{ $facility->facility_name }}</label>
								</li>
							@endforeach
							</ul>
						</div>
						
						<div id="room_facility">
							<label for="room_facility">Facilităţi cameră:</label>
							<ul>
							@foreach ($data['room_facilities'] as $room_facility)
							<li>
								<div class="checkbox">
									<input type="checkbox" id="cbRF{{ $room_facility->room_facility_id }}" name="room_facility" /><label for="cbRF{{ $room_facility->room_facility_id }}"></label>
								</div>
								<label for="cbRF{{ $room_facility->room_facility_id }}" class="text">{{ $room_facility->room_facility_name }}</label>
							</li>
							@endforeach
							</ul>
						</div>
						<div class="clear"></div>
						<label for="stars">Număr de stele:</label>
						<label type="text" id="starHalf"></label>
					</div>
					
					<input type="submit" value="Căutaţi" />
				</form>
			</section>
			
			<div class="divider"></div>

			<section id="hotels">
				@foreach ($data['hotels'] as $hotel)
				<div class="hotel">
					<h3>{{ $hotel->hotel_name }}</h3>
					<div class="stars">
					@for ($i = 0; $i < $hotel->hotel_stars; $i++)
						<img src="{{ asset('images/star.png') }}" width="30" height="30">
					@endfor
					</div>
					
					<div class="show_images">
						@foreach ($data['hotel_images'] as $image)
							@if( $image->belong_hotel == $hotel->hotel_id)
								<div class="hotel_image" style="background-image: url({{ asset($image->path) }});"></div>
							@endif
						@endforeach 
					</div>
					<h4>Descriere</h4>
					<p>{{ $hotel->hotel_description }}</p>
					
					<div class="last_book"><p>{{ $hotel->last_booking or '' }}</p></div>
					<a href="{{ asset('home/details/' . $hotel->hotel_id) }}">Detalii hotel</a>
					<a href="{{ asset('rezervare/index/' . $hotel->hotel_id) }}" class="gray">Rezervaţi</a>
				</div>
				@endforeach
			</section>
		</div>
	</div>
</div>
@stop