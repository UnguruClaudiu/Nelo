@extends('layouts.master')

@section('content')
<section id="admin">
	<a href="{{ asset('admin/rezervations') }}" class="admin_button">Administraţi rezervări</a>
	<a href="{{ asset('admin/hotels') }}" class="admin_button">Administraţi hoteluri</a>
	<a href="{{ asset('admin/users') }}" class="admin_button">Administraţi utilizatori</a>
	<a href="{{ asset('admin/rooms') }}" class="admin_button">Administraţi tipuri de camere</a>
	<a href="{{ asset('admin/cities') }}" class="admin_button">Administraţi oraşe</a>
	<a href="{{ asset('admin/facilities') }}" class="admin_button">Administraţi facilităţi hotel</a>
	<a href="{{ asset('admin/roomfacilities') }}" class="admin_button">Administraţi facilităţi cameră</a>
</section>

@stop