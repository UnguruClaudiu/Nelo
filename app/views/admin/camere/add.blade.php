@extends('layouts.master')

@section('content')
<section>
	<h3>Adauga nou tip de camera</h3>
	<a href="{{ asset('admin/rooms') }}"><button>Inapoi</button></a>

	<form method="post" name="admin_add_room">
		<p> Tip <input type="text" name="type" /> </p>
		<p> Descriere <input type="text" name="description" /> </p>
		<p> Numar de persoane <input type="text" name="number_of_persons" /> </p>
		<input type="submit" class="button" value="Adauga" >
	</form>

</section>

@stop