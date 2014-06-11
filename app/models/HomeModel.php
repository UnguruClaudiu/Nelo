<?php 

class HomeModel extends Eloquent {

	public static function getAll($input = null){
		
    $location = $input['location'];
    if (empty($input['facility'])){
      $data['hotels'] = DB::select("SELECT * FROM hotels 
        WHERE belong_city IN (SELECT city_id FROM cities WHERE city_name LIKE '%$location%') 
        ");
    }
    else {

      $ids = implode(',',$input['facility']);
      $data['hotels'] = DB::select("SELECT * FROM hotels WHERE
        hotel_id IN (SELECT belong_hotel FROM hotels_facility_offers 
          WHERE belong_facility IN ($ids))
      AND belong_city IN (SELECT city_id FROM cities WHERE city_name LIKE '%$location%') 
      ");
    }
    $data['facilities'] = DB::select("SELECT * FROM facilities");
    $data['room_facilities'] = DB::select("SELECT * FROM facilities_room");
    $data['bookings'] = DB::select("SELECT belong_hotel, MAX(create_date) as data FROM bookings GROUP BY belong_hotel");
    $data['hotel_images'] = DB::select("SELECT * FROM hotel_paths");
    return $data;
  }

  public static function getDetails($hotel_id){

    $details['hotel'] = DB::select("SELECT * FROM hotels WHERE hotel_id = '$hotel_id' ");
    $details['cities'] = DB::select("SELECT * FROM cities WHERE city_id = (SELECT belong_city FROM hotels WHERE hotel_id = $hotel_id ) ");
    $details['facilities'] = DB::select("SELECT * FROM facilities WHERE facility_id IN (SELECT belong_facility FROM hotels_facility_offers WHERE belong_hotel = '$hotel_id' ) ");
    $details['room_types'] = DB::select("SELECT * FROM room_types WHERE type_id IN (SELECT belong_room_type FROM hotels_rooms_offers WHERE belong_hotel = '$hotel_id' ) ");
    $details['room_images'] = DB::select("SELECT * FROM hotels_rooms_offers WHERE belong_hotel = $hotel_id");
    return $details;
  }

  public static function getRezervations($user_id){

    $rezervations = DB::select("SELECT b.*, h.hotel_name FROM bookings b 
      INNER JOIN hotels h on b.belong_hotel   = h.hotel_id
      WHERE belong_user = '$user_id' ");
    return $rezervations; 
  }

}