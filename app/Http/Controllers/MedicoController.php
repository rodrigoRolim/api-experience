<?php 

/**
* Classe de Controle do Medico
*
* @author Bruno AraÃºjo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use Experience\Util\Formatar;
use App\Repositories\MedicoAcessoRepository;
use App\Repositories\PostoRepository;

use App\Services\DataSnapService;

use Illuminate\Contracts\Auth\Guard;

use Request;
use Redirect;
use Validator;
use BrowserDetect;
use Auth;

class MedicoController extends Controller {
    protected $auth;
    protected $medico;
    protected $convenio;
    protected $posto;
    protected $atendimento;
    protected $exames;
    protected $dataSnap;

    /**
     * Referencia os Repositorios para serem usados no controller
     * @param Guard $auth
     * @param MedicoRepository $medico
     * @param ConvenioRepository $convenio
     * @param PostoRepository $posto
     * @param MedicoAcessoRepository $medicoAcesso
     * @param ExamesRepository $exames
     * @param AtendimentoRepository $atendimento
     * @param DataSnapService $dataSnap
     */
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
        //Passo eles para as suas variavies especificas
        $this->auth = $auth;
        $this->medico = $medico;
        $this->medicoAcesso = $medicoAcesso;
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
        $this->atendimento = $atendimento;
        $this->dataSnap = $dataSnap;
    }

    //
    /**
     * Rota de index medico ex.'url/medico/index'
     * @return $this
     */
    public function getIndex()
    {
        //Pego da sessao do usuario o ID_MEDICO
        $idMedico = $this->auth->user()['id_medico'];

        // //Pego atraves do repositorio todos os postos e convenios que tem algum atendimento do mÃ©dico
        //$postos = $this->medico->getPostoAtendimento($idMedico);
        //$convenios = $this->medico->getConvenioAtendimento($idMedico);

        
        $mobile = BrowserDetect::isMobile() || BrowserDetect::isTablet();

        if($mobile == true){
            return view('mobile.medico.index');
        }


        //Retorno para a view para alimentaÃ§Ã£o do filtro inicial
        return view('medico.index');
    }
    /**
     * Metodo chamado via jquery para alimentar o grid dos pacientes do mÃ©dico
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFilterclientes(){
        //Pego o ID_MEDICO da sessao do usuario
        $idMedico = $this->auth->user()['id_medico'];

        $dataInicio = Request::input('dataInicio');
        $dataFim    = Request::input('dataFim');
        $paciente   = Request::input('paciente');

        $result = $this->medico->getClientes($idMedico, $dataInicio, $dataFim, $paciente);

        //retorno o json com os resultados para a view
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $result,
        ), 200);
    }

    /**
     * FunÃ§Ã£o responsavel por retornar todos os atendimentos solicitados pelo medico ao paciente
     * @param $registro
     * @return \Illuminate\View\View
     */
    public function getPaciente($registro){
        //Como e passado o registro do cliente via get com encode token,
        //precisamos fazer a engenharia reversa para verificar junto ao
        //banco os dados a serem exibidos
        //print_r($registro);
        //$cipher = "aes-256-cbc";
        //$ivlen = openssl_cipher_iv_length($cipher);
        //$iv = openssl_random_pseudo_bytes($ivlen);
        //print_r($iv);
        //$registro = base64_decode(strtr($registro, '-_', '+/'));
        //print_r($registro);
        //$registro = (int) trim(openssl_decrypt($registro, $cipher, config('system.key'), 0, config('system.key')));

        $idMedico = $this->auth->user()['id_medico'];

        //Pego os atendimentos do paciente solicitado pelo medigo no repositorio
        $atendimentos = $this->medico->getAtendimentosPacienteByMedico($registro,$idMedico);

        //Caso nao exista registro o sistema libera um erro 404
        if(!sizeof($atendimentos)){
            \App::abort(404);
        }

        $atendimentos[0]->nome = Formatar::nomeCurto($atendimentos[0]->nome);

        $user = Auth::user(['tipoAcesso']);

        /*        
        $mobile = BrowserDetect::isMobile() || BrowserDetect::isTablet();

        if($mobile == true){
            return view('mobile.paciente.index',compact('atendimentos'));
        }
        */

        //Envia para a view os atendimentos
        return view('paciente.index',compact('atendimentos','user'));
    }

    /**
     * Retorna os exames do atendimento
     * @param $posto
     * @param $atendimento
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamesatendimento($posto,$atendimento){
        //Verifico junto ao repositorio do medico se o atendimento foi ele que solicitou,
        //dessa forma garanto que apenas o medico solicitante tenha acesso as informaÃ§Ãµes
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);
        
        //Caso nÃ£o encontre ele retorna o error 4040
        if(!$ehAtendimentoMedico){
            \App::abort(404);
        }

        //Pega todos os exames do posto e atendimento
        $exames = $this->exames->getExames($posto, $atendimento);

        //Retorna o objeto em Json para alimentar a view
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    /**
     * Seleciona os convenios referentes as datas passadas no filtro.
     * @param $idMedico
     * @param $dataInicio
     * @param $dataFim
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSelectconvenios(){
        $idMedico = $this->auth->user()['id_medico'];
        $convenios = $this->medico->getConvenioAtendimento($idMedico,Request::get('dataInicio'),Request::get('dataFim'));
    
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $convenios,
        ), 200);
    }

    /**
     * Seleciona os postos de cadastro referentes as datas passadas no filtro.
     * @param $idMedico
     * @param $dataInicio
     * @param $dataFim
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSelectpostoscadastro(){
        $idMedico = $this->auth->user()['id_medico'];
        $postosCadastro = $this->medico->getPostoAtendimento($idMedico,Request::get('dataInicio'),Request::get('dataFim'));
    
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $postosCadastro,
        ), 200);
    }

    /**
     * Verifica Detalhes do resultado dos exame de acordo com o correlativo
     * @param $posto
     * @param $atendimento
     * @param $correl
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){
        //Verifica se o medico autenticado Ã© o medico solicitante do atendimento
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        //Caso nÃ£o encontre registro, o sistema retorna o error 203
        if(!$ehAtendimentoMedico){
            return response()->json(array(
                'message' => 'Atendimento nÃ£o Ã© do medico autenticado.'
            ), 203);
        }
        //Verifica se o atendimento tem saldo devedor, caso tenha o sistema nÃ£o libera o acesso aos resultadoso
        $saldoDevedor = $this->atendimento->getSaldoDevedor($posto,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendÃªncias'
            ), 203);
        }
        //Retorna para a view os dados do resultado para exibiÃ§Ã£o
        $exames = $this->exames->getDetalheAtendimentoExameCorrel($posto, $atendimento,$correl);

        if(!$exames){
            return response()->json(array(
                'message' => 'VocÃª nÃ£o tem permissÃ£o para acessar esse exame'
            ), 203);
        }

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_decode($exames),
        ), 200);
    }

    /**
     * Responsavel para enviar para o DataSnapService a solicitaÃ§Ã£o de Gerar PDF
     * @return string
     */
    public function postExportarpdf(){
        //Pega os dados enviados na requisiÃ§Ã£o
        $dados = current(Request::input('dados'));
        //Separa os dados o posto, atendimento e correl
        $posto = $dados['posto'];
        $atendimento = $dados['atendimento'];
        $correlativos = $dados['correlativos'];    
        $cabecalho = $dados['cabecalho'];


        $qtdCaracterPosto = config('system.qtdCaracterPosto');

        if($posto < 100){
            $qtdCaracterPosto = 2;
        }

        //Completo com 0 a esquerda o posto e atendiemtno para que fique a mesma quantidade de caracter do config
        $postoID = str_pad($posto,$qtdCaracterPosto,'0',STR_PAD_LEFT);
        $atendimentoID = str_pad($atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

        //Crio o ID com um md5 de posto e atendimento
        $id = strtoupper(md5($postoID.$atendimentoID));

        //Verifico no banco de dados se o ID exite
        $atendimentoAcesso = new AtendimentoAcesso();
        $atendimentoAcesso = current($atendimentoAcesso->where(['id' => $id])->get()->toArray());

        //Pego a senha do atendimento
        $pure = $atendimentoAcesso['pure'];

        //Verifico se o medico foi o solicitante do atendimento
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        if(!$ehAtendimentoMedico){
            \App::abort(404);
        }
        //Solicito para o dataSnap a geraÃ§Ã£o do PDF
        return $this->dataSnap->exportarPdf($posto,$atendimento,$pure,$correlativos,$cabecalho);
    }

    public function getPerfil(){
         return view('mobile.includes.perfil');
    }

    /**
     * Responsavel por alterar senha de acesso do mÃ©dico
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postAlterarsenha(){
        //FaÃ§o a verificaÃ§Ã£o dos campo enviados de acordo com as regras de validaÃ§Ã£o do medico
        $validator = Validator::make(Request::all(), $this->medicoAcesso->getValidator());

        //Caso nÃ£o seja valido os dados
        if ($validator->fails()) {
            return response(['message'=>'Erro - Senhas devem ter entre 6 e 15 caracteres.','data' => Request::all()],400);
        }

        //Gero o ID do medico com um md5 do ID_MEDICO
        $id = strtoupper(md5($this->auth->user()['id_medico']));

        //Verifico a tenha atual do medico para liberar a alteraÃ§Ã£o para a nova senha
        $verifyAcesso = $this->medicoAcesso->findWhere(['id' => $id, 'pure' => strtoupper(Request::input('senhaAtual'))])->count();

        if(!$verifyAcesso){
            return response(['message'=>'Senha atual nÃ£o confere','data' => Request::all()],203);
        }
        //Envio os dados para o repository alterar a senha
        $acesso = $this->medicoAcesso->alterarSenha($id,Request::input('novaSenha'));
        
        if(!$acesso){
            return response(['message' => 'Erro ao salvar.','data' => $acesso],500);
        }

        return response(['message' => 'Salvo com sucesso.','data' => $acesso],200);
    }

    public function postLocalizapaciente()
    {
        $nome = Request::input('paciente');
        $nascimento = Request::input('nascimento');

        $pacientes = $this->medico->localizapaciente($this->auth->user()['id_medico'], $nome, $nascimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $pacientes,
        ), 200);
    }

}
