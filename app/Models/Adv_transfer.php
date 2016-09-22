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
        return $this->hasMany('App\Models\Seat','transfer_id','id');
    }
    
    public static function addNew($adv_id,$transfer_id){
        $row = new self();
        $row->adv_id = $adv_id;
        $row->transfer_id = $transfer_id;
        return $row->save();
    }
    
    public static function getSelected($id){
        $data = self::with('seats')->where('adv_id' ,'=',$id)->get();;
        
        return $data;
    }
}
