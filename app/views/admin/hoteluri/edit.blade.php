@extends('layouts.master')

@section('content')
<section id="add_hotel">
	<p>Adauga hotel nou</p>
	<a href="{{ asset('admin/hotels') }}"><button>Inapoi la hoteluri</button></a>

	<form method="post" name="admin_edit_hotel">
		<p>Nume Hotel: <input type="text" value="{{ $hotel['hotel'][0]->hotel_name or ''}} " name="nume" /></p>
		<p>Numar de stele: <input type="text" value="{{ $hotel['hotel'][0]->hotel_stars or ''}} " name="stele" /></p>
		<p>Descriere <textarea name="descriere">{{ $hotel['hotel'][0]->hotel_description or ''}} </textarea> </p>
		<p>Tipul de camera
			<select id="tip" name="tip" >
				<option value="" selected="selected">Selectati tipul de camera</option>
				<option value="add_room" onclick="prompt('Adauga un nou tip de camera','defaultvalue')";>Adauga un nou tip</option>
				@foreach ($data['types_of_room'] as $type)
				<option value="{{ $type->type_id }}" title="{{ $type->description }}">{{ $type->type_name }}</option>
				@endforeach
			</select><br>
			Numarul total de camere de acest tip: <input type="text" value="{{ $hotel['hotel'][0]->total_rooms or ''}} " name="total_camere" />
			Pret pe noapte: <input type="text" value="{{ $hotel['hotel'][0]->average_price or ''}}" name="pret" /><br>
			<button>Adauga alt tip de camere</button>
		</p>
		<p>Regiune: 
			<select id="regiune" name="regiune">
				<option value="" selected="selected">Selectati Regiunea</option>
				<option value="add_region" onclick="prompt('Adauga o regiune noua','defaultvalue')";>Adauga regiune</option>
				@foreach ($data['regions'] as $region)
				<option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
				@endforeach
			</select><br>
		</p>
		<p>Facilitati: <br>
			@foreach ($hotel['facilitati'] as $facilitati)
			<select id="facilitate" name="facilitate">
				<option value="" selected="selected">Selectati facilitate</option>
				<option value="add_facility" onclick="prompt('Adauga o noua facilitate','defaultvalue')";>Adauga facilitate</option>
				@foreach ($data['facilities'] as $facility)
				<option value="{{ $facility->facility_id }} " 
					@if ($facilitati->facility_name == $facility->facility_name)
					selected="selected"
					@endif
					>{{ $facility->facility_name }}</option>
				@endforeach
			</select><br>
			@endforeach
			<button>Adauga alta facilitate</button>
		</p>
		<input type="submit" class="button" value="Adauga" >
	</form>

</section>

@stop