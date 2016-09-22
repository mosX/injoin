<?php

namespace App\Http\Middleware;

//use Auth;
use App\Http\Middleware\Auth;
use Redirect;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoggedIn {
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle($request, Closure $next){
        if(!Auth::user()){
            return Redirect::to('/');
        }
        
        return $next($request);
    }
}
