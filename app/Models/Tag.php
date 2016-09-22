<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Hash;

use App\Http\Middleware\Auth;


class Tag extends Model{
    public $timestamps = false;
    
    public function advertisement(){    //связь с таблицей картинок
        return $this->hasOne('App\Models\Advertisement','id','adv_id');
    }
}
