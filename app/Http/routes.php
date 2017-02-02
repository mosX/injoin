<?php
    Route::group(['middleware' => ['session']], function(){
        Route::group(['middleware' => ['loggedIn']], function(){
            Route::get('logout', 'LogoutController@index');
            
            Route::get('/events/transfer_edit/{id}', ['as' => 'events.transfer_edit', 'uses' => 'EventsController@editTransfer']);
            
            
            Route::get('/transfer/create/', ['as' => 'transfer.create', 'uses' => 'TransferController@create']);
            Route::post('/transfer/create/', ['as' => 'transfer.create_post', 'uses' => 'TransferController@create_post']);
            
            Route::get('/transfer/view/', ['as' => 'transfer.view', 'uses' => 'TransferController@view']);
            Route::get('/transfer/view/{id}', ['as' => 'transfer.view', 'uses' => 'TransferController@view_seats']);
            
            Route::get('/transfer/seats/{id}/', ['as' => 'transfer.seats', 'uses' => 'TransferController@seats']);
            Route::post('/transfer/seats/{id}/', ['as' => 'transfer.seats_post', 'uses' => 'TransferController@seats_post']);
            
            Route::post('/transfer/seats/{id}/edit', ['as' => 'transfer.seats_edit', 'uses' => 'TransferController@seats_edit']);
            Route::get('/transfer/seats/{id}/modal/{seat}', ['as' => 'transfer.seats_modal', 'uses' => 'TransferController@seats_modal']);
            
            Route::post('/transfer/seats/info/{seat}', ['as' => 'transfer.seats_edit', 'uses' => 'TransferController@seats_edit_info']);
            
            //ADVERTISEMENT
            Route::group(['prefix' => 'advertisement', 'as' => 'advertisement.'], function(){
                Route::get('/create/', ['as' => 'create', 'uses' => 'AdvertisementController@create']);
                Route::post('/create/', ['as' => 'createPost', 'uses' => 'AdvertisementController@createPOST']);

                Route::get('/', ['as' => 'index', 'uses' => 'AdvertisementController@index']);
                Route::post('/{id}', ['as' => 'changeStatus', 'uses' => 'AdvertisementController@changeAdvStatus']);

                Route::get('/show/{id}', ['as' => 'show', 'uses' => 'AdvertisementController@show']);
                Route::get('/search/', ['as' => 'search', 'uses' => 'AdvertisementController@search']);
                            
                //ADVERTISEMENT EDIT
                Route::group(['prefix' => 'edit', 'as' => 'edit.'], function(){
                    Route::get('/transfer_preview/{id}', ['uses' => 'AdvertisementController@transfer_preview']);
                    Route::get('/transfer_remove/{id}', ['uses' => 'AdvertisementController@transfer_remove']);
                    Route::get('/transfer/{id}', ['as' => 'transfer', 'uses' => 'AdvertisementController@edit_transfer']);
                    Route::post('/transfer/{id}', ['uses' => 'AdvertisementController@add_transfer']);
                    
                    Route::get('/common/{id}', ['as' => 'common', 'uses' => 'AdvertisementController@edit_common']);                    
                    Route::post('/common/{id}',['uses' => 'AdvertisementController@edit_common_post']);

                    Route::get('/photo/{id}', ['as' => 'photo', 'uses' => 'AdvertisementController@edit_photo']);                    
                    Route::get('/photo/setcover/{image_id}/{adv_id}', ['uses' => 'AdvertisementController@setalbumcover']);
                    Route::get('/photo/remove/{image_id}', ['uses' => 'AdvertisementController@removeimage']);
                    
                    Route::get('/addphoto/{id}', [ 'as' => 'addphoto',  'uses' => 'AdvertisementController@addphoto_get']);
                    Route::post('/addphoto/{id}', [ 'as' => 'addphoto',  'uses' => 'AdvertisementController@addphoto_post']);
                            
                    Route::get('/description/{id}', ['as' => 'description', 'uses' => 'AdvertisementController@edit_description']);
                    Route::post('/description/{id}', ['as' => 'description_post', 'uses' => 'AdvertisementController@edit_description_post']);
                        
                    Route::get('/address/{id}', ['as' => 'address', 'uses' => 'AdvertisementController@edit_address']);
                    Route::post('/address/{id}', ['uses' => 'AdvertisementController@edit_address_post']);
                    
                    Route::get('/advanced/{id}', ['as' => 'advanced', 'uses' => 'AdvertisementController@edit_advanced']);                    
                 });
            });
            
            //PROFILE
            Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
                Route::get('/completed', ['as' => 'completed', 'uses' => 'ProfileController@completed']);
                Route::get('/moderated', ['as' => 'moderated', 'uses' => 'ProfileController@moderated']);
                Route::get('/signed', ['as' => 'signed', 'uses' => 'ProfileController@signed']);
                Route::get('/', ['as' => 'index', 'uses' => 'ProfileController@index']);
                
                Route::get('/updateava', ['as' => 'updateava', 'uses' => 'ProfileController@updateava']);
                Route::post('/updateava', ['as' => 'updateava', 'uses' => 'ProfileController@updateava_post']);
                
                Route::get('/edit/common', ['as' => 'edit.common', 'uses' => 'ProfileController@edit_common']);
                Route::get('/edit/personal', ['as' => 'edit.personal', 'uses' => 'ProfileController@edit_personal']);
                Route::get('/edit/photo', ['as' => 'edit.photo', 'uses' => 'ProfileController@edit_photo']);
            });
            
            Route::group(['prefix' => 'reservation', 'as' => 'reservation.'], function(){
                Route::get('/', ['as'=>'index', 'uses'=> 'ReservationController@index']);
                Route::get('/confirm/{id}', ['as'=>'confirm', 'uses'=> 'ReservationController@confirm']);
                Route::get('/show/{id}/', ['as'=>'show','uses'=> 'ReservationController@show']);
                Route::get('/registration/{id}/', ['as'=>'registration','uses'=> 'ReservationController@registration']);
                Route::post('/registration/{id}/', ['as'=>'registration','uses'=> 'ReservationController@registration_post']);
                
                Route::post('/registration/seat/{id}/', ['uses'=> 'ReservationController@reserv_seat']);
                Route::get('/registration/gettransfer/{id}/', ['uses'=> 'ReservationController@gettransfer']);
            });
        });

        Route::group(['middleware' => ['loggedOut']], function(){
            Route::get('login', 'LoginController@getIndex');
            Route::post('login', 'LoginController@postIndex'); 
            
            Route::post('/registration', 'RegistrationController@registrate'); 
        });
        
        Route::get('/', 'IndexController@index');
        Route::get('/advertisement/colision/', 'AdvertisementController@colision');
        Route::get('/advertisement/game/', 'AdvertisementController@game');
        Route::get('/advertisement/vector/', 'AdvertisementController@vector');
        
    });
?>