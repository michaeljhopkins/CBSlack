<?php

Route::get('/', 'ApiController@index');

Route::group(['prefix' => 'cb'],function(){
    Route::get('/','CBController@index');
    Route::get('organizations','OrganizationController@index');
    Route::get('products','ProductController@index');
    Route::get('people','PeopleController@index');
});