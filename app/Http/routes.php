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

Route::group(['prefix' => '/', 'middleware' => ['auth','ehMedico']], function () {
    Route::get('/medico', function () {
        return view('medico.index');
    });
});