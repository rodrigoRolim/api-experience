<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\PostoRepository;
use App\Repositories\AtendimentoRepository;
use Illuminate\Contracts\Auth\Guard;

use Request;

class PostoController extends Controller {

    protected $auth;    
    protected $convenio;
    protected $posto;
    protected $atendimento;
    protected $exames;

      public function __construct(
        Guard $auth,        
        ConvenioRepository $convenio,
        PostoRepository $posto,
        ExamesRepository $exames,
        AtendimentoRepository $atendimento
    )
    {
        $this->auth = $auth;        
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
        $this->atendimento = $atendimento;
    }

    public function getIndex()
    {   
        $idPosto = $this->auth->user()['posto'];

        $postoRealizante = $this->posto->getPostosRealizantes();
        $convenios = $this->posto->getConveniosPosto($idPosto);

        return view('posto.index')->with(
            array(
                'postoRealizante' => $postoRealizante,
                'convenios' => $convenios,   
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
                $requestData['postoRealizante']
            );

            return response()->json(array(
                'message' => 'Recebido com sucesso.',
                'data' => $result,
            ), 200);
        }
    }

    public function postGetdescricao(){
        $requestData = Request::all();
        $idPosto = $this->auth->user()['posto']; 

        $result = $this->posto->getGetDescricaoExame(
            $idPosto,
            $requestData['atendimento'],
            $requestData['correlativo']  
        );

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $result,
        ), 200);
        
    }

    public function getPaciente($registro,$idAtendimento){
        $registro = base64_decode(strtr($registro, '-_', '+/'));
        $registro = (int) trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, config('system.key'),$registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));

        $idPosto = $this->auth->user()['posto'];

        $atendimentos = $this->posto->getAtendimentosPacienteByPosto($registro,$idPosto,$idAtendimento);

        if(!sizeof($atendimentos)){
            \App::abort(404);
        }

        $postoRealizante = $this->posto->getPostosRealizantesAtendimento($idPosto,$idAtendimento);

        return view('posto.paciente',compact('atendimentos','postoRealizante'));
    }

    public function getExamesatendimento($posto,$atendimento,$postoRealizante = null){
        $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($this->auth->user()['posto'],$atendimento);

        if(!$ehAtendimentoPosto){
            \App::abort(404);
        }

        $exames = $this->exames->getExames($posto, $atendimento,$postoRealizante);
     
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){
        $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($posto,$atendimento);

        if(!$ehAtendimentoPosto){
            return response()->json(array(
                'message' => 'Atendimento não é do posto'
            ), 203);
        }

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