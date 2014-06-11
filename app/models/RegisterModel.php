<?php 

class RegisterModel extends Eloquent {

	public static function addUser($user, $pass, $firstname, $lastname, $email) {
		DB::table('users')->insert( array(
                  'username' 		=> $user, 
                  'password' 		=> $pass,
                  'first_name' 	=> $firstname,
                  'last_name'		=> $lastname,
                  'email'		=> $email,
                  'is_admin' 		=> 0
            ));
            $id = DB::select("SELECT user_id FROM users WHERE username = '$user' ");
            return $id[0]->user_id;
	}

}