<?php
namespace App\Http\Controllers;

use Redirect;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Http\Middleware\Auth;
use Illuminate\Http\Request;

use App\Http\Middleware\Session;

use App\Models\Registration;

class RegistrationController extends Controller{
    public function __construct(){
        
    }
    
    public function registrate(Request $post){
        
        //echo '{"status":"test"}';
        
        if(Registration::init($post)){
            echo '{"status":"true"}';
        }else{
            echo '{"status":"false"}';
        }
    }
}
