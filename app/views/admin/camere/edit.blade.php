@extends('layouts.master')

@section('content')
<section>
	<h3>Editaţi tipul de cameră</h3>
	<a href="{{ asset('admin/rooms') }}"><button>Inapoi</button></a>
	<form method="post" name="admin_edit_room">
		<p> Tip <input type="text" name="type" value="{{ $room[0]->type_name }}" /> </p>
		<p> Descriere <input type="text" name="description" value="{{ $room[0]->description }}" /> </p>
		<p> Numar de persoane <input type="text" name="number_of_persons" value="{{ $room[0]->pers }}" /> </p>
		<input type="submit" class="button" value="Editeaza" >
	</form>

</section>

@stop