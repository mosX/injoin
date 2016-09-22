<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\validators\CustomValidator;
//use Illuminate\Validation\Validator;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Validator::extendImplicit('foo', 'App\Validators\CustomValidator@validateFoo');
        Validator::extendImplicit('type', 'App\Validators\CustomValidator@validateType');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        
    }
}
