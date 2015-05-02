<?php

Route::get('/', 'ApiController@index');

Route::group(['prefix' => 'cb'],function(){
    Route::get('/','CBController@index');
    Route::get('organization/{uuid}','CBController@show');
});