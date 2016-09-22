<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Hash;

use App\Http\Middleware\Auth;


class Transfer extends Model{
    public $timestamps = false;
    
    /*public function advertisement(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Advertisement','id','adv_id');
    }*/
    
    public static function getAll(){
        $rows = self::orderBy('id','DESC')->get();
        
        return $rows;
    }
    
    public static function add($post){
        $row = new self();
        $row->user_id = Auth::user()->id;
        $row->description = $post->description;
        $row->name = $post->name;
        $row->type = $post->type;
        $row->date = date('Y-m-d H:i:s');
        $row->save();
        
    }
}
