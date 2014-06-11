@extends('layouts.master')

@section('content')
<section id="hotel_details">
    <h3>Detalii despre {{ $details['hotel'][0]->hotel_name }}:</h3>

    <button id="chart_button" onclick="getInterval({{ $details['hotel'][0]->hotel_id }});">Vizualizaţi gradul de ocupare pe intervalul căutat</button>
	
	<div id="chart" style="min-width: 500px; height: 400px; margin: 0 auto; display: none;"></div>

    <div class="detalii">
        <p><b>Oras:</b> {{$details['cities'][0]->city_name}} </p>
        <p><b>Facilităţi:</b>
            @foreach ($details['facilities'] as $facility)
            {{ $facility->facility_name }} &nbsp;&nbsp; 
            @endforeach
        </p>
        <p>Tipuri de cameră: <br>
            @foreach ($details['room_types'] as $type)
            <b>{{ $type->type_name }}</b>: {{ $type->description }}<br> 
                @foreach ($details['room_images'] as $image)        
                    @if ($type->type_id == $image->belong_room_type)
						<div class="room_type" style="background-image: url({{ asset($image->path) }});"></div>
                    @endif
                @endforeach
            @endforeach
        </p>

        <a href="{{ asset('rezervare/index/' . $details['hotel'][0]->hotel_id)}}">Rezervaţi</a>
    </div>
	
</section>
@stop