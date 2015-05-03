<?php

Route::get('test','TestController@get');
Route::post('test','TestController@post');

Route::resource('organizations','OrganizationsController');
Route::resource('products','ProductsController');
Route::resource('people','PersonsController');