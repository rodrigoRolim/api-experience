<?php

/**
 * Classe de Manuais de Exames
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Repositories\ManuaisRepository;
use Request;

class ManuaisController extends Controller{

	    protected $procedimentos;    

    /**
     * Referenciada os repositorio/model utilizados no controlelr
     *
     * @param Guard $auth
     * @param ConvenioRepository $convenio
     * @param PostoRepository $posto
     * @param ExamesRepository $exames
     * @param AtendimentoRepository $atendimento
     * @param DataSnapService $dataSnap
     */
    public function __construct(
        ManuaisRepository $procedimentos        
    )
    {
        $this->procedimentos = $procedimentos;        
    }

	public function getIndex(){
		return view('manuais.index');
	}

	public function getConvertrtf(){

	}

	public function postProcedimentos(){

		$request = Request::all();
		$input = $request['input'];
		$procedimentos = $this->procedimentos->getProcedimentos($input);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $procedimentos,
        ), 200);

	}

}