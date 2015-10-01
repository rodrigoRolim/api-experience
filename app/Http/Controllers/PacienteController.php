<?php namespace App\Http\Controllers;

use App\Repositories\AtendimentoRepository;
use App\Repositories\ExamesRepository;
use Illuminate\Contracts\Auth\Guard;

class PacienteController extends Controller {
    protected $auth;
    protected $atendimento;
    protected $exames;

    public function __construct(Guard $auth, AtendimentoRepository $atendimento, ExamesRepository $exames)
    {
        $this->auth = $auth;
        $this->atendimento = $atendimento;
        $this->exames = $exames;
    }

    public function getIndex()
    {
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];
        $atendimentos = $this->atendimento->atendimentos($this->auth->user());

        return view('paciente.index',compact('atendimentos','tipoLoginPaciente'));
    }

    public function getExamesatendimento($posto,$atendimento){
        $ehCliente = $this->atendimento->ehCliente($this->auth,$posto,$atendimento);

        if(!$ehCliente){
            \App::abort(404);
        }

        $exames = $this->exames->getExames($posto, $atendimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){        

        $saldoDevedor = $this->atendimento->getSaldoDevedor($posto,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendências'
            ), 203);
        }

        $exames = $this->exames->getDetalheAtendimentoExameCorrel($posto, $atendimento,$correl);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_decode($exames),
        ), 200);
    }
}
