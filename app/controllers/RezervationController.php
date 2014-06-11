<?php

class RezervationController extends Controller {

	public function getIndex($hotel_id) {

        $page_nav = PreparePageModel::PreparePage('Rezervation');
        $user = Session::get('username');
        $pass = Session::get('password');
        if (!$user && !$pass){
            Session::put('ok_message', 'Primul pas');
            return Redirect::to('login');
        } 
        else 
        { 
            return Redirect::to('rezervare/pasul2/' . $hotel_id);
        }      
    }

    public function postIndex ($hotel_id) {

    }

    public function getPasul1($hotel_id){
        $page_nav = PreparePageModel::PreparePage('Rezervation');
        return View::make('rezervare.pasul1', $page_nav);
    }

    public function postPasul1($hotel_id){

        $input = Input::all();
        $user = $input['username'];
        $pass = md5($input['password']);
        $firstname = $input['firstname'];
        $lastname = $input['lastname'];
        $email = $input['email'];

        $page_nav = array(
            'page_title'  => 'Login',
            'ok_message' => Session::get('ok_message'),
            'error_message' => Session::get('error_message'),
            );
        $id = RezervationModel::processFirstStep($user, $pass, $firstname, $lastname, $email);

        Session::put('username', $user);
        Session::put('password', $pass);
        Session::put('user_id', $id);
        Session::put('ok_message', 'Pasul 2');
        return Redirect::to('rezervare/pasul2/' . $hotel_id);
    }


