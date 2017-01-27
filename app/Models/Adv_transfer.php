<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Middleware\Auth;

use Redirect;
use Validator;  

use App\Validator\CustomValidator;

class Adv_transfer extends Model{
    public $timestamps = false;
    
    public function seats(){
        return $this->hasMany('App\Models\Seat','transfer_id','transfer_id');
    }
    
    public function transfer(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Transfer','id','transfer_id');
    }
    
    public static function addNew($adv_id,$transfer_id){
        $row = new self();
        $row->user_id = Auth::user()->id;
        $row->adv_id = $adv_id;
        $row->transfer_id = $transfer_id;
        return $row->save();
    }
    
    public static function remove($id){
        $data = self::where('user_id' ,'=',Auth::user()->id)->where('id' ,'=',$id)->get();
        $data[0]->status = 0;
        return $data[0]->save();
    }
    
    public static function getSelected($id){
        //$data = self::with('seats','transfer')
        $data = self::with('seats')                
                ->where('adv_id' ,'=',$id)
                ->where('user_id' ,'=',Auth::user()->id)
                ->where('status' ,'=','1')
                ->get();
        
        /*foreach($data as $item){
            if($item->transfer){
                p($item->transfer->name);
            }
        }*/
        return $data;
    }
}
