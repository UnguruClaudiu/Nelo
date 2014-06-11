@extends('layouts.master')

@section('content')
<section id="rooms">
	<a href="{{ asset('admin') }}">Inapoi la pagina principala</a>
	<a href="{{ asset('admin/newroom') }}">Adauga un nou tip</a>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Tip</th>
			<th>Descriere</th>
			<th>Nr. de persoane</th>
			<th>Optiuni</th>
		</tr>
		
		<tbody>
			@foreach ($rooms as $room)
			<tr>
				<td>{{ $room->type_id }}</td>
				<td>{{ $room->type_name }}</td>
				<td>{{ $room->description }}</td>
				<td>{{ $room->pers }}</td>
				<td>
					<a href="{{ asset('admin/editroom/' . $room->type_id) }}">Editeaza!</a>
					<a id="del_room-{{ $room->type_id }}" onclick="delete_data('room', {{ $room->type_id }});">Sterge!</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop