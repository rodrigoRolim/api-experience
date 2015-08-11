<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
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
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        switch($request->input('tipoAcesso')){
            case 'PAC':
                if($request->input('tipoLoginPaciente') == 'ID'){
                    $qtdCaracter = config('system.qtdCaracterAtend')+config('system.qtdCaracterPosto')+1;

                    $validate = [
                        'atendimento' => 'required|max:'.$qtdCaracter.'',
                        'password' => 'required',
                    ];

                    $this->validate($request,$validate);

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
            return redirect()->intended('/auth/home');
        }

        return redirect('/auth')->withErrors(config('system.messages.login.usuarioSenhaInvalidos'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect('/');
    }
}
