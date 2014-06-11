<?php

class HomeController extends Controller {

	public function getIndex() {

        $page_nav = PreparePageModel::PreparePage('Home');
        $data = HomeModel::getAll();
        foreach ($data['hotels'] as $hotel) {
            foreach ($data['bookings'] as $book){
                if ($hotel->hotel_id == $book->belong_hotel){
                    $first_date = new DateTime($book->data);
                    $second_date = new DateTime(date('Y-m-t H:i:s'));
                    $interval = $first_date->diff($second_date);
                    if ($interval->y > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->y . " ani.";
                    if ($interval->y == 0 && $interval->m > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->m . " luni.";
                    if ($interval->y == 0 && $interval->m == 0 && $interval->d > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->d . " zile.";
                    if ($interval->y == 0 && $interval->m == 0 && $interval->d == 0 && $interval->h > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->h . " ore.";
                    if ($interval->y == 0 && $interval->m == 0 && $interval->d == 0 && $interval->h == 0 && $interval->i > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->i . " minute.";
                    if ($interval->y == 0 && $interval->m == 0 && $interval->d == 0 && $interval->h == 0 && $interval->i == 0 && $interval->s > 0)
                        $hotel->last_booking = "Ultima rezervare facută acum " . $interval->s . " secunde.";                }
            }
        }
        return View::make('acasa.home', $page_nav)->with('data', $data);
    }

    public function postIndex(){

        $input = Input::all();
        //return $input;
        Session::put('check_in', $this->reformat_date($input['check-in']));
        Session::put('check_out', $this->reformat_date($input['check-out']));
        $data = HomeModel::getAll($input);
        
		$filtrare_total = DB::select("SELECT h.belong_hotel, SUM(h.total_rooms * r.pers) as pers FROM hotels_rooms_offers h, room_types r WHERE r.type_id = h.belong_room_type Group BY h.belong_hotel");
		$filtrare_booking = DB::select("SELECT b.belong_hotel, b.booking_id, b.from_date, b.to_date, r.number_of_rooms * p.pers as pers 
                                    FROM bookings b, rooms_rezerved r, room_types p, hotels 
                                    WHERE b.booking_id = r.belong_booking AND p.type_id = r.belong_room ");
	    //return $filtrare_booking;
		/*
         *
         * caz in care la cautare e setata data
         *
         */
        $start =  date('Y-m-d', strtotime($input['check-in']));
		$end = date('Y-m-d', strtotime($input['check-out']));
		//return $filtrare_total;
        //[{"belong_hotel":1,"pers":"110"},{"belong_hotel":7,"pers":"100"}
        //,{"belong_hotel":8,"pers":"150"},{"belong_hotel":9,"pers":"1200"},{"belong_hotel":16,"pers":"45"},{"belong_hotel":20,"pers":"413"}]
		$zile = array();
		while($start <= $end) {

			$zi = array();
			foreach ($filtrare_total as $f) {
					$zi[$f->belong_hotel] = $f->pers;
                    if ( $input['guests'] != "")
                        $zi[$f->belong_hotel] -= $input['guests'];
			}
			foreach ($filtrare_booking as $f) {
				//{"belong_hotel":1,"booking_id":1,"from_date":"2014-06-10","to_date":"2014-06-18","number_of_rooms":2,"belong_room":2},
				//{"belong_hotel":1,"booking_id":2,"from_date":"2014-06-11","to_date":"2014-06-25","pers":2},
				$i = 0;   
                if ( date($f->from_date) <= $start && date($f->to_date) >= $start) {
					$zi[$f->belong_hotel] -= $f->pers;
                }
				$i++;
			}
			array_push($zile, $zi);
			$start = date('Y-m-d', strtotime($start .' +1 day'));
		}
		foreach ($zile as $z){

			foreach ($filtrare_total as $id){
                if ($z[$id->belong_hotel] <= 0)
                    //ocupare retin id-ul hotelurilor care sunt ocupate in una din zilele care le folosim la fitrare
                    $ocupare[$id->belong_hotel] = $id->belong_hotel;
            }
        } 
        /*
         *
         * caz in care este locatie
         *
         */
		 
        $location = "";
        if ($input['location'] != "")
            $location = $input['location'];
		 $stars = "";
        if (isset($input['score']))
            $stars = $input['score'];
        if (!isset($ocupare)){
			$var = 0;
		} else {
		 $var = implode(',', array_map('intval', $ocupare));
		}
		
        if (empty($input['facility'])){
            $data['hotels'] = DB::select("SELECT * FROM hotels 
                        WHERE hotel_id NOT IN ($var)
                        AND belong_city IN (SELECT city_id FROM cities WHERE city_name LIKE '%$location%')
                        AND hotel_stars LIKE '%$stars%'
                ");
        } else {
            $ids = implode(',',$input['facility']);
            $data['hotels'] = DB::select("SELECT * FROM hotels, hotels_facility_offers 
                        WHERE hotel_id NOT IN ($var)
                        AND belong_facility IN ($ids)
                        AND belong_city IN (SELECT city_id FROM cities WHERE city_name LIKE '%$location%')
                        AND hotel_stars LIKE '%$stars%'
                        GROUP BY hotel_id
                ");
            return $data['hotels'];
    }
        
        
		$page_nav = PreparePageModel::PreparePage('Home');
        return View::make('acasa.home', $page_nav)->with('data', $data);        
    }

    public function getDetails($hotel_id){

        $page_nav = PreparePageModel::PreparePage('Detalii hotel');
        $details = HomeModel::getDetails($hotel_id);
        return View::make('acasa.hotel', $page_nav)->with('details', $details);
    }

    public function getAccount($user_id){

        $page_nav = PreparePageModel::PreparePage('My Account'); 
        $rezervations = HomeModel::getRezervations($user_id);
        //return $rezervations;
        return View::make('client.account', $page_nav)->with('rezervations', $rezervations);
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
	
	public function postCities(){

        $cities = DB::select("SELECT city_name FROM cities");
        print(json_encode($cities));
    }
	
    public function postInterval($id){

        $data['check_in'] = Session::get('check_in');
        $data['check_out'] = Session::get('check_out');
        $data['rezervations'] = DB::select("SELECT b.booking_id, b.belong_hotel, b.from_date, b.to_date, SUM(r.number_of_rooms) as number_of_rooms FROM bookings b, rooms_rezerved r WHERE
			b.booking_id = r.belong_booking AND 
            b.belong_hotel = $id AND
            from_date BETWEEN  '" . $data['check_in'] . "' AND '" . $data['check_out'] . "'
			GROUP BY b.booking_id; 
        ");

        $data['count'] = DB::select("SELECT SUM(total_rooms) as total_rooms  FROM hotels_rooms_offers WHERE
            belong_hotel = $id;  
        ");
        print(json_encode($data));
    }
}