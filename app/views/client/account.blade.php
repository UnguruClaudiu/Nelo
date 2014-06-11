@extends('layouts.master')

@section('content')
<section class="client">
	<form method="post" name="login_form">
		<label for="pass">Schimbaţi parola:</label><input type="password" id="pass" name="pass"></input>
		<label for="email">Editaţi adresa de email</label><input type="text" id="email" name="email"></input>
		<label for="first_name">Editaţi numele<input type="text" id="first_name" name="first_name" />
		<label for="last_name">Editaţi prenumele<input name="last_name" type="text" />
		<input type="submit" class="button" value="Editaţi" >
	</form>
	<h3>Rezervările efectuate de dumneavoastră:</h3>
	<div>
		@foreach ($rezervations as $r)
		<p>{{ $r->hotel_name }}</p>
		<p>
			De la data {{ $r->from_date }} până la data {{ $r->to_date }}
			<a href="#">Anulaţi rezervarea</a>
		@endforeach
		</p>
	</div>
</section>

@stop