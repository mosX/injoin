<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App;
use View;
use Config;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Middleware\Auth;

use Redirect;

use App\Models\Reservation;
use App\Models\Advertisement;

class ReservationController extends Controller{
    
    public function index(){
        $reservation = new Reservation();
        
        return view('reservation.index',array(
                'data' => $reservation->getList()
            ));
    }
    
    public function confirm($id){
        if(Reservation::confirm($id)){
            return '{"status":"success"}';
        }else{
            return '{"status":"error"}';
        }
    }
    
    public function registration($id){
        $adertisement = new Advertisement();
        $data = $adertisement->getCurrent($id);
        
        $reservation = new Reservation();
        $reserv = $reservation->checkReservation($id);
        
        return view('reservation.registration',['data' => $data,'reservations'=>$reserv]);
    }
    
    public function show($id){
        return view('reservation.show',['data'=>Reservation::getReservations($id)]);
    }
    
    public function registration_post($id){
        $adertisement = new Advertisement();
        $data = $adertisement->getCurrent($id);
        
        $reservation = new Reservation();
        
        if($reservation->addNew($data)){
            return Redirect::route('advertisement.registration',['data' => $data,'reservations'=>'']);
        }
        
        //return view('reservation.registration',['data' => $data,'reservations'=>'']);
    }
}
