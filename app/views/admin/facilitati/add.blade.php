@extends('layouts.master')

@section('content')
<section>
	<h3>Adauga facilitate</h3>
	<a href="{{ asset('admin/facilities') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_add_facility">
		<p> Facilitate <input type="text" name="facility" /> </p>
		<input type="submit" class="button" value="Adauga" >
	</form>
</section>

@stop