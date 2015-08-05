<?php

Route::controllers([
    'auth' => 'AuthController',
]);

Route::get('/', function () {
    return redirect('/auth');
});

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index');
});

Route::get('/paciente', function () {
    return view('paciente.index');
});

