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

use App\Models\Seat;

use App\Models\Transfer;
use App\Models\Reservation;
use App\Models\Seat_reservation;
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
    
    public function gettransfer($id){
        $seats = Seat::get($id);
        echo $seats->toJson();
    }
    
    public function reserv_seat($id,Request $post){
        if(Seat_reservation::reserv($post)){
            $seats = Seat::get($post->transfer_id);
            
            echo '{"status":"success","data":'.$seats->toJson().'}';            
        }else{
            echo '{"status":"error","message":"'.Seat_reservation::$error.'"}';
        }
    }
    
    public function registration($id){
        $adertisement = new Advertisement();
        $data = $adertisement->getCurrent($id);
        
        $reservation = new Reservation();
        $reserv = $reservation->checkReservation($id);
        
        $transfer_list = Transfer::getAdvList($id);//получаем транспорт
        
        //получаем места в первом транспорте что получили          
        $seats = Seat::get($transfer_list[0]->transfer_id);                
        
        return view('reservation.registration',['id'=>$id,'data' => $data,'reservations'=>$reserv,'transfer_list'=>$transfer_list,'seats'=>$seats]);
    }
    
    public function registration_post($id){
        $adertisement = new Advertisement();
        $data = $adertisement->getCurrent($id);
        
        $reservation = new Reservation();
        
        if($reservation->addNew($data)){
            return Redirect::route('reservation.registration',['id'=>$id]);
        }
        
        //return view('reservation.registration',['data' => $data,'reservations'=>'']);
    }
    
    public function show($id){
        return view('reservation.show',['data'=>Reservation::getReservations($id)]);
    }
}
