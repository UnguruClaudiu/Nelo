<?php

class AdministratorController extends Controller {

	public function getHotel($id) {

        $page_nav = PreparePageModel::PreparePage('Administrator');
        $hotel = AdministratorModel::getHotel($id);
        $rezervations = DB::select("SELECT b.*, h.hotel_name, u.first_name, u.last_name, b.status  
            FROM bookings b
            -- INNER JOIN rooms_rezerved r on b.booking_id     = r.belong_booking
            -- INNER JOIN room_types t     on r.belong_room    = t.type_id
            INNER JOIN hotels h         on b.belong_hotel   = h.hotel_id
            INNER JOIN users u          on b.belong_user    = u.user_id
            ");
    	return View::make('administrator.hotel', $page_nav)->with('hotel', $hotel)->with('rezervations', $rezervations);
    }

}