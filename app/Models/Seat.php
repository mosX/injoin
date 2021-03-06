<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Hash;

use App\Http\Middleware\Auth;


class Seat extends Model{
    public $timestamps = false;
    
    public function reserved(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Seat_reservation','seat_id','id');
    }
       
    public static function add($id,$post){
        
        
        $row = new self();        
        $row->transfer_id = $id;
        $row->x_pos = $post->x;
        $row->y_pos = $post->y;
        $row->date = date('Y-m-d H:i:s');
        $row->save();
        
        return $row->id;
    }
    
    public static function editInfo($id, $post){
        $data = self::getPosition($id);
        
        $data->number = $post->number;
        $data->description = $post->description;
        $data->save();
    }

    public static function edit($id, $post){
        $data = self::getPosition($_POST['seat_id']);
        
        $data->x_pos = $_POST['x'];
        $data->y_pos = $_POST['y'];
        return $data->save();
    }
    
    public static function getPosition($id){
        $data = self::where('id','=',$id)
                ->get();
        
        return $data[0];
    }
    
    public static function get($id){
        $data = self::with(['reserved'=>function($query){
                    $query->where('status','=','1');
                }])->where('transfer_id','=',$id)
                ->get();
        
        /*foreach($data as $item){
            if($item->reserved){
                p($item->reserved->id);
            }
        }*/
        
        if($data->isEmpty())return null;
        
        return $data;
    }
}
