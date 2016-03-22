<?php

/**
* Classe reponsável pelas operações de autenticação de usuários no sistema,
* ela atende os acessos do Paciente, Posto e Médico
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use BrowserDetect;

use Redirect;
use Session;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    protected $auth;

    /**
     * Create a new authentication controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard     $auth
    */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
     public function getIndex()
     {
        return view('auth.index');
     }


    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        /*
        * Analisa o valor enviados pelo formuario "tipoAcesso" para validar cada tipo com suas regras
        * Tipo de acesso pode ser do tipo 'PAC = Acesso do Paciente, MED = Acesso do Médico e POS = Acesso do Posto'
        */

        switch($request->input('tipoAcesso')){
            /*
            * Caso o usuario seja do tipo PAC é verificado o tipo de 
            * acesso através do valor do input tipoLoginPaciente 'ID = Acesso pelo cartão do atendimento, 
            * CPF = Acesso via cadastro unico criado no laboratorio, dessa forma ele 
            * consegue ver todo os atendimento já realizados no laboratorio.'
            */
            case 'PAC':
                if($request->input('tipoLoginPaciente') == 'ID'){
                    /*
                    * Verifica a quantidade de caracter estipulado no 
                    * confige para atendimento e posto para criação do limite maximo de validação
                    */
                    $qtdCaracter = config('system.qtdCaracterAtend')+config('system.qtdCaracterPosto')+1;

                    //Cria uma array de validação 
                    $validate = [
                        'atendimento' => 'required|max:'.$qtdCaracter.'',
                        'password' => 'required',
                    ];

                    $this->validate($request,$validate);

                    //Se validado separada o posto e atendimento enviado pelo formulario
                    $dadosAtend = explode('/',$request->input('atendimento'));

                    //Cria array para verificação de autenticação com o banco de dados
                    $credentials = [
                        'tipoAcesso' => 'PAC',
                        'tipoLoginPaciente' => $request->input('tipoLoginPaciente'),
                        'posto' => $dadosAtend[0],
                        'atendimento' => $dadosAtend[1],
                        'password' => $request->input('password'),
                    ];
                }
                /*
                * Caso o acesso seja do tipo CPF
                */
                if($request->input('tipoLoginPaciente') == 'CPF'){
                    $validate = [
                        'cpf' => 'required',
                        'nascimento' => 'required',
                        'password' => 'required',
                    ];

                    $this->validate($request,$validate);
                    
                    //Cria array para verificação de autenticação com o banco de dados
                    $credentials = [
                        'tipoAcesso' => 'PAC',
                        'tipoLoginPaciente' => $request->input('tipoLoginPaciente'),
                        'cpf' => $request->input('cpf'),
                        'nascimento' => $request->input('nascimento'),
                        'password' => $request->input('password'),
                    ];
                }

                break;
            //Acesso do medico
            case 'MED':
                //Cria uma array de validação 
                $validate = [
                    'tipoCr' => 'required',
                    'cr' => 'required',
                    'uf' => 'required|min:2|max:2',
                    'password' => 'required',
                ];

                $this->validate($request,$validate);

                //Cria array para verificação de autenticação com o banco de dados
                $credentials = [
                    'tipoAcesso' => 'MED',
                    'tipoCr' => $request->input('tipoCr'),
                    'cr'  => $request->input('cr'),
                    'uf'  => $request->input('uf'),
                    'password' => $request->input('password'),
                ];

                break;
            //Acesso ao posto
            case 'POS':
                //Verifica no arquivo de configuração a quantidade de caracter do posto
                $qtdCaracter = config('system.qtdCaracterPosto');
                
                //Cria array de validação
                $validate = [
                    'posto' => 'required|max:'.$qtdCaracter.'',                  
                    'password' => 'required',
                ]; 
                               
                $this->validate($request,$validate);
                
                //Cria array para verificação de autenticação com o banco de dados
                $credentials = [
                    'tipoAcesso' => 'POS',  
                    'posto' => $request->input('posto'),                  
                    'password' => $request->input('password'),
                ];
                break;
        }

        /*
        * Enviada para o controller App\Auth\CustomUserProvider a array $credentials para validação do acesso
        */
        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return redirect()->intended('/auth/home');
        }

        //Caso o usuario/senha não forem satisfatorio, retorna o formulario de login com a mensagem de acesso negado
        return redirect('/auth')->withInput()->withErrors(config('system.messages.login.usuarioSenhaInvalidos'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        //Limpa todos os cookie do fitro do médico
        unset($_COOKIE['dataInicio']);
        unset($_COOKIE['dataFim']);
        unset($_COOKIE['convenio']);
        unset($_COOKIE['situacao']);
        unset($_COOKIE['postoRealizante']);

        setcookie('dataInicio', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('dataFim', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('convenio', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('situacao', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('postoRealizante', '', time() - 3600, '/'); // empty value and old timestamp

        //Destroi toda a sessão do usuário logado
        Session::flush();
        Redirect::back();
        //Retorna para a view de login
        return Redirect::to('/');
    }
}