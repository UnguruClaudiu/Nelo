@extends('layouts.master')

@section('content')
<section id="cities">
	<a href="{{ asset('admin') }}">Inapoi la pagina principala</a>
	<a href="{{ asset('admin/newcity') }}">Adauga oras</a>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nume</th>
			<th>Optiuni</th>
		</tr>
		<tbody>
			@foreach ($cities as $city)
			<tr>
				<td>{{ $city->city_id }}</td>
				<td>{{ $city->city_name }}</td>
				<td>
					<a href="{{ asset('admin/editcity/' . $city->city_id) }}">Editeaza!</a>
					<a id="del_city-{{ $city->city_id }}" onclick="delete_data('city', {{ $city->city_id }});">Sterge!</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop