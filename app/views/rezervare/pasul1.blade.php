@extends('layouts.master')

@section('content')

<section id="booking1">   
    <form action="" method="post" name="booking_form1">
        <label for="firstname">Prenume:</label>
        <input name="firstname" type="text" placeholder="Prenume" required />

        <label for="lastname">Nume:</label>
        <input name="lastname" type="text" placeholder="Nume" required />
        
		<label for="email">Adresă de e-mail:</label>
        <input id="reg_em" name="email" type="text" placeholder="Email" required />
        
        <label for="username">Nume utilizator:</label>
        <input name="username" type="text" placeholder="Nume utilizator" required />
        
        <label for="password">Parolă:</label>
        <input id="pswd" type="password" name="password" placeholder="Parolă" required />
        
        <input type="submit" value="Următorul" >
	</form>
</section>


@stop