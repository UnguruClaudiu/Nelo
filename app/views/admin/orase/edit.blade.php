@extends('layouts.master')

@section('content')
<section>
	<h3>Editeaza nume oras</h3>
	<a href="{{ asset('admin/cities') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_edit_city">
		<p> Oras <input type="text" name="city" value="{{ $city[0]->city_name }}" /> </p>
		<input type="submit" class="button" value="Editeaza" >
	</form>
</section>

@stop