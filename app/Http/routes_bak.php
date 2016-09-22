<?php
    Route::group(['middleware' => ['session']], function(){
        Route::group(['middleware' => ['loggedIn']], function(){
            Route::get('login', 'LoginController@getIndex');
            Route::post('login', 'LoginController@postIndex');

            Route::get('/advertisement/create/', 'AdvertisementController@create');
        });

        Route::group(['middleware' => ['loggedOut']], function(){
            
        });
        Route::get('/', 'IndexController@index');
    });
?>