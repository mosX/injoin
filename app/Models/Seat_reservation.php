<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Auth;

use Redirect;
use Validator;  

use App\Validator\CustomValidator;

class Seat_reservation extends Model{
    public $timestamps = false;
    static public $error = '666';
    
    static function reserv($post){
        //проверяем или уже не зарегестрирован и если да то удаляем старые записи
        self::where('status','=','1')->where('adv_id','=',$post->adv_id)->where('user_id','=',Auth::user()->id)->update(['status'=>0]);
        /*if(!$data->isEmpty()){
            Seat_reservation::$error = 'Вы уже заняли место в данной поездке';
            
            return false;
        }*/
        
        $row = new self();
        $row->user_id = Auth::user()->id;
        $row->transfer_id = $post->transfer_id;
        $row->seat_id = $post->seat_id;
        $row->adv_id = $post->adv_id;
        $row->date = date('Y-m-d H:i:s');
        
        return $row->save();
    }
}
