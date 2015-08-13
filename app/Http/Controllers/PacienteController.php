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
        $registro = $this->auth->user()['registro'];

        $verify = $this->atendimento->findWhere(['registro' => $registro, 'posto' => $posto, 'atendimento' => $atendimento])->count();

        if(!$verify){
            return response()->json(array(
                'message' => 'Posto / Atendimento não encontrado',
            ), 404);
        }

        $exames = $this->exames->findWhere(['posto' => $posto, 'atendimento' => $atendimento])->toArray();

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }
}
