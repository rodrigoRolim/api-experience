<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;
//use Vinkla\Hashids\Facades\Hashids;

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
        $registro = base64_decode(strtr($registro, '-_', '+/'));
        $registro = (int) trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, config('system.key'),$registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));

        $idMedico = $this->auth->user()['id_medico'];

        $atendimentos = $this->medico->getAtendimentosPacienteByMedico($registro,$idMedico);

        if(!sizeof($atendimentos)){
            \App::abort(404);
        }

        return view('medico.paciente',compact('atendimentos'));
    }

    public function getExamesatendimento($posto,$atendimento){

        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        if(!$ehAtendimentoMedico){
            \App::abort(404);
        }

        $exames = $this->exames->getExames($posto, $atendimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }
}