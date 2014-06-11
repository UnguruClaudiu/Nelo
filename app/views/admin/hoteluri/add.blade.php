@extends('layouts.master')

@section('content')
<section>
	<p>Adauga hotel nou</p>
	<a href="{{ asset('admin/hotels') }}"><button>Inapoi la hoteluri</button></a>

	<form method="post" enctype="multipart/form-data" name="admin_edit_hotel">
		<p>Nume Hotel: <input type="text" name="hotel_name" /></p>
		<p>Numar de stele: <label id="starHalf"></label>
		<p>Descriere <textarea name="description"></textarea> </p>
		<div class="images">
			<div class="image">
				<label for="hotel_image">Imagine</label>
				<input type="file" name="hotel_image[]">
			</div>
		</div>
		<input type='button' onclick='addImages()' value='Adauga alte imagini'/>
		<p>Tipul de camera
			<div class="selecteaza_camere">
				<div class="camera">
					<a href="{{asset ('admin/newtype?modal') }}" class="add-room-type-fancybox fancybox.ajax"></a>
					<select id="tip[]" name="tip[]" onchange="showAddNewRoomType(this)" class="types">
						<option value="" selected="selected">Selectati tipul de camera</option>
						<option value="add_room">Adauga un nou tip</option>
						@foreach ($data['types_of_room'] as $type)
						<option value="{{ $type->type_id }}" title="{{ $type->description }}">{{ $type->type_name }}</option>
						@endforeach
					</select><br>
					Numarul total de camere de acest tip: <input type="text" name="total_camere[]" />
					Pret pe noapte: <input type="text" name="pret[]" /><br>
					<label for="room_image">Imagine</label>
					<input type="file" name="room_image[]" >
				</div>
			</div>
			<input type='button' onclick='add_camera()' value='Adauga alt tip de camera'/>
		</p>
		
		<p>Oras: 
			<div class="selecteaza_oras">
				<a href="{{asset ('admin/addcity?modal') }}" class="add-city-fancybox fancybox.ajax"></a>
				<select id="oras" name="oras" onchange="showAddNewCity(this)" class="cities">
					<option value="" selected="selected">Selectati Orasul</option>
					<option value="add_city">Adauga oras</option>
					@foreach ($data['orase'] as $oras)
					<option value="{{ $oras->city_id }}">{{ $oras->city_name }}</option>
					@endforeach
				</select>
			</div>
		</p>
		<p>Facilitati: 
			<div class="selecteaza_facilitati">
				<div class="facilitate">
					<a href="{{asset ('admin/addfacility?modal') }}" class="add-facility-fancybox fancybox.ajax"></a>
					<select id="facilitate[]" name="facilitate[]" onchange="showAddNewFacility(this)" class="facilities">
						<option value="" selected="selected">Selectati facilitate</option>
						<option value="add_facility">Adauga facilitate</option>
						@foreach ($data['facilities'] as $facility)
						<option value="{{ $facility->facility_id }}">{{ $facility->facility_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<input type='button' onclick='add_facilitate()' value='Adauga alta facilitate'/>
		</p>
		<input type="submit" class="button" value="Adauga" >
	</form>
</section>

@stop