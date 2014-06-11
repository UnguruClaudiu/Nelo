@extends('layouts.master')

@section('content')
<section id="booking2">
	<form action="" method="post" name="booking_form2">
		<div>
    	<label for="check-in">Dată check-in: {{ Session::get('check_in') }} </label>
        <label for="check-out">Dată check-out: {{ Session::get('check_out') }} </label>
		</div>
		
		<label for="room_type">Selectaţi tipul/tipurile de cameră:</label>
		@foreach ($rooms as $room)
			<label>Tipul de camera: {{ $room->type_name }}</label> 
			<label>Preţ: {{ $room->price_per_room }} RON</label>
			<label>Descriere: {{ $room->description}}</label>
			<label> Disponibile: {{ $room->total_rooms}} </label>
			<div class="room_image" style="background-image: url({{ asset($room->path) }});"></div>
			<label for="number_of_rooms">Număr de camere: </label>
			<input type="number" name="number_of_rooms[]" required min = 0 max ="{{ $room->total_rooms }}" value = "0"/>
			<input type="hidden" name="type_room[]" value="{{ $room->type_id }}" >
		@endforeach

		<input type="submit" value="Următorul" />
	</form>
</section>

@stop