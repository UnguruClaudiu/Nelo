<?php

class RegisterController extends Controller {

	public function getIndex() {

        $page_nav = PreparePageModel::PreparePage('Register');
    	return View::make('autentificare.register', $page_nav);
    }

    public function postIndex() {
    	
        $input = Input::all();
        $user = $input['username'];
        $pass = md5($input['password']);
        $firstname = $input['firstname'];
        $lastname = $input['lastname'];
        $email = $input['email'];

        $page_nav = array(
            'page_title'  => 'Login',
            'ok_message' => Session::get('ok_message'),
			'error_message'	=> Session::get('error_message'),
        );
        $id = RegisterModel::addUser($user, $pass, $firstname, $lastname, $email);

        Session::put('username', $user);
        Session::put('password', $pass);
        Session::put('user_id', $id);
        Session::put('ok_message', 'Inregistrare reusita');
        return Redirect::to('home');

    }

}