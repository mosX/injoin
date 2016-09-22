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

class AdvertisementController extends Controller{
    
    public function index(){
        
        /*return view('index.index',array(
                'user' => Auth::user()
                ,"test"=>"tseteste"
            ));*/
    }
    
    public function create(){
        return view('advertisement.create',array(
                'user' => Auth::user()
                ,"test"=>"tseteste"
            ));
    }
    
}
