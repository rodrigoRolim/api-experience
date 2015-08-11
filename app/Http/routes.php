<?php

Route::controllers([
    'auth' => 'AuthController',
]);

Route::get('/', function () {
    return redirect('/auth');
});

Route::group(['prefix' => '/', 'middleware' => ['auth','ehPaciente']], function () {
    Route::controllers([
        'paciente' => 'PacienteController',
    ]);
});