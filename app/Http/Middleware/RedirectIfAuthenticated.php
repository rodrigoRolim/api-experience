<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use Redirect;

class RedirectIfAuthenticated
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
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Redireciona para a rota espeficida de acordo com o tipo de acesso do usuario
        if ($this->auth->check())
        {
            $tipoAcesso = $this->auth->user()['tipoAcesso'];

            if ($tipoAcesso == 'PAC'){
                return Redirect::to('/paciente');
            }

            if ($tipoAcesso == 'MED'){
                return Redirect::to('/medico');
            }

            if ($tipoAcesso == 'POS'){
                return Redirect::to('/posto');
            }

            if ($tipoAcesso == 'PAR'){
                return Redirect::to('/parceiro');
            }

            if ($tipoAcesso == 'AUTO'){
                return Redirect::to('/paciente');
            }
        }

        return $next($request);
    }
}