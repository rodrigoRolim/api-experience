<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;

use Request;

class PostoController extends Controller {

    protected $auth;    
    protected $convenio;
    protected $posto;
    protected $exames;

      public function __construct(
        Guard $auth,        
        ConvenioRepository $convenio,
        PostoRepository $posto,
        ExamesRepository $exames
    )
    {
        $this->auth = $auth;        
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
    }


    public function getIndex()
    {   
        $idPosto = $this->auth->user()['posto'];

        $postoRealizante = $this->posto->getPostosRealizantes();
        $convenios = $this->posto->getConveniosPosto($idPosto);

        return view('posto.index')->with(
            array(
                'postoRealizante'=>$postoRealizante,
                'convenios'=>$convenios,   
            )
        );
    }

    public function postFilteratendimentos(){
        $requestData = Request::all();
        $idPosto = $this->auth->user()['posto']; 

        if($requestData['dataInicio'] != null && $requestData['dataFim'] != null){
            $result = $this->posto->getAtendimentos(
                $idPosto,
                $requestData['dataInicio'],
                $requestData['dataFim'],              
                $requestData['convenio'],
                $requestData['situacao'],
                $requestData['postoRealizante'],
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

        $idPosto = $this->auth->user()['posto'];

        $atendimentos = $this->posto->getAtendimentosPacienteByPosto($registro,$idPosto);

        if(!sizeof($atendimentos)){
            return response()->json(array(
                'message' => 'Atendimento não encontrado',
            ), 404);
        }

        $postoRealizante = $this->posto->getPostosRealizantes();

        return view('posto.paciente',compact('atendimentos','postoRealizante'));
    }

    public function getExamesatendimento($posto,$atendimento,$postoRealizante = null){

        $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($this->auth->user()['posto'],$atendimento);

        if(!$ehAtendimentoPosto){
            return response()->json(array(
                'message' => 'Posto / Atendimento não encontrado',
            ), 404);
        }

        $exames = $this->exames->getExames($posto, $atendimento,$postoRealizante);
     
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }
}