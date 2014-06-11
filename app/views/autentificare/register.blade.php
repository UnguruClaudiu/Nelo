@extends('layouts.master')

@section('content')


<section id="register">

	<h3>Înregistrare:</h3>
    
    <form action="" method="post" name="register_form">
        <label for="firstname">Prenume:</label>
        <input name="firstname" type="text" placeholder="Prenume" required />

        <label for="lastname">Nume:</label>
        <input name="lastname" type="text" placeholder="Nume" required />
        
        <label for="email">Adresă de e-mail:</label>
        <input id="reg_em" name="email" type="text" placeholder="Email" required />
        <label id="resp"></label>
        
        <label for="username">Nume utilizator:</label>
        <input name="username" type="text" placeholder="Nume utilizator" required />
        
        <label for="password">Parolă:</label>
        <input id="pswd" type="password" name="password" placeholder="Parolă" required />
        
        <div id="pswd_info">
            <h4>Parola trebuie să conţină:</h4>
            <ul>
                <li id="letter" class="invalid">Cel puţin <strong>o literă.</strong></li>
                <li id="capital" class="invalid">Cel puţin <strong>o majusculă.</strong></li>
                <li id="number" class="invalid">Cel puţin <strong>un numar.</strong></li>
                <li id="length" class="invalid">Cel puţin <strong>8 caractere.</strong></li>
            </ul>
        </div>
        <input id="register_btn" type="submit" value="Înregistraţi-vă" disabled="disabled" />
    </form>
</section>


@stop