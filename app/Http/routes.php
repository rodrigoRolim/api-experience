<?php

Route::controllers([
    'auth' => 'Auth\AuthController',
]);

Route::get('/', 'HomeController@index');

Route::get('/home', function () {
   return view('login.index');
});
