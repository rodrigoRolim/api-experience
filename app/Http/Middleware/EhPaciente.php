<?php

/**
 * Middleware responsavel pela liberaçao das rotas de acordo com o tipo de acesso
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class EhPaciente
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = $this->auth->user();

        switch (gettype($auth)) {
            //Quando vem da API
            case 'object':
                if ($auth->id['tipoAcesso'] == 'PAC'){
                    return $next($request);
                }else{
                    return response()->json(['error' => 'Não existe'], 404);
                }    
                break;
            
            //Quando vem da página inicial
            case 'array':
                if ($auth['tipoAcesso'] == 'PAC'){
                    return $next($request);
                }else{
                    \App::abort(404);
                }    

                break;
        }
    }
}
