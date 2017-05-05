<?php

/**
 * Classe de Controle do Paciente
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Repositories\AtendimentoRepository;
use App\Repositories\ExamesRepository;
use Experience\Util\Formatar;
use Request;
use Auth;

class ApiPacienteController extends Controller {
    protected $auth;
    protected $usuario;
    protected $atendimento;
    protected $exames;

    /**
     * Referencio os Repositorios/Controller a serem utilizados
     *
     * @param Guard $auth
     * @param AtendimentoRepository $atendimento
     * @param ExamesRepository $exames
     * @param DataSnapService $dataSnap
     * @param ClienteAcessoRepository $clienteAcesso
     */
    public function __construct(Guard $auth, AtendimentoRepository $atendimento, ExamesRepository $exame)
    {
        $this->auth = $auth;
        $this->usuario = $auth->user()->id;
        $this->atendimento = $atendimento;
        $this->exame = $exame;
    }


    public function getAtendimentos()
    {
        $atendimentos = $this->atendimento->atendimentos($this->usuario);
        return response()->json($atendimentos, 200);
    }

    public function getExamesatendimento($posto, $atendimento){
        $exames = [];

        if($this->usuario['tipoLoginPaciente'] == 'CPF'){
            //Verifico se o atendmiento enviado é do paciente, enviado os dados de acesso, posto e atendmiento
            $ehCliente = $this->atendimento->ehCliente($this->usuario, $posto, $atendimento);

            if(!$ehCliente){
                return response()->json(['error', 'Esses exames não existem'], 404);
            }

            $exames = $this->exame->getExames($posto, $atendimento);
        }

        if($this->usuario['tipoLoginPaciente'] == 'ID'){
            $exames = $this->exame->getExames($this->usuario['posto'], $this->usuario['atendimento']);
        }
        
        return response()->json($exames, 200);
    }
}