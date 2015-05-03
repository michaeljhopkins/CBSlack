<?php

Route::group(['prefix' => 'cb'],function(){
    Route::resource('organizations','OrganizationController@index');
    Route::resource('products','ProductController@index');
    Route::resource('people','PeopleController@index');
});