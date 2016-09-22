<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App;
use View;
use Config;

use Route;

use DB;
use Illuminate\Http\Request;
//use App\Http\Requests;
use App\Http\Middleware\Auth;

use Validator;

use App\Models\Seat;

use App\Models\Tag;
use App\Models\Advertisement;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Image;

use Redirect;

class EventsController extends Controller{
    
    public function editTransfer($id){
        $adv = Advertisement::getCurrent($id);
        //dd($adv);
        
        $data = Seat::get($id);
        return view('events.edit_transfer',['data'=>$data,'errors'=>null,'post'=>null]);
    }
    
}
