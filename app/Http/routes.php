<?php

/**
* Classe reponsável pelo controle de rodas da aplicação
*
* @author rodrigo rola
* @version 1.0
*/
Use Illuminate\Http\Request;
// Route::controllers([
//     'auth' => 'AuthController',
//     'manuais' => 'ManuaisController',
// ]);

// Route::get('/', function () {
//     return redirect('/auth');
// });

// Route::get('/sobre', function () {
//     return view('layouts.sobre');
// });

// Route::group(['prefix' => '/','middleware' => ['auth','ehPaciente','revalidate']], function () {
//     Route::controllers([
//         'paciente' => 'PacienteController',
//     ]);
// });

// Route::group(['prefix' => '/', 'middleware' => ['auth','ehMedico','revalidate']], function () {
//     Route::controllers([
//         'medico' => 'MedicoController',
//     ]);
// });

// Route::group(['prefix' => '/','middleware' => ['ehPosto','revalidate']], function () {    
//     Route::controllers([
//         'posto' => 'PostoController',
//     ]);

//     Route::post('amostras','AsyncController@postSelectamostras');
// });

// Route::group(['prefix' => '/','middleware' => ['ehParceiro','revalidate']], function () {    
//     Route::controllers([
//         'parceiro' => 'ParceiroController',
//     ]);

//     Route::post('amostras','AsyncController@postSelectamostras');
// });

// Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
//     Route::get('/impressao', function () {
//         return view('layouts.exportacaoPdf');
//     });
// });

/*Route::group(['prefix' => '/api/v1'], function()
{
    Route::post('authenticate', 'ApiController@authenticate');

    Route::group(['prefix' => '/paciente','middleware' => ['jwt.auth','ehPaciente','revalidate']], function () {
        Route::get('/atendimentos', 'ApiPacienteController@getAtendimentos');    
        Route::get('/examesatendimento/{posto}/{atendimento}', 'ApiPacienteController@getExamesatendimento');    
    });
});*/

/* @return a view */
Route::get('/', function () {
    return redirect('/auth');
});
Route::get('/sobre', function () {
    return view('layouts.sobre');
});
Route::group(['prefix' => '/paciente', /* 'middleware' => ['auth','ehPaciente','revalidate'] */], function () {
/**/Route::get("", "PacienteController@getIndex");
/**/Route::get("/examesatendimento/{posto}/{atendimento}", "PacienteController@getExamesatendimento");
/**/Route::get("/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "PacienteController@getDetalheatendimentoexamecorrel");
/**/Route::get("/perfil", "PacienteController@getPerfil");
/**/Route::post("/alterarsenha", "PacienteController@postAlterarsenha");
    Route::post("/exportarpdf", "PacienteController@postExportarpdf");
});
Route::group(['prefix' => '/posto', /* 'middleware' => ['ehPosto','revalidate'] */], function () {
/**/Route::get("", "PostoController@getIndex"); 
/**/Route::post("/selectpostorealizante", "PostoController@postSelectpostorealizante");
/**/Route::post("/selectacomodacao", "PostoController@postSelectacomodacao");
/**/Route::post("/localizaatendimento", "PostoController@postLocalizaatendimento");
/**/Route::post("/filteratendimentos", "PostoController@postFilteratendimentos");
/**/Route::get("/paciente/{registro}/{parceiro}/{atendimento}", "PostoController@getPaciente");
/**/Route::get("/examesatendimento/{parceiro}/{atendimento}/{parceiroRealizante?}", "PostoController@getExamesatendimento");
/**/Route::get("/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "PostoController@getDetalheatendimentoexamecorrel");
/**/Route::post("/exportarpdf", "PostoController@postExportarpdf");
/**/Route::get("/logs", "PostoController@getLogs");
});
Route::group(['prefix' => '/auth'], function () {
/**/Route::get("", "AuthController@getIndex");
/**/Route::post("/login", "AuthController@postLogin");
/**/Route::post("/autoatendimento", "AuthController@postAutoatendimento");
/**/Route::get("/autoatendimento", "AuthController@getAutoatendimento");
/**/Route::get("/logout", "AuthController@getLogout");
});
Route::group(['prefix' => '/laudo'], function () {
    Route::get("", "LaudoController@getIndex");
});
Route::group(['prefix' => '/manuais'], function () {
/**/Route::get("", "ManuaisController@getIndex");
/**/Route::get("/procedimentos/{descricao}", "ManuaisController@getProcedimentos");
/**/Route::get("/preparo/{mnemonico}", "ManuaisController@getPreparo");
});
Route::group(['prefix' => '/medico', /* 'middleware' => ['auth','ehMedico','revalidate'] */], function () {
/**/Route::get("", "MedicoController@getIndex");
/*a view não existe*/  Route::post("/localizapaciente", "MedicoController@postLocalizapaciente");
/**/Route::post("/filterclientes", "MedicoController@postFilterclientes");
/**/Route::get("/paciente/{registro}", "MedicoController@getPaciente");
/**/Route::get("/examesatendimento/{posto}/{atendimento}", "MedicoController@getExamesatendimento");
/**/Route::post("/selectconvenios", "MedicoController@postSelectconvenios");
/**/Route::post("/selectpostoscadastro", "MedicoController@postSelectpostoscadastro");
/**/Route::get("/detalheatendimentoexamecorrel/{posto}/{atendimento}/{correl}", "MedicoController@getDetalheatendimentoexamecorrel");
/**/Route::post("/exportarpdf", "MedicoController@postExportarpdf");
/**/Route::get("/perfil", "MedicoController@getPerfil");
/**/Route::post("/alterarsenha", "MedicoController@postAlterarsenha");
});
Route::group(['prefix' => '/parceiro', /* 'middleware' => ['ehParceiro','revalidate'] */], function () {
/**/Route::get("", "ParceiroController@getIndex");
    Route::post("/localizaatendimento", "ParceiroController@postLocalizaatendimento");
/**/Route::post("/selectacomodacao", "ParceiroController@postSelectacomodacao");
/**/Route::post("/selectpostorealizante", "ParceiroController@postSelectpostorealizante");
/**/Route::post("/filteratendimentos", "ParceiroController@postFilteratendimentos");
/**/Route::get("/paciente/{registro}/{parceiro}/{atendimento}", "ParceiroController@getPaciente");
/**/Route::get("/examesatendimento/{parceiro}/{atendimento}/{parceiroRealizante?}", "ParceiroController@getExamesatendimento");
/**/Route::get("/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "ParceiroController@getDetalheatendimentoexamecorrel");
/**/Route::post("/exportarpdf", "ParceiroController@postExportarpdf");
});
Route::group(['prefix' => '/amostras', /* 'middleware' => ['ehParceiro','revalidate'] */], function () {
/**/Route::post("", "AsyncController@postSelectamostras");
});

Route::get("impressao",function () {
    return view('layouts.exportacaoPdf');
})->middleware(['auth']);
 