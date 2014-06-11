<?php 

class AdministratorModel extends Eloquent {

	public static function getHotel($id){

		$hotel = DB::select("SELECT * FROM hotels WHERE hotel_id IN (SELECT is_admin FROM users WHERE user_id = $id)");
		return $hotel;
	} 
	public static function getRezervations($id){

		$rezervations = DB::select("SELECT * FROM bookings WHERE belong_hotel = $id");
		return $rezervations;
	} 


}