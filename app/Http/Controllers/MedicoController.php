<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;

use Request;

class MedicoController extends Controller {
    protected $auth;
    protected $medico;
    protected $convenio;
    protected $posto;

    public function __construct(
        Guard $auth,
        MedicoRepository $medico,
        ConvenioRepository $convenio,
        PostoRepository $posto
    )
    {
        $this->auth = $auth;
        $this->medico = $medico;
        $this->convenio = $convenio;
        $this->posto = $posto;
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

    public function getTeste(){
        $result = $this->medico->getClientes(302,'12/03/2015','19/04/2015',null,null,null);

        dd($result);
    }
}