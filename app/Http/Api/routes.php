<?php

Route::get('/', 'ApiController@index');

Route::group(['prefix' => 'cb'],function(){
    Route::get('/','CBController@index');
});