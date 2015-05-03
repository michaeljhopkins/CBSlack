<?php

Route::group(['prefix' => 'cb'],function(){
    Route::resource('organizations','OrganizationsController@index');
    Route::resource('products','ProductsController@index');
    Route::resource('people','PersonsController@index');
});