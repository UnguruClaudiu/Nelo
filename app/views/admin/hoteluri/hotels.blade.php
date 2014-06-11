@extends('layouts.master')

@section('content')
<section id="content">
	<a href="{{ asset('admin') }}">Înapoi la pagina principală</a>
	<a href="{{ asset('admin/newhotel') }}">Adăugaţi un hotel nou</a>
	<table>
		<tr>
			<th>Id</th>
			<th>Nume Hotel</th>
			<th>Număr de stele</th>
			<th>Descriere</th>
			<th>Opţiuni</th>
		</tr>
		<tbody>
			@foreach ($hotels as $hotel)
			<tr>
				<td>{{ $hotel->hotel_id }}</td>
				<td>{{ $hotel->hotel_name }}</td>
				<td>{{ $hotel->hotel_stars }}</td>
				<td>{{ $hotel->hotel_description }}</td>
				<td>
					<a href="{{ asset('admin/edithotel/' . $hotel->hotel_id) }}">Editaţi</a>
					<a href="{{ asset('admin/deletehotel/' . $hotel->hotel_id) }}">Ştergeţi</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop