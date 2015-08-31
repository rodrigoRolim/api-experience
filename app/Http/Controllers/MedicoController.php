<?php namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;

use Request;

class MedicoController extends Controller {
    protected $auth;
    protected $medico;
    protected $convenio;
    protected $posto;
    protected $exames;

    public function __construct(
        Guard $auth,
        MedicoRepository $medico,
        ConvenioRepository $convenio,
        PostoRepository $posto,
        ExamesRepository $exames
    )
    {
        $this->auth = $auth;
        $this->medico = $medico;
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
    }

    public function getIndex()
    {
        $idMedico = $this->auth->user()['id_medico'];

        $postos = $this->medico->getPostoAtendimento($idMedico);
        $convenios = $this->medico->getConvenioAtendimento($idMedico);

        return view('medico.index')->with(
            array(
                'postos'=>$postos,
                'convenios'=>$convenios,
            )
        );
    }

    public function postFilterclientes(){
        $requestData = Request::all();
        $idMedico = $this->auth->user()['id_medico']; 

        if($requestData['dataInicio'] != null && $requestData['dataFim'] != null){
            $result = $this->medico->getClientes(
                $idMedico,
                $requestData['dataInicio'],
                $requestData['dataFim'],
                $requestData['posto'],
                $requestData['convenio'],
                $requestData['situacao']
            );

            return response()->json(array(
                'message' => 'Recebido com sucesso.',
                'data' => $result,
            ), 200);
        }
    }

    public function getPaciente($registro){
        $registro = base64_decode($registro);
        $idMedico = $this->auth->user()['id_medico'];

        $atendimentos = $this->medico->getAtendimentosPacienteByMedico($registro,$idMedico);

        return view('medico.paciente',compact('atendimentos'));
    }

    public function getExamesatendimento($posto,$atendimento){
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        if(!$ehAtendimentoMedico){
            return response()->json(array(
                'message' => 'Posto / Atendimento não encontrado',
            ), 404);
        }

        $exames = $this->exames->getExames($posto, $atendimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    public function getTeste(){
        $result = $this->medico->getClientes(302,'12/03/2015','19/04/2015',null,null,null);
        dd($result);
    }
}