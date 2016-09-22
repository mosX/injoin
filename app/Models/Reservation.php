<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Auth;

class Reservation extends Model{
    public $timestamps = false;
    protected $table = 'reservation';
    
    public function advertisement(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Advertisement','id','adv_id');
    }
    
    public function user(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\User','id','user_id');
    }
    
    public static function getMyModeratedReservations(){
        $data = self::with(['advertisement'=>function($query){
                    $query->with('tags');
                }])
                ->where('user_id' ,'=', Auth::user()->id)
                ->where('moderation','=','1')
                ->get();
        
        return $data;
    }
    
    public static function getMyCompletedReservations(){
        $data = self::with(['advertisement'=>function($query){
                    $query->with('tags');
                }])
                ->where('user_id' ,'=', Auth::user()->id)
                ->where('moderation','=','1')
                ->get();
        
        return $data;
    }
    
    public static function getMySignedReservations(){
        $data = self::with(['advertisement'=>function($query){
                    $query->with('tags');
                    //return $query;
                }])
                ->where('user_id' ,'=', Auth::user()->id)
                ->where('moderation','!=','1')
                ->get();
        
        return $data;
    }
            
    public function getList(){
        $data = self::where('user_id' ,'=', Auth::user()->id)->get();
        
        return $data;
    }
   
    public function checkReservation($id){
        $data = self::where('user_id' ,'=', Auth::user()->id)->where('adv_id' ,'=', $id)->get();
        if($data->isEmpty()){
            return null;
        }
               
        return $data;
    }
    
    public static function confirm($id){
        $data = self::where('id','=',$id)->where('author_id','=',Auth::user()->id)->limit(1)->get();
        
        $data[0]->moderation = 1;
        return $data[0]->save();
    }
    
    public static function getReservations($id){
        $data = self::with('user')->where('author_id' ,'=', Auth::user()->id)->where('adv_id' ,'=', $id)->get();
        
        return $data;
    }


    public function countReservations($id){
        $count = self::where('adv_id' ,'=', $id)->count();
        
        return $count;
    }
    
    public function addNew($data){
        
        if(!$data){
            $this->error = 'Такого объявления не существует';
            return false;
        }

        if($this->checkReservation($data->id)){
            $this->error = 'Вы уже были подписаны на данное событие';
            return false;
        }
        
        $row = new self();
        $row->user_id = Auth::user()->id;
        $row->author_id = (int)$data->user_id;
        $row->adv_id = (int)$data->id;
        $row->moderation = $data->with_moderation == 1? 0:1;
        $row->status = 1;
        $row->date = date('Y-m-d H:i:s');
        
        return $row->save();        
   
        
    }
}
