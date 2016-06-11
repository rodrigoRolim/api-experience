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
        if(gethostname() == config('system.HOSTNAME_AUTOATENDIMENTO')){
            return redirect('/auth/autoatendimento');
        }

        return view('auth.index');
     }

    /**
    * Show the application login autoatendimento.
    *
    * @return \Illuminate\Http\Response
    */
    public function getAutoatendimento($keyboard = 0)
    {
        if(env('APP_ACESSO_AUTOATENDIMENTO')){
            return view('auth.autoatendimento',compact(['keyboard']));
        }

        \App::abort(404);
    }

    /**
    * @param Request $request
    * @return $this|\Illuminate\Http\RedirectResponse
    */
    public function postAutoatendimento(Request $request)
    {
        //Pega o Id que ta em base64 e convert em json
        $id = base64_decode($request->input('id'),true);
        //Passa o json para Array
        $acesso = json_decode($id,true);

        //Cria array para verificação de autenticação com o banco de dados
        $credentials = [
            'tipoAcesso' => 'AUTO',
            'tipoLoginPaciente' => 'ID',
            'posto' => $acesso['posto'],
            'atendimento' => $acesso['atendimento'],
            'password' => $acesso['senha'],
        ];

        /*
        * Enviada para o controller App\Auth\CustomUserProvider a array $credentials para validação do acesso
        */
        if ($this->auth->attempt($credentials, false)) {
            return redirect()->intended('/auth/home');
        }

        //Caso o usuario/senha não forem satisfatorio, retorna o formulario de login com a mensagem de acesso negado
        // return redirect('/auth/autoatendimento')->withInput()->withErrors(config('system.messages.login.usuarioQrInvalido'));
        return redirect()->back()->withInput()->withErrors(config('system.messages.login.usuarioQrInvalido'));
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
        // return redirect('/auth')->withInput()->withErrors(config('system.messages.login.usuarioSenhaInvalidos'));
        return redirect()->back()->withInput()->withErrors(config('system.messages.login.usuarioSenhaInvalidos'));
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
        unset($_COOKIE['acomodacao']);
        unset($_COOKIE['situacao']);
        unset($_COOKIE['postoRealizante']);
        unset($_COOKIE['cabecalho']);

        setcookie('dataInicio', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('dataFim', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('acomodacao', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('situacao', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('postoRealizante', '', time() - 3600, '/'); // empty value and old timestamp
        setcookie('cabecalho', '', time() - 3600, '/'); // empty value and old timestamp

        //Destroi toda a sessão do usuário logado
        Session::flush();
        Redirect::back();
        //Retorna para a view de login


        return Redirect::to('/');
    }

    public function getTeste(){
        $rtf = "{\rtf1\ansi\ansicpg1252\deff0{\fonttbl{\f0\fnil\fcharset0 Verdana;}}
                {\colortbl ;\red0\green0\blue0;}
                \viewkind4\uc1\pard\sb100\sa100\lang1046\b\f0\fs18 1)\'daLTIMA ATUALIZA\'c7\'c3O:\b0  18/10/2006
                \par 2)\fs24  \b\fs18 PALAVRAS CHAVES\b0 ;GLICOSE\b 
                \par \b0 3) \b\'c1REA:\b0 BIOQUIMICA I\fs24 
                \par \pard\sb100\sa100\qj\fs18 4)\fs24  \b\fs18 CONDI\'c7\'d5ES\b0\fs24  :\fs18 soro ou plasma (fluoreto).
                \par \b TEMPO DE JEJUM\b0\fs24  \fs18 
                \par JO 8h ou C.O.M. \fs24 
                \par \fs18 5)\b POSTO REALIZANTE\b0 
                \par MATRIZ E POSTOS DE COLETA
                \par 6)\b INSTRU\'c7\'d5ES
                \par 
                \par \pard\sb100\sa100\b0\fs24  7\fs18 )\b COMENT\'c1RIOS\b0\fs24  \fs18 
                \par \pard\sb100\sa100\qj A presenca de um dos criterios abaixo (retirados da American Diabetes Association) e sua confirmacao num dia subsequente indica o diagnostico de diabetes melito: 
                \par 1. Sintomas de diabetes melito com glicemia independente do jejum maior ou igual a 200 mg/dL). 
                \par 2. Glicemia de jejum maior ou igual a 126 mg/dL. 
                \par 3. Glicemia maior ou igual a 200 mg/dL, durante teste de tolerancia a glicose, 2 horas apos 75g de glicose anidra dissolvida em agua. 
                \par OBS.: Pacientes com glicemia de jejum entre 100 e 125 mg/dL sao classificados como portadores de glicemia de jejum alterada. Pacientes com glicemia maior ou igual a 140 mg/ dL, 2 horas apos 75g de glicose anidra dissolvida em agua,sao considerados intolerantes a glicose. 
                \par Leucocitose, hemolise e glicolise em amostras submetidas ao calor podem determinar hipoglicemia espuria. \fs24 
                \par \b\fs18 8)PREVIS\'c3O DE ENTREGA\b0 
                \par \fs24 1 dia.
                \par \pard\cf1\b\fs22 
                \par 9) COBERTURA
                \par 
                \par \b0 PARTICULAR E TODOS OS CONV\'caNIOS\b 
                \par }";

        $reader = new \App\Services\RtfReader();
        $reader->Parse($rtf);
        //$reader->root->dump(); // to see what the reader read
        // dd($reader->root);

        $formatter = new \App\Services\RtfHtml();
        echo $formatter->Format($reader->root);

        exit;
        
        // $reader->root->dump();

   // * //$reader->root->dump(); // to see what the reader read



        // $html = $formatter->Format($render->root);

        // $formatter = new  \App\Services\RtfHtml();
        // echo $html;
        // exit;
    }
}