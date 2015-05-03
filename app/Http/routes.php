<?php
Route::get('heartbeat','TestController@heartbeat');

Route::get('test','TestController@get');
Route::post('test','TestController@post');

Route::group(['prefix' => 'api'],function() {
    Route::get('log','SentimentController@fromSlack');
    Route::post('log',function(){
        Queue::marshal();
    });
    Route::post('organization', 'SentimentController@test');
    Route::post('person','PersonsController@findOrSearch');
    #Route::resource('people', 'PersonsController');
});