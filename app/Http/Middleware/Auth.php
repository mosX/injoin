<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redirect;

use App\Http\Middleware\Session;
use Illuminate\Database\Eloquent\Model;
use DB;

use App\Models\User;

class Auth extends Model{
    protected $table = 'x_session';
    public $timestamps = false;
    public static $error;
    public static $_user;
    
    public function __construct() {

    }
    
    public static function getUser($id){
        $row = User::where('id','=',$id)
                ->where('status','=','1')
                ->whereIn('gid',array(1,2))
                ->limit(1)
                ->get();
        
        if($row){
            Auth::$_user = $row[0];
            return Auth::$_user;
        }else{
            return null;
        }
    }
    
    public static function check(){
        if(Auth::$_user){
            return true;
        }else{
            return false;
        }
    }
    
    public static function user(){
        if(Auth::$_user){
            return Auth::$_user;
        }else{
            return null;
        }
    }
    
    public static function logout(){
        return Session::getData()->delete();
    }
    
    public static function makePassword($length=8){
        $salt            = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $makepass        = '';
        mt_srand(10000000*(double)microtime());
        for ($i = 0; $i < $length; $i++)
            $makepass .= $salt[mt_rand(0,61)];
        return $makepass;
    }
    
    public static function Hash($password){
        $salt = Auth::makePassword(16);
        $crypt = md5(md5($password) . $salt);
        $password = $crypt . ':' . $salt;
        
        return $password;
    }
    
    public static function checkHash($hashed, $original){
        list($hash, $salt) = explode(':', $hashed);
        $cryptpass = md5(md5($original) . $salt);
                
        return ($hash != $cryptpass) ? false : true;
    }
    
    public static function attempt($data){
        $email = stripslashes(strval($data['email']));
        $password = stripslashes(strval($data['password']));
                
        if (!$email || !$password) {
            Auth::$error = 'Вы не ввели данные';
            return false;
        }
        
        if(!Session::getData()->session_id){
            Auth::$error = 'Ошибка сессии';
            return false;
        }
        
        $row = User::where('email','=',$email)
                ->where('status','=','1')
                ->whereIn('gid',array(1,2))
                ->limit(1)
                ->get();
        
        if(!$row){
            Auth::$error = 'Такого пользователя не найдено';
            return false;    
        }
        
        $user = $row[0];
        
        if ((int)$user->bad_auth >= 5){
            Auth::$error = 'Данный аккаунт был заблокирован после 5ти неудачных попыток входа!';
            return false;
        }
        
        if(!Auth::checkHash($user->password,$password)){
            $user->bad_auth += 1;
            $user->last_modified = date("Y-m-d H:i:s");
            $user->save();
            
            if ($user->bad_auth >= 5) {
                Auth::$error = 'Ваш акаунт был заблокирован.';
                return false;
            }

            Auth::$error = 'Пароль не совпадает';
            return false;
        }
        
        Session::auth($user);
        
        $user->last_login = date("Y-m-d H:i:s");
        $user->last_ip = $_SERVER["REMOTE_ADDR"];
        $user->bad_auth = 0;
        $user->save();
        
        return true;
    }
}
