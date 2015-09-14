<?php

Route::controllers([
    'auth' => 'AuthController',
]);

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/home', function () {
     Route::controllers([
        'home' => 'HomeController',
    ]);
});

Route::group(['prefix' => '/', 'middleware' => ['auth','ehPaciente']], function () {
    Route::controllers([
        'paciente' => 'PacienteController',
    ]);
});

Route::group(['prefix' => '/', 'middleware' => ['auth','ehMedico']], function () {
    Route::controllers([
        'medico' => 'MedicoController',
    ]);
});