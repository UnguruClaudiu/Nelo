<?php 

class PreparePageModel {

	public static function preparePage($title) {

		$page_nav = array(
            'page_title'  => $title,
            'ok_message' => Session::get('ok_message'),
            'error_message'	=> Session::get('error_message'),
            );
        Session::forget('ok_message');
        Session::forget('error_message');

        return $page_nav;
	}

}