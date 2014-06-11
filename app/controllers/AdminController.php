<?php 

class AdminController extends Controller {

	public function getIndex() {

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        return View::make('admin.admin', $page_nav);
    }


/**
 *
 *  <===== ADMINISTRARE HOTELURI =====>
 *
*/

    public function getHotels(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $hotels = AdminModel::getAllHotels();
        return View::make('admin.hoteluri.hotels', $page_nav)->with('hotels', $hotels);
    }

    public function getNewhotel(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');

        $data = AdminModel::getData();
        return View::make('admin.hoteluri.add', $page_nav)->with('data', $data);   
    }

    public function postNewhotel(){

        $input = Input::all();
        $hotel_images = Input::file('hotel_image'); // your file upload input field in the form should be named 'file'
        $destinationPath = 'hotels/' . $input['hotel_name'];
        foreach ($hotel_images as $f){
            $filename = $f->getClientOriginalName();
            $f->move($destinationPath, $filename);
            $hotel_images_path[] = "hotels/" . $input['hotel_name'] . '/' . $filename;
        }
        $rooms_images = Input::file('room_image'); // your file upload input field in the form should be named 'file'

        $destinationPath = 'hotels/' . $input['hotel_name'] .'/rooms';
        foreach ($rooms_images as $f){
            $filename = $f->getClientOriginalName();
            $f->move($destinationPath, $filename);
            $room_image_path[] = "hotels/" . $input['hotel_name'] . '/rooms/' . $filename;
        }
        $input['hotel_images_path'] = $hotel_images_path;
        $input['room_image_path'] = $room_image_path;
        $hotel = AdminModel::addHotel($input);
        Session::put('ok_message', 'Hotelul a fost adaugat cu succes');
        return Redirect::to('admin/hotels');
    }

    public function getEdithotel($hotel_id){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $data = AdminModel::getData();
        $hotel_details = AdminModel::getHotelDetails($hotel_id);
        //return $hotel_details['hotel'][0]->hotel_id;
        return View::make('admin.hoteluri.edit', $page_nav)->with('hotel', $hotel_details)->with('data', $data);
    }

    public function postEdithotel(){

        $input = Input::all();
        $hotel_images = Input::file('hotel_image'); // your file upload input field in the form should be named 'file'
        $destinationPath = 'hotels/' . $input['hotel_name'];
        foreach ($hotel_images as $f){
            $filename = $f->getClientOriginalName();
            $f->move($destinationPath, $filename);
            $hotel_images_path[] = "hotels/" . $input['hotel_name'] . '/' . $filename;
        }
        $rooms_images = Input::file('room_image'); // your file upload input field in the form should be named 'file'

        $destinationPath = 'hotels/' . $input['hotel_name'] .'/rooms';
        foreach ($rooms_images as $f){
            $filename = $f->getClientOriginalName();
            $f->move($destinationPath, $filename);
            $room_image_path[] = "hotels/" . $input['hotel_name'] . '/rooms/' . $filename;
        }
        $input['hotel_images_path'] = $hotel_images_path;
        $input['room_image_path'] = $room_image_path;
        $hotel = AdminModel::addHotel($input);
        Session::put('ok_message', 'Hotelul a fost adaugat cu succes');
        return Redirect::to('admin/hotels');
    }

    public function getDeletehotel($hotel_id){

        DB::table('hotels')->where('hotel_id', '=', $hotel_id)->delete();
        DB::table('hotels_facility_offers')->where('belong_hotel', '=', $hotel_id)->delete();
        DB::table('hotels_rooms_offers')->where('belong_hotel', '=', $hotel_id)->delete();
        return Redirect::to('admin/hotels'); 
    }

    public function postTypes (){

        $l = DB::select("SELECT * FROM room_types ORDER BY type_name ASC;");
        print(json_encode($l));
    }




/**
 *
 *  <===== ADMINISTRARE REZERVARI =====>
 *
*/

