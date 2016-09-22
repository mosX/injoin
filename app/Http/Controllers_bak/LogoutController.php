<?php

namespace App\Http\Controllers;

use Auth;
use Redirect;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class LogoutController extends Controller{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct(){
    
    }
    
    public function index(){
        Auth::logout();
        return Redirect::to('/')->with('message', 'Login Failed');
    }
    
    
}
