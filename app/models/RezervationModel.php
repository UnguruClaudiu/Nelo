<?php 

class RezervationModel extends Eloquent {

	public static function newRezervation($from_date, $to_date, $user_id, $hotel_id, $rating, $free_rooms){
		
		DB::table('bookings')->insert( array(
            'from_date'     => $from_date,
            'to_date'       => $to_date,
            'belong_user'   => $user_id,
            'belong_hotel'  => $hotel_id,
            'rating'        => $rating
            ));

        DB::table('hotels')
        ->where ('hotel_id', $hotel_id)
        ->update( array(
            'free_rooms'    => $free_rooms
            ));
    }

    public static function getFreeRooms($hotel_id){

        $rooms = DB::table('hotels')
        ->where('hotel_id', $hotel_id)
        ->pluck('free_rooms');
        return $rooms;
    }

    public static function processFirstStep ($user, $pass, $firstname, $lastname, $email) {
        DB::table('users')->insert( array(
          'username'        => $user, 
          'password'        => $pass,
          'first_name'  => $firstname,
          'last_name'       => $lastname,
          'email'       => $email,
          'is_admin'        => 0
          ));
        $id = DB::select("SELECT user_id FROM users WHERE username = '$user' ");
        return $id[0]->user_id;
    }

    public static function getHotelRooms($hotel_id){
      
    }

}