    public function getRezervations(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $rezervations = DB::select("SELECT b.*, h.hotel_name, u.first_name, u.last_name  
            FROM bookings b
            -- INNER JOIN rooms_rezerved r on b.booking_id     = r.belong_booking
            -- INNER JOIN room_types t     on r.belong_room    = t.type_id
            INNER JOIN hotels h         on b.belong_hotel   = h.hotel_id
            INNER JOIN users u          on b.belong_user    = u.user_id
            ");
        //return $rezervations;
        return View::make('admin.rezervari.rezervations', $page_nav)->with('rezervations', $rezervations);
    }
    
    public function getDeleterezervation($id){
        DB::table('bookings')
            ->where('booking_id', $id)
            ->update( array(
                'status' =>'Anulat'
            ));
        return Redirect::to('admin/rezervations');
    }


/**
 *
 *  <===== ADMINISTRARE UTILIZATORI =====>
 *
*/

    public function getUsers(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $users = AdminModel::getUsers();
        return View::make('admin.utilizatori.users', $page_nav)->with('users', $users);
    }

    public function getNewuser(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $hotels = AdminModel::getAllHotels();
        return View::make('admin.utilizatori.add', $page_nav)->with('hotels', $hotels);
    }

    public function postNewuser(){

        $input = Input::all();
        DB::table('users')->insert(array(
            'first_name'    => $input['nume'],
            'last_name'     => $input['prenume'],
            'username'      => $input['username'],
            'password'      => md5($input['parola']),
            'email'         => $input['email'],
            'is_admin'      => $input['hotel']
            ));
        Session::put('ok_message', 'Utilizator adaugat cu succes');
        return Redirect::to('admin/users');
    }

    public function getDeleteuser($id){
        DB::table('users')->where('user_id', '=', $id)->delete();
        $bookings = DB::select("SELECT booking_id, belong_hotel FROM bookings WHERE belong_user = $id");
        //[{"booking_id":1,"belong_hotel":1},{"booking_id":2,"belong_hotel":1}]
        DB::table('bookings')->where('belong_user', '=', $id)->delete();
        foreach ($bookings as $b){
            $rooms = DB::select("SELECT belong_room, number_of_rooms FROM rooms_rezerved WHERE belong_booking = $b->booking_id");
            foreach ($rooms as $room) {
                //[{"belong_room":1,"number_of_rooms":5},{"belong_room":2,"number_of_rooms":2}]
                $free_rooms = DB::select("SELECT free_rooms FROM hotels_rooms_offers 
                    WHERE belong_hotel = $b->belong_hotel AND belong_room_type = $room->belong_room");
                //[{"free_rooms":43}]
                DB::table('hotels_rooms_offers')
                ->where('belong_hotel', '=', $b->belong_hotel, 'AND', 'belong_room_type', '=', $room->belong_room)
                ->update('free_rooms', $free_rooms[0]->free_rooms + $room->number_of_rooms);
            }
            DB::table('rooms_rezerved')->where('belong_booking', '=', $b->booking_id)->delete();
        }
        Session::put('ok_message', 'Utilizator sters cu succes');
        return Redirect::to('admin/users');
    }
    


/**
 *
 *  <===== ADMINISTRARE CAMERE =====>
 *
*/

    public function getRooms(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $rooms = DB::select("SELECT * FROM room_types");
        return View::make('admin.camere.rooms', $page_nav)->with('rooms', $rooms);
    }

    public function getNewroom(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        return View::make('admin.camere.add', $page_nav);
    }

    public function postNewroom(){
        $input = Input::all();
        DB::table('room_types')->insert(array(
            'type_name'     => $input['type'],
            'description'   => $input['description'],
            'pers'          => $input['number_of_persons']
            ));
        Session::put('ok_message', 'Tipul de camera adaugat cu succes');
        return Redirect::to('admin/rooms');
    }

    public function getEditroom($id){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $room = DB::select("SELECT * FROM room_types WHERE type_id = $id");
        return View::make('admin.camere.edit', $page_nav)->with('room', $room);
    }

    public function postEditroom($id){

        $input = Input::all();
        DB::table('room_types')
        ->where('type_id', $id)
        ->update(array(
            'type_name'     => $input['type'],
            'description'   => $input['description'],
            'pers'          => $input['number_of_persons']
            ));
        Session::put('ok_message', 'Tipul de camera editat cu succes');
        return Redirect::to('admin/rooms');
    }

    public function postDeleteroom($id){
        DB::table('room_types')->where('type_id', '=', $id)->delete();
    }

    public function getNewtype(){

        $message = array('error' => "", 'success' => "", 'message' => "", 'id' => 0);
        if(isset($_GET['modal'])) {
            $page_nav['is_ajax'] = 'onclick="return adauga_tip();"';
            if( $_GET['modal'] == 1) {
                if( $_GET['nume'] == "" ) {
                   $message['error'] = "Introdu numele\n";
                }
                if( $message['error']  != "" ) {
                    die( json_encode($message) );
                }
                DB::table('room_types')->insert( array( 
                    'type_name'     => $_GET['nume'], 
                    'description'   => $_GET['descriere']
                    ));
                $nume = $_GET['nume'];
                $id = DB::select("SELECT type_id FROM room_types WHERE type_name = '$nume' ");
                $message['tip_id'] = $id[0]->type_id;
                $message['success'] = "succes";
                $message['nume'] = $_GET['nume'];
                $message['descriere'] = $_GET['descriere'];
                die( json_encode($message) );
            }
        }
        return View::make('admin.camere.createroomtype', $page_nav);
    }



/**
 *
 *  <===== ADMINISTRARE ORASE =====>
 *
*/

    public function getCities(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $cities = DB::select("SELECT * FROM cities");
        return View::make('admin.orase.cities', $page_nav)->with('cities', $cities);
    }

    public function getNewcity(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        return View::make('admin.orase.add', $page_nav);
    }

    public function postNewcity(){
        $input = Input::all();
        DB::table('cities')->insert(array(
            'city_name'     => $input['city']
            ));
        Session::put('ok_message', 'Noul oras adaugat cu succes');
        return Redirect::to('admin/cities');
    }

    public function getEditcity($id){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $city = DB::select("SELECT * FROM cities WHERE city_id = $id");
        return View::make('admin.orase.edit', $page_nav)->with('city', $city);
    }

    public function postEditcity($id){

        $input = Input::all();
        DB::table('cities')
        ->where('city_id', $id)
        ->update(array(
            'city_name'     => $input['city']
            ));
        Session::put('ok_message', 'Numele orasului editat cu succes');
        return Redirect::to('admin/cities');
    }

    public function postDeletecity($id){
        DB::table('cities')->where('city_id', '=', $id)->delete();
    }

    public function getAddcity(){

        $message = array('error' => "", 'success' => "", 'message' => "", 'id' => 0 );
        if(isset($_GET['modal'])) {
            $page_nav['is_ajax'] = 'onclick="return adauga_oras();"';
            if( $_GET['modal'] == 1) {
                if( $_GET['nume'] == "" ) {
                   $message['error'] = "Introdu numele\n";
                }
                if( $message['error']  != "" ) {
                    die( json_encode($message) );
                }
                DB::table('cities')->insert( array( 
                    'city_name'     => $_GET['nume']
                    ));
                $name = $_GET['nume'];
                $id = DB::select("SELECT city_id FROM cities WHERE city_name='$name' ");
                $message['oras_id'] = $id[0]->city_id;
                $message['success'] = "succes";
                $message['nume'] = $_GET['nume'];
                die( json_encode($message) );
            }
        }
        return View::make('admin.orase.createcities', $page_nav);
    }



/**
 *
 *  <===== ADMINISTRARE FACILITATI =====>
 *
*/

    public function getFacilities(){
        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $facilities = DB::select("SELECT * FROM facilities");
        return View::make('admin.facilitati.facilities', $page_nav)->with('facilities', $facilities);
    }

    public function getNewfacility(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        return View::make('admin.facilitati.add', $page_nav);
    }

    public function postNewfacility(){
        $input = Input::all();
        DB::table('facilities')->insert(array(
            'facility_name'     => $input['facility']
            ));
        Session::put('ok_message', 'Facilitate adaugat cu succes');
        return Redirect::to('admin/facilities');
    }

    public function getEditfacility($id){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $facility = DB::select("SELECT * FROM facilities WHERE facility_id = $id");
        return View::make('admin.facilitati.edit', $page_nav)->with('facility', $facility);
    }

    public function postEditfacility($id){

        $input = Input::all();
        DB::table('facilities')
        ->where('facility_id', $id)
        ->update(array(
            'facility_name'     => $input['facility']
            ));
        Session::put('ok_message', 'Facilitate editat cu succes');
        return Redirect::to('admin/facilities');
    }

    public function postDeletefacility($id){
        DB::table('facilities')->where('facility_id', '=', $id)->delete();
    }

    public function getAddfacility(){

        $message = array(
            'error' => "",
            'success' => "",
            'message' => "",
            'id' => 0
            );

        if(isset($_GET['modal'])) {
            $page_nav['is_ajax'] = 'onclick="return adauga_facilitate();"';
            if( $_GET['modal'] == 1) {
                if( $_GET['nume'] == "" ) {
                    $message['error'] = "Introdu numele\n";
                }
                if( $message['error']  != "" ) {
                    die( json_encode($message) );
                }
                DB::table('facilities')->insert( array( 
                    'facility_name'     => $_GET['nume'] 
                    ));
                $nume = $_GET['nume'];
                $id = DB::select("SELECT facility_id FROM facilities WHERE facility_name = '$nume' ");
                $message['facility_id'] = $id[0]->facility_id;
                $message['success'] = "succes";
                $message['nume'] = $_GET['nume'];
                die( json_encode($message) );
            }
        }
        return View::make('admin.facilitati.createfacility', $page_nav);
    }

    public function postFacilities (){

        $l = DB::select("SELECT * FROM facilities ORDER BY facility_name ASC;");
        print(json_encode($l));
    }



/**
 *
 *  <===== ADMINISTRARE FACILITATI CAMERA =====>
 *
*/

    public function getRoomfacilities(){
        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $facilities = DB::select("SELECT * FROM facilities_room");
        return View::make('admin.facilitaticamera.roomfacilities', $page_nav)->with('facilities', $facilities);
    }

    public function getNewroomfacility(){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        return View::make('admin.facilitaticamera.add', $page_nav);
    }

    public function postNewroomfacility(){
        $input = Input::all();
        DB::table('facilities_room')->insert(array(
            'room_facility_name'     => $input['facility']
            ));
        Session::put('ok_message', 'Facilitate adaugat cu succes');
        return Redirect::to('admin/facilitaticamera');
    }

    public function getEditroomfacility($id){

        $page_nav = PreparePageModel::PreparePage('Admin Area');
        $facility = DB::select("SELECT * FROM facilities_room WHERE facility_id = $id");
        return View::make('admin.facilitaticamera.edit', $page_nav)->with('facility', $facility);
    }

    public function postEditroomfacility($id){

        $input = Input::all();
        DB::table('facilities_room')
        ->where('room_facility_id', $id)
        ->update(array(
            'room_facility_name'     => $input['facility']
            ));
        Session::put('ok_message', 'Facilitate editat cu succes');
        return Redirect::to('admin/facilitaticamera');
    }

    public function postDeleteroomfacility($id){
        DB::table('facilities')->where('facility_id', '=', $id)->delete();
    }

    public function getAddroomfacility(){

        $message = array(
            'error' => "",
            'success' => "",
            'message' => "",
            'id' => 0
            );

        if(isset($_GET['modal'])) {
            $page_nav['is_ajax'] = 'onclick="return adauga_room_facilitate();"';
            if( $_GET['modal'] == 1) {
                if( $_GET['nume'] == "" ) {
                    $message['error'] = "Introdu numele\n";
                }
                if( $message['error']  != "" ) {
                    die( json_encode($message) );
                }
                DB::table('facilities_room')->insert( array( 
                    'room_facility_name'     => $_GET['nume'] 
                    ));
                $nume = $_GET['nume'];
                $id = DB::select("SELECT room_facility_id FROM facilities_room WHERE room_facility_name = '$nume' ");
                $message['facility_id'] = $id[0]->facility_id;
                $message['success'] = "succes";
                $message['nume'] = $_GET['nume'];
                die( json_encode($message) );
            }
        }
        return View::make('admin.facilitaticamera.createfacility', $page_nav);
    }

    public function postRoomfacilities (){

        $l = DB::select("SELECT * FROM facilities_room ORDER BY room_facility_name ASC;");
        print(json_encode($l));
    }

}