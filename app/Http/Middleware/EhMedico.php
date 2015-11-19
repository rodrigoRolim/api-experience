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

class EhMedico
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
        $tipoAcesso = $this->auth->user()['tipoAcesso'];

        if ($tipoAcesso == 'MED'){
            return $next($request);
        }else{
            \App::abort(404);
        }
    }
}
