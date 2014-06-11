@extends('layouts.master')

@section('content')
<section>
	<h3>Editeaza facilitate</h3>
	<a href="{{ asset('admin/facilities') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_edit_facility">
		<p> Facilitate <input type="text" name="facility" value="{{ $facility[0]->facility_name }}" /> </p>
		<input type="submit" class="button" value="Editeaza" >
	</form>
</section>

@stop