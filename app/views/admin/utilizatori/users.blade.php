@extends('layouts.master')

@section('content')
<section id="users">
	<a href="{{ asset('admin') }}">Inapoi la pagina principala</a>
	<a href="{{ asset('admin/newuser') }}">Adauga administrator hotel</a>
	<table>
			<tr>
				<th>Nume</th>
				<th>Prenume</th>
				<th>login id</th>
				<th>email</th>
				<th>Acces</th>
				<th>Optiuni</th>
			</tr>
		<tbody>
			<tr>
				@foreach ($users['admin'] as $user)
			<tr>
				<td>{{ $user->first_name }}</td>
				<td>{{ $user->last_name }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->email }}</td>
				<td>Admin</td>
				<td>Admin</td>
			</tr>
			@endforeach
			</tr>
			@foreach ($users['administratori'] as $user)
			<tr>
				<td>{{ $user->first_name }}</td>
				<td>{{ $user->last_name }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->email }}</td>
				<td>Administrator {{ $user->hotel_name }}</td>
				<td>
					<a href="{{ asset('admin/deleteuser/' . $user->user_id) }}">Stergere!</a>
				</td>
			</tr>
			@endforeach

			@foreach ($users['clienti'] as $user)
			<tr>
				<td>{{ $user->first_name }}</td>
				<td>{{ $user->last_name }}</td>
				<td>{{ $user->username }}</td>
				<td>{{ $user->email }}</td>
				<td>Client</td>
				<td>
					<a href="{{ asset('admin/deleteuser/' . $user->user_id) }}">Stergere!</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</section>

@stop