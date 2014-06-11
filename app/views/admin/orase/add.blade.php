@extends('layouts.master')

@section('content')
<section>
	<h3>Adauga oras</h3>
	<a href="{{ asset('admin/cities') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_add_city">
		<p> Oras <input type="text" name="city" /> </p>
		<input type="submit" class="button" value="Adauga" >
	</form>
</section>

@stop