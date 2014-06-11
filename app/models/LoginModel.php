<?php 

class LoginModel extends Eloquent {

	public static function getUser($user, $pass){

		$getUser = DB::select("SELECT * FROM users WHERE username = '$user' AND password = '$pass' ");
        if ($getUser){
        	return $getUser;
        } else 
        	return false;
	}

}