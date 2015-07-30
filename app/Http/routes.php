<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

Route::get('/', 'HomeController@index');

//Route::get('/', function () {
//    return view('welcome');
//});
