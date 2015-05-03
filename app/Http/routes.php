<?php
Route::get('heartbeat','TestController@heartbeat');

Route::get('test','TestController@get');
Route::post('test','TestController@post');

Route::group(['prefix' => 'api'],function() {
    Route::post('organization', 'OrganizationsController@findOrSearch');
    Route::post('person','PersonsController@findOrSearch');


    #Route::resource('people', 'PersonsController');
});