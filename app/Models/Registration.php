<?php
namespace App\Models;

use App\Models\Authorisation;

use Validator;  
//use Illuminate\Validation\Rule;
use App\Validator\CustomValidator;



class Registration{
    static $errors;
    
    public function test(){
        dd('registration');
    }
    
    public function getUser(){
        dd(Authorisation::$user);
    }
    
    static function init($post){
        //p($post);
        $validator = Validator::make(
            [
                'firstname' => $post->firstname,
                'lastname' => $post->lastname,
                'email' => $post->email,
                'password' => $post->password,
                'password_conf' => $post->password,
                'password_confirmation' => $post->conf_password,
            ],
            [
                'firstname' => 'required|min:2|max:255',
                'lastname' => 'required|min:2|max:255',
                'email' => ['required','min:15','max:255','unique:users,email'],
                'password' => 'required',
                'password_conf' => 'required|confirmed'                
            ],
            [
                'firstname.required' => 'Имя недопустимой длины',
                'lastname.required' => 'Фамилия недопустимой длины',
                'email.required' => 'Имейл недопустимой длины',
                'email.exist' => 'Такой имейл уже занят',
                'password.required' => 'Вы должны ввести пароль',
                'password_conf.confirmed' => 'Пароли не совпадают',
                'password_conf.required' => 'Вы должны ввести подтверждение пароля',
            ]
        );
        
        if ($validator->fails()){
            self::$errors = $validator->errors();
            p(self::$errors);
            return false;
        }
        
        return true;
    }
}
