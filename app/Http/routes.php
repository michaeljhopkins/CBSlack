<?php

Route::get('test','TestController@get');
Route::post('test','TestController@post');

Route::group(['prefix' => 'api'],function() {
    Route::get('organization/{name}', 'OrganizationsController@findOrSearch');
    #Route::resource('people', 'PersonsController');
});