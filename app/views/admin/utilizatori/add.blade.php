@extends('layouts.master')

@section('content')
<section>
	<h3>Adauga administrator hotel</h3>
	<a href="{{ asset('admin/users') }}"><button>Inapoi</button></a>

	<form method="post" name="admin_add_user">
		<p> Nume<input type="text" name="nume" /> 
			Prenume<input type="text" name="prenume" />
		</p>
		<p> Usernam<input type="text" name="username" />
			Parola<input type="password" name="parola" />
		</p>
		<p> Email<input type="text" name="email" /></p>
		<p>Hotelul care sa il administreze:
			<select id="hotel" name="hotel">
				<option value="" selected="selected">Selectati hotelul</option>
				@foreach ($hotels as $hotel)
				<option value="{{ $hotel->hotel_id }}" >{{ $hotel->hotel_name }}</option>
				@endforeach
			</select><br>
		</p>
		<input type="submit" class="button" value="Adauga" >
	</form>

</section>

@stop