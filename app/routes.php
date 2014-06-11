<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::controller('home', 'HomeController');
Route::controller('register', 'RegisterController');
Route::controller('login', 'LoginController');
Route::controller('rezervare', 'RezervationController');

Route::filter('login',function(){
	$user = Session::get('username');
	$pass = Session::get('password');
	if (!$user && !$pass){
		return Redirect::to('login');
	}
});
Route::get('/', function(){
	return Redirect::to('home');
});

Route::get('logout', function(){

	Session::forget('username');
	Session::forget('password');
	return Redirect::to('login');
});

Route::post('/emails', function() {
	if (Request::ajax()) {
		$input = Input::all();
        $email = $input['email'];
		$sql = DB::select("SELECT count(*) as count FROM users WHERE email = '$email'");
		return $sql[0]->count;
	}
});

Route::group(array('before' => 'login'), function() { 
	
	$user = Session::get('username');
	$pass = Session::get('password');
	if (!$user && !$pass){
		Route::controller('admin', 'LoginController');
	}
	
	$verific = check($user, $pass, -1);
	if ($verific){
		Route::controller('admin', 'AdminController');
	}
	$type = tip_cont($user, $pass);
	if ( $type == -1 ){
		Route::controller('admin', 'AdminController');
	}

	Route::controller('administrator', 'AdministratorController');

});

function check($cont, $pass, $permission){
	//verific daca userul are permisiunea
	$sql = DB::select("SELECT is_admin FROM users WHERE username = '$cont' AND password = '$pass' AND is_admin LIKE '%$permission%' ");
    if( $sql ) {
    	return true;
    }
    else {
    	return false;
   	}	
}

function tip_cont($cont, $pass){
	//verific daca userul are permisiunea
	$sql = DB::select("SELECT is_admin FROM users WHERE username = '$cont' AND password = '$pass' ");
    if( $sql ) {
    	return $sql;
    }
    else {
    	return false;
   	}	
}

?>