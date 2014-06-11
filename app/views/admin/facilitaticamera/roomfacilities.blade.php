@extends('layouts.master')

@section('content')
<section id="room_facilities">
	<a href="{{ asset('admin') }}">Inapoi la pagina principala</a>
	<a href="{{ asset('admin/facilitaticamera/createfacility') }}">Adauga facilitate</a>
	<table border="1">
		<tr>
			<th>ID</th>
			<th>Nume</th>
			<th>Optiuni</th>
		</tr>
		<tbody>
			@foreach ($facilities as $facility)
			<tr>
				<td>{{ $facility->room_facility_id }}</td>
				<td>{{ $facility->room_facility_name }}</td>
				<td>
					<a href="{{ asset('admin/facilitaticamera/edit' . $facility->room_facility_id) }}">Editeaza!</a>
					<a id="del_facility-{{ $facility->room_facility_id }}" onclick="delete_data('facility', {{ $facility->room_facility_id }});">Sterge!</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop