<?php

/**
* Classe reponsável pelo controle de rodas da aplicação
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
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
Route::get("auth", "AuthController@getIndex");
Route::get("paciente", "PacienteController@getIndex")->middleware(['auth','ehPaciente','revalidate']);
Route::get("paciente/examesatendimento/{posto}/{atendimento}", "PacienteController@getExamesatendimento")->middleware(['auth','ehPaciente','revalidate']);
Route::get("paciente/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "PacienteController@getDetalheatendimentoexamecorrel")->middleware(['auth','ehPaciente','revalidate']);
Route::post("paciente/exportarpdf", "PacienteController@postExportarpdf")->middleware(['auth','ehPaciente','revalidate']);
Route::get("paciente/perfil", "PacienteController@getPerfil")->middleware(['auth','ehPaciente','revalidate']);
Route::post("paciente/alterarsenha", "PacienteController@postAlterarsenha")->middleware(['auth','ehPaciente','revalidate']);
Route::post("auth/login", "AuthController@postLogin");
Route::post("auth/autoatendimento", "AuthController@postAutoatendimento");
Route::get("auth/autoatendimento", "AuthController@getAutoatendimento");
Route::get("auth/logout", "AuthController@getLogout");
Route::get("posto", "PostoController@getIndex")->middleware(['ehPosto','revalidate']);
Route::post("posto/selectpostorealizante", "PostoController@postSelectpostorealizante")->middleware(['ehPosto','revalidate']);
Route::post("posto/selectacomodacao", "PostoController@postSelectacomodacao")->middleware(['ehPosto','revalidate']);
Route::post("posto/localizaatendimento", "PostoController@postLocalizaatendimento")->middleware(['ehPosto','revalidate']);
Route::post("posto/filteratendimentos", "PostoController@postFilteratendimentos")->middleware(['ehPosto','revalidate']);
Route::get("posto/paciente/{registro}/{parceiro}/{atendimento}", "PostoController@getPaciente")->middleware(['ehPosto','revalidate']);
Route::get("posto/examesatendimento/{parceiro}/{atendimento}/{parceiroRealizante}", "PostoController@getExamesatendimento")->middleware(['ehPosto','revalidate']);
Route::get("posto/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "PostoController@getDetalheatendimentoexamecorrel")->middleware(['ehPosto','revalidate']);
Route::post("posto/pdf", "PostoController@postExportarpdf")->middleware(['ehPosto','revalidate']);
Route::get("posto/logs", "PostoController@getLogs")->middleware(['ehPosto','revalidate']);
Route::get("laudo", "LaudoController@getIndex");
Route::get("manuais", "ManuaisController@getIndex");
Route::get("manuais/procedimentos/{descricao}", "ManuaisController@getProcedimentos");
Route::get("manuais/preparo/{mnemonico}", "ManuaisController@getPreparo");
Route::post("medico/filterclientes", "MedicoController@postFilterclientes")->middleware(['auth','ehMedico','revalidate']);
Route::get("medico/paciente/{registro}", "MedicoController@getPaciente")->middleware(['auth','ehMedico','revalidate']);
Route::get("medico/examesatendimento/{posto}/{atendimento}", "MedicoController@getExamesatendimento")->middleware(['auth','ehMedico','revalidate']);
Route::post("medico/selectconvenios", "MedicoController@postSelectconvenios")->middleware(['auth','ehMedico','revalidate']);
Route::post("medico/selectpostoscadastro", "MedicoController@postSelectpostoscadastro")->middleware(['auth','ehMedico','revalidate']);
Route::get("medico/detalheatendimentoexamecorrel/{posto}/{atendimento}/{correl}")->middleware(['auth','ehMedico','revalidate']);
Route::post("medico/exportarpdf", "MedicoController@postExportarpdf")->middleware(['auth','ehMedico','revalidate']);
Route::get("medico/perfil", "MedicoController@getPerfil")->middleware(['auth','ehMedico','revalidate']);
Route::post("medico/alterarsenha", "MedicoController@postAlterarsenha")->middleware(['auth','ehMedico','revalidate']);
Route::post("medico/localizapaciente", "MedicoController@postLocalizapaciente")->middleware(['auth','ehMedico','revalidate']);
Route::get("parceiro", "ParceiroController@getIndex")->middleware(['ehParceiro','revalidate']);
Route::post("parceiro/localizaatendimento", "ParceiroController@postLocalizaatendimento")->middleware(['ehParceiro','revalidate']);
Route::post("parceiro/selectacomodacao", "ParceiroController@postSelectacomodacao")->middleware(['ehParceiro','revalidate']);
Route::post("parceiro/selectpostorealizante", "ParceiroController@postSelectpostorealizante")->middleware(['ehParceiro','revalidate']);
Route::post("parceiro/filteratendimentos", "ParceiroController@postFilteratendimentos")->middleware(['ehParceiro','revalidate']);
Route::get("parceiro/paciente/{registro}/{parceiro}/{atendimento}", "ParceiroController@getPaciente")->middleware(['ehParceiro','revalidate']);
Route::get("parceiro/examesatendimento/{parceiro}/{atendimento}/{parceiroRealizante}", "ParceiroController@getExamesatendimento")->middleware(['ehParceiro','revalidate']);
Route::get("parceiro/detalheatendimentoexamecorrel/{parceiro}/{atendimento}/{correl}", "ParceiroController@getDetalheatendimentoexamecorrel")->middleware(['ehParceiro','revalidate']);
Route::post("parceiro/exportarpdf", "ParceiroController@postExportarpdf")->middleware(['ehParceiro','revalidate']);
// /medico/localizapaciente
// /medico/paciente/'+pacientes.key+'
// url()}}/'+tipoAcesso+'/alterarsenha
// {url('/')}}/manuais/procedimentos/"+data
// {{url('/')}}/manuais/preparo/"+mnemonico
// {url()}}/auth/logout"
// url("/")}}/medico/filterclientes
// {url()}}/paciente/alterarsenha'
// url()}}/medico/alterarsenha
// url('/')}}/medico"
// url('/')}}/medico/perfil"
// {{url('/')}}/auth/logout"
// /"+tipoAcesso+"/examesatendimento/"+posto+"/"+atendimento
// exame.posto +'/'+ exame.atendimento)
// "/"+tipoAcesso+"/detalheatendimentoexamecorrel/"+posto+"/"+atendimento+"/"+corel
// /impressao
// url+'/'+tipoAcesso+'/exportarpdf'  