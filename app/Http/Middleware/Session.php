<?php

namespace App\Http\Middleware;

use Cookie;
use Redirect;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

use DB;
use App\Http\Middleware\Auth;

class Session extends Model{
    protected $table = 'session';
    public $timestamps = false;
    
    //public static $session_id;
    public static $data;
    
    public function __construct(){
        
    }
    
    private function init(){
        $sessionCookieName = md5('cookiename');
        $sessioncookie = Cookie::get($sessionCookieName);
        
        $sessionValueCheck = $this->sessionCookieValue($sessioncookie);
        
        Session::purge(); //удаляем старые сессии
        
        //загружаем сессию
        $session = self::where('session_id', '=', $sessionValueCheck)->take(1)->get();
        
        
        if($sessioncookie && strlen($sessioncookie) == 32 && count($session)){ 
            Session::$data = $session[0];
            $this->updateSession();
        }else{    //создаем сессию
            $this->createSession();
        }
        
        if (!empty($this->session->session_id)) {
            session_id($Session::$data->session_id);
        }
        
        $this->checkAuthorisation();
        
        session_start();
    }
    
    private function checkAuthorisation(){
        if(Session::getData()->userid > 0){
            Auth::getUser(Session::getData()->userid);
        }
    }
    
    public static function getData(){
        return Session::$data;
    }
    
    public static function auth($user){
        Session::$data->guest = '0';
        Session::$data->username = $user->email;
        Session::$data->userid = (int) $user->id;
        //Session::$data->usertype = "user";
        Session::$data->gid = (int) $user->gid;
        Session::$data->ip = $_SERVER["REMOTE_ADDR"];
        Session::$data->user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        Session::$data->save();
        
    }
    
    public static function purge(){
        $past_logged    = time() - 6000; //1800
        $past_guest     = time() - 7200;

        self::whereRaw(
                    " ( time < '" . (int)$past_logged . "' AND (gid = 1 OR gid = 2) )"
                    . " OR "
                    . " (time < '" . (int)$past_guest . "' AND guest = 0 AND (gid = 0 OR gid > 2))"
                    . " OR "
                    . " ( time < '" . (int)$past_guest . "' AND guest = 1)"
                )->delete();
    }
    
    private function updateSession(){
        self::where('session_id', Session::$data->session_id)->update(array('time' => time()));
    }
    
    private function createSession(){
        $sessionCookieName = md5('cookiename'); //название куки
        
        Session::$data = new self();

        Session::$data->guest = 1;
        Session::$data->username = '';
        Session::$data->time = time();
        Session::$data->gid = 0;
        Session::$data->session_id = $this->generateId();
        Session::$data->save();
        
        setcookie($sessionCookieName, $this->session_cookie, false, '/');
    }
    
    public function generateId(){
        $this->session_cookie = md5( uniqid( microtime(), 1 ) );
        $session_id = $this->sessionCookieValue( $this->session_cookie );
        
        $results = DB::select(  //проверяем уникальность
                    "SELECT `session`.* "
                    . " FROM `session` "
                    . " WHERE `session`.`session_id` = ? LIMIT 1", array($session_id)
                );
        if($results){
            $session_id = $this->generateId();
            return $session_id;
        }
        
        return $session_id;
    }

    public function sessionCookieValue($id = null) {
        $type = 2;

        $browser = @$_SERVER['HTTP_USER_AGENT'];

        switch ($type) {
            case 2:
                $value = md5($id . $_SERVER['REMOTE_ADDR']);
                break;
            case 1:
                $remote_addr = explode('.', $_SERVER['REMOTE_ADDR']);
                $ip = $remote_addr[0] . '.' . $remote_addr[1] . '.' . $remote_addr[2];
                $value = mosHash($id . $ip . $browser);
                break;
            default:
                $ip = $_SERVER['REMOTE_ADDR'];
                $value = mosHash($id . $ip . $browser);
                break;
        }

        return $value;
    }
    
    public function handle($request, Closure $next){
        $this->init();
        
        return $next($request);
    }
}