    public function getPasul2($hotel_id){

        $page_nav = PreparePageModel::PreparePage('Rezervation');

        $check_in = Session::get('check_in');
        $check_out = Session::get('check_out');
        $filtrare_total = DB::select("SELECT belong_room_type, total_rooms, price_per_room, path FROM `hotels_rooms_offers`WHERE belong_hotel = ".$hotel_id);
        $filtrare_booking = DB::select("SELECT b.from_date, b.to_date, r.belong_room, r.number_of_rooms
            FROM bookings b, rooms_rezerved r
            WHERE b.booking_id = r.belong_booking AND b.belong_hotel = $hotel_id");
        $start =  date('Y-m-d', strtotime($check_in));
        $end = date('Y-m-d', strtotime($check_out));
        //return $filtrare_total;
        //[{"belong_room_type":1,"total_rooms":100,"price_per_room":200,"path":""}]
        
        //return $filtrare_booking;
        //[{"from_date":"2014-06-10","to_date":"2014-06-18","belong_room":1,"number_of_rooms":5},
        //{"from_date":"2014-06-10","to_date":"2014-06-18","belong_room":2,"number_of_rooms":2}]

        $zile = array();
		$min = array();
        while($start <= $end) {

            $zi = array();
            foreach ($filtrare_total as $f) {
                $zi[$f->belong_room_type] = $f->total_rooms;
				$min[$f->belong_room_type] = $f->total_rooms;
            }
            foreach ($filtrare_booking as $f) {
                if ( date($f->from_date) <= $start && date($f->to_date) >= $start) {
                    $zi[$f->belong_room] -= $f->number_of_rooms;
                }
            }
            array_push($zile, $zi);
            $start = date('Y-m-d', strtotime($start .' +1 day'));
        }

        $rooms_remains = array();
        foreach ($zile as $z){
            foreach ($filtrare_booking as $id){
                if ($z[$id->belong_room] < $min[$id->belong_room] )
                    $min[$id->belong_room] = $z[$id->belong_room];
            }
        }
		
        //mai trebuie pentru poze
        $rooms = DB::select("SELECT r.type_id, r.type_name, r.description, hr.path, hr.price_per_room, hr.total_rooms
            FROM room_types r 
            INNER JOIN hotels_rooms_offers hr on r.type_id  = hr.belong_room_type 
            AND hr.belong_hotel = '$hotel_id'");
		$i = 0;
		foreach ($rooms as $r) {
				if ($min[$r->type_id] > 0) {
					$r->total_rooms = $min[$r->type_id];
				} else {
				  unset($rooms[$i]);
				}
			$i++;
		}

        return View::make('rezervare.pasul2', $page_nav)->with('rooms', $rooms)->with('free_rooms', $min);
    }

    public function postPasul2($hotel_id){

        $input = Input::all();
        //{"check-in":"06\/18\/2014","check-out":"06\/27\/2014","room_type":["1","2"],"number_of_rooms":["10","5"]}
		//{"number_of_rooms":["2","2"],"type_room":["1","9"]}

        $options =  $input['type_room'];
        $check_in = Session::get('check_in');
        $check_out = Session::get('check_out');

        $n = count($input['type_room']);
		
		
		
		//verific daca mai sunt locuri disponibile
		$filtrare_total = DB::select("SELECT belong_room_type, total_rooms, price_per_room, path FROM `hotels_rooms_offers`WHERE belong_hotel = ".$hotel_id);
        $filtrare_booking = DB::select("SELECT b.from_date, b.to_date, r.belong_room, r.number_of_rooms
            FROM bookings b, rooms_rezerved r
            WHERE b.booking_id = r.belong_booking AND b.belong_hotel = $hotel_id");
        $start =  date('Y-m-d', strtotime($check_in));
        $end = date('Y-m-d', strtotime($check_out));
		$zile = array();
		$min = array();
		
		$price_rooms = array();
		foreach ($filtrare_total as $f) {
				$price_rooms[$f->belong_room_type] = $f->price_per_room;
		}
		
        while($start <= $end) {

            $zi = array();
            foreach ($filtrare_total as $f) {

                $zi[$f->belong_room_type] = $f->total_rooms;
				$min[$f->belong_room_type] = $f->total_rooms;
            }
            foreach ($filtrare_booking as $f) {
                if ( date($f->from_date) <= $start && date($f->to_date) >= $start) {
                    $zi[$f->belong_room] -= $f->number_of_rooms;
                }
            }
            array_push($zile, $zi);
            $start = date('Y-m-d', strtotime($start .' +1 day'));
        }

        $rooms_remains = array();
        foreach ($zile as $z){
            foreach ($filtrare_booking as $id){
                if ($z[$id->belong_room] < $min[$id->belong_room] )
                    $min[$id->belong_room] = $z[$id->belong_room];
            }
        }
		
		$ok = 1;
		for ($i = 0; $i < $n; $i++) {
			if ($input['number_of_rooms'][$i] > $min[$input['type_room'][$i]] ) {
				$ok = 0;
				break;
			}
		}

        //RezervationModel::newRezervation( $start_date, $end_date, Session::get('user_id'), $hotel_id, $input['rating'], $free_rooms );
		
		//daca mai sunt camere disponibile
		if ($ok == 1 ) {
			DB::table('bookings')->insert(array(
            'create_date'   => date('Y-m-t H:i:s'),
            'from_date'     => $check_in,
            'to_date'       => $check_out,
            'belong_user'   => Session::get('user_id'),
            'belong_hotel'  => $hotel_id,
            'rating'        => 0,
            ));
			
			$id = DB::select("SELECT booking_id FROM bookings ORDER BY booking_id desc LIMIT 1");
			$booking_id = $id[0]->booking_id;
		
			for ($i = 0; $i < $n; $i++){ 
				DB::table('rooms_rezerved')->insert(array(
					'belong_room'       => $input['type_room'][$i],
					'number_of_rooms'   => $input['number_of_rooms'][$i],
					'price_per_night'   => $price_rooms[$input['type_room'][$i]] * $input['number_of_rooms'][$i],
					'belong_booking'    => $booking_id
                ));
			}
			Session::put('ok_message', 'Va multumit.');
			return Redirect::to('rezervare/pasul3');
		}
		else {
			Session::put('ok_message', 'Camerele nu mai sunt disponibile.');
			return Redirect::to('rezervare/pasul2/'.$hotel_id);
		}
    }

    public function getPasul3(){

        $page_nav = PreparePageModel::PreparePage('Rezervation');
        Session::put('ok_message', 'Rezervare facuta cu succes');
        return View::make('rezervare.pasul3', $page_nav);
    }

    function reformat_date( $date ) {
            //$date is in format ll\/zz\/aaaa
        if ( isset($date)){
            $date = explode( '/', $date );
            $new_date  = $date[2] . '-';
            $new_date .= $date[0] . '-';
            $new_date .= $date[1];
            return $new_date;
        }
            //return $date in format aaaa-ll-zz
    }
}