<?php

/**
* Classe reponsável pelo controle de rodas da aplicação
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

Route::controllers([
    'auth' => 'AuthController',
    'manuais' => 'ManuaisController',
]);

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/sobre', function () {
    return view('layouts.sobre');
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

Route::group(['prefix' => '/','middleware' => ['ehPosto','revalidate']], function () {    
    Route::controllers([
        'posto' => 'PostoController',
    ]);

    Route::post('amostras','AsyncController@postSelectamostras');
});

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/impressao', function () {
        return view('layouts.exportacaoPdf');
    });
});

Route::group(['prefix' => '/api/v1'], function()
{
    Route::post('authenticate', 'ApiController@authenticate');

    Route::group(['prefix' => '/paciente','middleware' => ['jwt.auth','ehPaciente','revalidate']], function () {
        Route::get('/atendimentos', 'ApiPacienteController@getAtendimentos');    
        Route::get('/examesatendimento/{posto}/{atendimento}', 'ApiPacienteController@getExamesatendimento');    
    });
    
    //Route::get('teste', 'ApiController@getTeste');



    //Route::get('/atendimento/detalhe/{posto}/{atendimento}', 'ApiController@detalheatend');
});