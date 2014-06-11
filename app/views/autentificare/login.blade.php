@extends('layouts.master')

@section('content')

<section id="login">

	<h3>Autentificare:</h3>
		
    <form action="" method="post" name="login_form">
        <label for="username">Utilizator:</label>
        <input name="username" type="text" placeholder="Utilizator" required />
        <label for="password">Parolă:</label>
        <input name="password" type="password" placeholder="Parolă" required />
        <input type="submit" value="Autentificaţi-vă" >
    </form>
    
    <p>Dacă nu aveţi cont:</p><a href="{{ asset('register') }}">Înregistraţi-vă</a>
</section>


@stop