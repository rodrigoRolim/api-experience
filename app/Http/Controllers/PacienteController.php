<?php namespace App\Http\Controllers;

use App\Repositories\AtendimentoRepository;
use Illuminate\Contracts\Auth\Guard;

class PacienteController extends Controller {
    protected $auth;
    protected $atendimento;

    public function __construct(Guard $auth, AtendimentoRepository $atendimento)
    {
        $this->auth = $auth;
        $this->atendimento = $atendimento;
    }

    public function getIndex()
    {
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];
        $atendimentos = $this->atendimento->atendimentos($this->auth->user());

        return view('paciente.index',compact('atendimentos','tipoLoginPaciente'));
    }
}
