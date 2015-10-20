<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use App\Repositories\MedicoAcessoRepository;
use App\Repositories\PostoRepository;

use App\Services\DataSnapService;

use Illuminate\Contracts\Auth\Guard;
//use Vinkla\Hashids\Facades\Hashids;

use Request;
use Redirect;
use Validator;

class MedicoController extends Controller {
    protected $auth;
    protected $medico;
    protected $convenio;
    protected $posto;
    protected $atendimento;
    protected $exames;
    protected $dataSnap;

    public function __construct(
        Guard $auth,
        MedicoRepository $medico,
        ConvenioRepository $convenio,
        PostoRepository $posto,
        MedicoAcessoRepository $medicoAcesso,
        ExamesRepository $exames,
        AtendimentoRepository $atendimento,
        DataSnapService $dataSnap
    )
    {
        $this->auth = $auth;
        $this->medico = $medico;
        $this->medicoAcesso = $medicoAcesso;
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
        $this->atendimento = $atendimento;
        $this->dataSnap = $dataSnap;
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

    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        if(!$ehAtendimentoMedico){
            return response()->json(array(
                'message' => 'Atendimento não é do medico autenticado.'
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

    public function postExportarpdf(){    

        $dados = Request::input('dados');
        $posto = $dados[0]['posto'];
        $atendimento = $dados[0]['atendimento'];
        $correlativos = $dados[0]['correlativos'];    
        
        $postoID = str_pad($posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
        $atendimentoID = str_pad($atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

        $id = strtoupper(md5($postoID.$atendimentoID));

        $atendimentoAcesso = new AtendimentoAcesso();
        $atendimentoAcesso = $atendimentoAcesso->where(['id' => $id])->get()->toArray();

        $pure = $atendimentoAcesso[0]['pure'];

        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        if(!$ehAtendimentoMedico){
            \App::abort(404);
        }

        return $this->dataSnap->exportarPdf($posto,$atendimento,$pure,$correlativos);
    }

    public function postAlterarsenha(){
        $validator = Validator::make(Request::all(), $this->medicoAcesso->getValidator());
        
        if ($validator->fails()) {
            return response(['message'=>'Erro ao validar','data' => Request::all()],400);
        }
        
        $id = strtoupper(md5($this->auth->user()['id_medico']));

        $verifyAcesso = $this->medicoAcesso->findWhere(['id' => $id, 'pure' => strtoupper(Request::input('senhaAtual'))])->count();

        if(!$verifyAcesso){
            return response(['message'=>'Senha atual não confere','data' => Request::all()],203);
        }

        $acesso = $this->medicoAcesso->alterarSenha($id,Request::input('novaSenha'));
        
        if(!$acesso){
            return response(['message' => 'Erro ao salvar.','data' => $acesso],500);
        }

        return response(['message' => 'Salvo com sucesso.','data' => $acesso],200);
    }
}