@extends('layouts.master')

@section('content')
<section id="administrator">
	<p>Administratorul de hotel se ocupa de administrarea hotelului caruia ii apartine</p>

	<h3>Detalii hotel</h3>
	<table border="1">
		<tr>
			<th>Id</th>
			<th>Nume Hotel</th>
			<th>Numar de stele</th>
			<th>Descriere</th>
			<th>Optiuni</th>
		</tr>
		<tbody>
			<tr>
				<td>{{ $hotel[0]->hotel_id }}</td>
				<td>{{ $hotel[0]->hotel_name }}</td>
				<td>{{ $hotel[0]->hotel_stars }}</td>
				<td>{{ $hotel[0]->hotel_description }}</td>
				<td>
					<a href="{{ asset('admin/edithotel/' . $hotel[0]->hotel_id) }}">Editare</a>
					<a href="{{ asset('admin/deletehotel/' . $hotel[0]->hotel_id) }}">Stergere</a>
				</td>
			</tr>
		</tbody>
	</table>

	<h3>Rezervari:</h3>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nume client</th>
			<th>Hotel</th>
			<th>De la data</th>
			<th>Pana la data</th>
			<th>Statut</th>
			<th>Optiuni</th>
		</tr>
		<tbody>
			@foreach ($rezervations as $rez)
			<tr>
				<td>{{ $rez->booking_id }}</td>
				<td>{{ $rez->first_name }} {{ $rez->last_name }}</td>
				<td>{{ $rez->hotel_name }}</td>
				<td>{{ $rez->from_date }}</td>
				<td>{{ $rez->to_date }}</td>
				<td>{{ $rez->status }}</td>
				<td>
					@if ($rez->status != 'Anulat')
						<a href="{{ asset('admin/deleterezervation/' . $rez->booking_id) }}">Stergeti</a>
					@endif
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop