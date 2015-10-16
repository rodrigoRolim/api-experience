<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use App\Repositories\ExamesRepository;
use App\Repositories\ClienteAcessoRepository;
use App\Services\DataSnapService;

use Request;
use Redirect;
use Validator;

class PacienteController extends Controller {
    protected $auth;
    protected $atendimento;
    protected $exames;
    protected $dataSnap;
    protected $clienteAcesso;

    public function __construct(Guard $auth, AtendimentoRepository $atendimento, ExamesRepository $exames, DataSnapService $dataSnap, ClienteAcessoRepository $clienteAcesso)
    {
        $this->auth = $auth;
        $this->clienteAcesso = $clienteAcesso;
        $this->atendimento = $atendimento;
        $this->exames = $exames;
        $this->dataSnap = $dataSnap;
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

        $ehCliente = $this->atendimento->ehCliente($this->auth,$posto,$atendimento);

        if(!$ehCliente){
            \App::abort(404);
        }         

        return $this->dataSnap->exportarPdf($posto,$atendimento,$pure,$correlativos);
    }

    public function postAlterarsenha(){
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];

        if($tipoLoginPaciente != 'CPF'){
            return response(['message'=>'Tipo de acesso não autorizado para alterar senha','data' => Request::all()],203);
        }

        $validator = Validator::make(Request::all(), $this->clienteAcesso->getValidator());
        
        if ($validator->fails()) {
            return response(['message'=>'Erro ao validar','data' => Request::all()],400);
        }

        $registro = strtoupper(md5($this->auth->user()['registro']));

        $verifyAcesso = $this->clienteAcesso->findWhere(['id' => $registro, 'pure' => strtoupper(Request::input('senhaAtual'))])->count();

        if(!$verifyAcesso){
            return response(['message'=>'Senha atual não confere','data' => Request::all()],203);
        }

        $acesso = $this->clienteAcesso->alterarSenha($registro,Request::input('novaSenha'));
        
        if(!$acesso){
            return response(['message' => 'Erro ao salvar.','data' => $acesso],500);
        }

        return response(['message' => 'Salvo com sucesso.','data' => $acesso],200);
    }
}
