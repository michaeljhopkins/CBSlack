<?php
/**
 * Created by PhpStorm.
 * User: michaelkantor
 * Date: 1/12/15
 * Time: 1:55 PM
 */
$requestController = "Drapor\\Networking\\Controllers\\RequestsController";

Route::get('/networking/requests',"{$requestController}@index");
Route::post('/networking/requests',"{$requestController}@index");
Route::any('/networking',"{$requestController}@store");