<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use Hash;


class User extends Model{
    public $timestamps = false;
    
    public function validate($request){
        

        $this->validation = Validator::make($request->all(),[
            'email' => 'required|unique:users,email|max:255',
            'password' => 'required|max:255',
            'phone' => 'required|max:100',
            'name' => array('required', 'regex:/^[a-zA-Zа-яА-Я0-9]{1,40} [a-zA-Zа-яА-Я0-9]{1,40}$/'),
            'company' => 'max:100',
        ],[
            'email.required' => 'Вы должны ввести имейл',
            'password.required' => 'Вы должны ввести пароль',
            'phone.required' => 'Вы должны ввести телефон',
            'name.required' => 'Вы должны ввести имя',
            'name.regex' => 'Не правильный формат',
        ]);
        
        return $this->validation->fails() ? false : true;
    }
    
    public function registrate($request){
        $user = new self();
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            list($user->firstname,$user->lastname) = explode(' ',$request->name);
            $user->phone = $request->phone;
            $user->company = $request->company;
            $user->status = 1;
            $user->date = date("Y-m-d H:i:s");
        $user->save();
    }
}
