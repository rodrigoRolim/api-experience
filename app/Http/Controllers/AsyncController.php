<?php

/**
 * Classe de Controle do Posto
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Repositories\AmostraRepository;
use Carbon\Carbon;

use Illuminate\Contracts\Auth\Guard;

use Request;
use Auth;

class AsyncController extends Controller {

    protected $auth;    
    protected $amostra;

    /**
     * Referenciada os repositorio/model utilizados no controlelr
     *
     * @param Guard $auth
     * @param AmostraRepository $amostra
     */
    public function __construct(
        Guard $auth,        
        AmostraRepository $amostra
    )
    {
        $this->auth = $auth;        
        $this->amostra = $amostra;
    }

    /**
    * Carrega amostras de cada procedimento de um atendimento.
    *
    */
    public function postSelectamostras(){
        $idPosto = $this->auth->user()['posto'];
        $amostras = $this->amostras->getAmostras($idPosto,Request::get('atendimento'),Request::get('correl'));
    
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $amostras,
        ), 200);
    }

}