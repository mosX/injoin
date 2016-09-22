<?php
namespace App\Models;

use App\Models\Authorisation;

class Registration{
    public function test(){
        dd('registration');
    }
    
    public function getUser(){
        dd(Authorisation::$user);
    }
}
