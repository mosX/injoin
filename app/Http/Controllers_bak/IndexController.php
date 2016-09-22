<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App;
//use Assets;
use View;
use Config;

use DB;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Middleware\Auth;


class IndexController extends Controller{
    public function index(){
        return view('index.index',array(
                'user' => Auth::user()
                ,"test"=>"tseteste"
            ));
    }
    
}
