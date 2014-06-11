<?php

class LoginController extends Controller {

	public function getIndex() {

        $page_nav = PreparePageModel::PreparePage('Login');
    	return View::make('autentificare.login', $page_nav);
    }

    public function postIndex() {
    	
        $input = Input::all();
        $user = $input['username'];
        $pass = md5($input['password']);
        $user = LoginModel::getUser($user, $pass);
        if ($user) {
        	Session::put('username', $input['username']);
            Session::put('password', md5($input['password']));
            Session::put('user_id', $user[0]->user_id);
            Session::put('admin', $user[0]->is_admin);
            Session::put('ok_message', 'Autentificare reusita!');
            if ( $user[0]->is_admin == -1 )
                return Redirect::to('admin');
            elseif ($user[0]->is_admin == 0 ) 
                return Redirect::to('home');
            elseif ($user[0]->is_admin > 0 )
                return Redirect::to('administrator/hotel/' . $user[0]->user_id);
        } else {
            Session::put('error_message', 'Date invalide');
        	return Redirect::to('login');
        }
    }
}