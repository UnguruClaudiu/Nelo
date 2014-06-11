@extends('layouts.master')

@section('content')
<section id="facilities">
	<a href="{{ asset('admin') }}">Inapoi la pagina principala</a>
	<a href="{{ asset('admin/newfacility') }}">Adauga facilitate</a>
	<table border="1">
		
		<tr>
			<th>ID</th>
			<th>Nume</th>
			<th>Optiuni</th>
		</tr>
		<tbody>
			@foreach ($facilities as $facility)
			<tr>
				<td>{{ $facility->facility_id }}</td>
				<td>{{ $facility->facility_name }}</td>
				<td>
					<a href="{{ asset('admin/editroomfacilities/' . $facility->facility_id) }}">Editeaza!</a>
					<a id="del_facility-{{ $facility->facility_id }}" onclick="delete_data('facility', {{ $facility->facility_id }});">Sterge!</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop