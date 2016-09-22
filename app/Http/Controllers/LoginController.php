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

class LoginController extends Controller{
    public function __construct(){
        
    }
    
    public function getIndex(){
        //p(Auth::user());
        //return view('login.index',array('posts' => '1111',"test"=>"tseteste"));
        return 'TEST';
    }
    
    public function postIndex(Request $post){
        $email = $post->input('email');
        $password = $post->input('password');
                 
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            echo '{"status":"success"}';
        }else{
            echo '{"status":"error"}';
        }
    }
}
