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
    Route::controllers([
        'medico' => 'MedicoController',
    ]);
});

Route::group(['prefix' => '/','middleware' => ['auth','ehPosto']], function () {    
    Route::controllers([
        'posto' => 'PostoController',
    ]);
});

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/impressao', function () {
        return view('layouts.exportacaoPdf');
    });
});