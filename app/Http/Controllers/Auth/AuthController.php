<?php

namespace App\Http\Controllers\Auth;


use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

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
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {
        switch($request->input('tipoAcesso')){
            case 'PAC':
                if($request->input('tipoLoginPaciente') == 'ID'){
                    $validate = [
                        'posto' => 'required|max:'.config('system.qtdCaracterPosto').'|integer',
                        'atendimento' => 'required|max:'.config('system.qtdCaracterAtend').'|integer',
                        'password' => 'required',
                    ];

                    $dadosAtend = explode('/',$request->input('atendimento'));

                    $credentials = [
                        'tipoAcesso' => 'PAC',
                        'tipoLoginPaciente' => $request->input('tipoLoginPaciente'),
                        'posto' => $dadosAtend[0],
                        'atendimento' => $dadosAtend[1],
                        'password' => $request->input('password'),
                    ];
                }

                break;
        }

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            dd($this->auth->user());
            //return redirect()->intended('/admin');
        }

        return redirect('/auth/login')
            //->withInput($request->only('lgn_usuario', 'remember'))
            ->withErrors([
                'Usuário e/ou senha inválidos.',
            ]);



//        switch ($request->input('tipoAcesso')) {
//            case 'PACIENTE':
//                if($request->input('tipo') == 'ID'){
//                    $this->validate($request, [
//                        'posto' => 'required|max:3|integer',
//                        'atendimento' => 'required|max:6|integer',
//                        'senhaId' => 'required',
//                    ]);
//
//                    $credentials = [
//                        'posto' => $request->input('posto'),
//                        'atendimento' => $request->input('atendimento'),
//                        'senhaId' => $request->input('senhaId'),
//                    ];
//                }
//
//                if($request->input('tipo') == 'CPF'){
//                    $this->validate($request, [
//                        'cpf' => 'required|cpf',
//                        'nascimento' => 'required|date',
//                        'senhaCpf' => 'required',
//                    ]);
//
//                    $credentials = [
//                        'cpf' => $request->input('cpf'),
//                        'nascimento' => $request->input('nascimento'),
//                        'senhaCpf' => $request->input('senhaCpf')
//                    ];
//                }
//
//                dd($this->auth);
////
//                if ($this->auth->attempt($credentials, $request->has('remember'))) {
//                    return redirect()->intended('/admin');
//                }
//
//                break;
//        }

//        $credentials = [
//            'posto' => $request->input('posto'),
//            'atendimento' => $request->input('atendimento'),
//            'senhaId' => $request->input('senhaId'),
//        ];
//
//        if ($this->auth->attempt($credentials, $request->has('remember'))) {
//            dd($this->auth->user());
//
////            return redirect()->intended('/admin');
//        }
//
//        return redirect('/auth/login')
//            ->withInput($request->only('lgn_usuario', 'remember'))
//            ->withErrors([
//                'Usuário e/ou senha inválidos.',
//            ]);
    }
}
