@extends('layouts.master')

@section('content')
<section id="rezervations">
	<a href="{{ asset('admin') }}">Înapoi la pagina principală</a>
	<table>
		<tr>
			<th>ID</th>
			<th>Nume client</th>
			<th>Hotel</th>
			<th>De la data</th>
			<th>Până la data</th>
			<th>Statut</th>
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
					<a href="{{ asset('admin/deleterezervation/' . $rez->booking_id) }}">Stergeţi</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop