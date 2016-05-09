<?php

/**
 * Classe de Controle do Paciente
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use App\Repositories\ExamesRepository;
use App\Repositories\ClienteAcessoRepository;
use App\Services\DataSnapService;
use Experience\Util\Formatar;
use BrowserDetect;

use Request;
use Redirect;
use Validator;
use Auth;

class PacienteController extends Controller {
    protected $auth;
    protected $atendimento;
    protected $exames;
    protected $dataSnap;
    protected $clienteAcesso;

    /**
     * Referencio os Repositorios/Controller a serem utilizados
     *
     * @param Guard $auth
     * @param AtendimentoRepository $atendimento
     * @param ExamesRepository $exames
     * @param DataSnapService $dataSnap
     * @param ClienteAcessoRepository $clienteAcesso
     */
    public function __construct(Guard $auth, AtendimentoRepository $atendimento, ExamesRepository $exames, DataSnapService $dataSnap, ClienteAcessoRepository $clienteAcesso)
    {
        $this->auth = $auth;
        $this->clienteAcesso = $clienteAcesso;
        $this->atendimento = $atendimento;
        $this->exames = $exames;
        $this->dataSnap = $dataSnap;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        //Pego da sessao o tipo de acesso do paciente
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];
        //Envio os dados de autenticação do usuario para carregar todos os atendimentos
        $atendimentos = $this->atendimento->atendimentos($this->auth->user());
       
        $result = BrowserDetect::isMobile() || BrowserDetect::isTablet();

        $user = Auth::user(['tipoLoginPaciente']);

        if($result == true){
            return view('mobile.paciente.index',compact('atendimentos','tipoLoginPaciente'));            
        }

        return view('paciente.index',compact('atendimentos','tipoLoginPaciente','user'));
    }

    /**
     * Reponsavel por listar toda os exames disponivel no atendimento
     * @param $posto
     * @param $atendimento
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamesatendimento($posto,$atendimento){
        //Verifico se o atendmiento enviado é do paciente, enviado os dados de acesso, posto e atendmiento
        $ehCliente = $this->atendimento->ehCliente($this->auth,$posto,$atendimento);

        if(!$ehCliente){
            \App::abort(404);
        }
        //Envio para a variavel todo os exames do atendimento
        $exames = $this->exames->getExames($posto, $atendimento);   

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    /**
     * Responsavel por retornar os detalhes do atendmieto de acordo com o correlativo enviado
     * @param $posto
     * @param $atendimento
     * @param $correl
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){
        //Verifica se o usuario tem saldo devedor
        $saldoDevedor = $this->atendimento->getSaldoDevedor($posto,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendências'
            ), 203);
        }
        //Carrega o resultado do exame solicitado
        $exames = $this->exames->getDetalheAtendimentoExameCorrel($posto, $atendimento,$correl);

        if(!$exames){
            return response()->json(array(
                'message' => 'Você não tem permissão para acessar esse exame'
            ), 203);
        }

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_decode($exames),
        ), 200);
    }

    /**
     * Responsavel por solicitar ao DATASNAP o PDF
     * @return string
     */
    public function postExportarpdf(){
        //Pego os dados enviado pelo formulario
        $dados = current(Request::input('dados'));
        //Separo os item enviados
        $posto = $dados['posto'];
        $atendimento = $dados['atendimento'];
        $correlativos = $dados['correlativos'];
        $cabecalho = $dados['cabecalho'];

        $qtdCaracterPosto = config('system.qtdCaracterPosto');

        if($posto < 100){
            $qtdCaracterPosto = 2;
        }

        //Completo com zero a esquerda o posto e atendimento de acordo com os padroes definidos no config
        $postoID = str_pad($posto,$qtdCaracterPosto,'0',STR_PAD_LEFT);
        $atendimentoID = str_pad($atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

        //Crio o ID unido o POSTOID e ATENDIMENTOID
        $id = strtoupper(md5($postoID.$atendimentoID));
        //Verifico se existe no banco de dados esse atendimento
        $atendimentoAcesso = new AtendimentoAcesso();
        $atendimentoAcesso = current($atendimentoAcesso->where(['id' => $id])->get()->toArray());

        //Pego a tenha do atendimento para verificação
        $pure = $atendimentoAcesso['pure'];

        //Verifico se a tenha é do Cliente logado no sistema
        $ehCliente = $this->atendimento->ehCliente($this->auth,$posto,$atendimento);

        if(!$ehCliente){
            \App::abort(404);
        }         
        //Solicita para o dataSnap gerar o PDF
        return $this->dataSnap->exportarPdf($posto,$atendimento,$pure,$correlativos,$cabecalho);
    }

    public function getPerfil(){
         return view('mobile.includes.perfil');
    }

    /**
     * Responsavel por alterar a senha do usuario
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postAlterarsenha(){
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];

        //Só libera a alteração de senha para o acesso do tipo CPF
        if($tipoLoginPaciente != 'CPF'){
            return response(['message'=>'Tipo de acesso não autorizado para alterar senha','data' => Request::all()],203);
        }
        //Valida os dados enviado pelo formulario de alteração de senha
        $validator = Validator::make(Request::all(), $this->clienteAcesso->getValidator());
        
        if ($validator->fails()) {
            return response(['message'=>'Erro - Senhas devem ter entre 6 e 15 caracteres.','data' => Request::all()],400);
        }
        //Cria o MD5 do registro
        $registro = strtoupper(md5($this->auth->user()['registro']));

        //Verifica se a senha atual esta correta para liberar a alteração
        $verifyAcesso = $this->clienteAcesso->findWhere(['id' => $registro, 'pure' => strtoupper(Request::input('senhaAtual'))])->count();

        if(!$verifyAcesso){
            return response(['message'=>'Senha atual não confere','data' => Request::all()],203);
        }

        //Altera a senha do usuario
        $acesso = $this->clienteAcesso->alterarSenha($registro,Request::input('novaSenha'));
        
        if(!$acesso){
            return response(['message' => 'Erro ao salvar.','data' => $acesso],500);
        }

        return response(['message' => 'Salvo com sucesso.','data' => $acesso],200);
    }
}
