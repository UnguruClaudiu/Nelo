@extends('layouts.master')

@section('content')
<section>
	<h3>Adauga o facilitate noua</h3>
	<a href="{{ asset('admin/roomfacilities') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_add_room_facility">
		<p> Facilitate <input type="text" name="room_facility" /> </p>
		<input type="submit" class="button" value="Adauga" >
	</form>
</section>

@stop