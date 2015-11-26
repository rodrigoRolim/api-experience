<?php

/**
* Classe reponsável pelo controle de rodas da aplicação
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

Route::controllers([
    'auth' => 'AuthController',
]);

Route::get('/', function () {
    return redirect('/auth');
});

Route::group(['prefix' => '/','middleware' => ['auth','ehPaciente','revalidate']], function () {
    Route::controllers([
        'paciente' => 'PacienteController',
    ]);
});

Route::group(['prefix' => '/', 'middleware' => ['auth','ehMedico','revalidate']], function () {
    Route::controllers([
        'medico' => 'MedicoController',
    ]);
});

Route::group(['prefix' => '/','middleware' => ['auth','ehPosto','revalidate']], function () {    
    Route::controllers([
        'posto' => 'PostoController',
    ]);
});

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/impressao', function () {
        return view('layouts.exportacaoPdf');
    });
});
