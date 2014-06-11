<?php 

class AdminModel extends Eloquent {

	public static function getAllHotels(){

		$hotels = DB::select("SELECT * FROM hotels");
		return $hotels;
	} 

	public static function getHotelDetails($hotel_id){

    $hotel = DB::select("SELECT * FROM hotels WHERE hotel_id = '$hotel_id' ");
    $facilitati = DB::select("SELECT * FROM facilities WHERE facility_id IN (SELECT belong_facility FROM hotels_facility_offers WHERE belong_hotel = '$hotel_id')");
    $types_of_room = DB::select("SELECT * FROM room_types WHERE type_id IN (SELECT belong_room_type FROM hotels_rooms_offers WHERE belong_hotel = '$hotel_id')");
    $data['hotel'] = $hotel;
    $data['facilitati'] = $facilitati;
    $data['types_of_room'] = $types_of_room;
    return $data;
  }

  public static function getData(){

    $data['types_of_room'] = DB::select("SELECT * FROM room_types");
    $data['orase'] = DB::select("SELECT * FROM cities");
    $data['facilities'] = DB::select("SELECT * FROM facilities");
    return $data;
  }

  public static function addHotel($input){
	$n = count($input['tip']);
	$total_camere = 0;
	for ($i=0; $i<$n; $i++){
		$total_camere += $input['total_camere'][$i];
	}
  
    DB::table('hotels')->insert( array(
      'hotel_name'          => $input['hotel_name'], 
      'hotel_stars'         => $input['score'],
      'hotel_description'   => $input['description'],
	  'total_rooms' => $total_camere,
      'belong_city'         => $input['oras']
      ));

    $id_new_hotel = DB::select("SELECT MAX(hotel_id) as id FROM hotels");
    foreach ($input['hotel_images_path'] as $path) {
      DB::table('hotel_paths')->insert( array(
        'belong_hotel'  => $id_new_hotel[0]->id,
        'path'          => $path
        ));
    }
    
	return $input['total_camere'];
    for ($i=0; $i<$n; $i++){
      DB::table('hotels_rooms_offers')->insert( array(
        'belong_hotel'        => $id_new_hotel[0]->id, 
        'belong_room_type'    => $input['tip'][$i],
        'free_rooms'          => $input['total_camere'][$i],
        'total_rooms'         => $input['total_camere'][$i],
        'price_per_room'      => $input['pret'][$i],
        'path'                => $input['room_image_path'][$i]
      ));

    }
    $n = count($input['facilitate']);
    for ($i=0; $i<$n; $i++){
      DB::table('hotels_facility_offers')->insert( array(
        'belong_hotel'        => $id_new_hotel[0]->id, 
        'belong_facility'     => $input['facilitate'][$i]
      ));
    }
  }

  public static function getUsers(){
    $users['administratori'] = DB::select("SELECT u.*, h.hotel_name 
      FROM users u
      INNER JOIN hotels h on u.is_admin = h.hotel_id"); 
    $users['clienti'] = DB::select("SELECT * FROM users WHERE is_admin = 0");
    $users['admin'] = DB::select("SELECT * FROM users WHERE is_admin = -1");
    return $users;
  }

  public static function getRooms(){
    
  }
}