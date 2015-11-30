<?php 

/**
* Classe de Controle do Medico
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use App\Repositories\MedicoAcessoRepository;
use App\Repositories\PostoRepository;

use App\Services\DataSnapService;

use Illuminate\Contracts\Auth\Guard;

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

        //Pego atraves do repositorio todos os postos e convenios que tem algum atendimento do médico
        $postos = $this->medico->getPostoAtendimento($idMedico);
        $convenios = $this->medico->getConvenioAtendimento($idMedico);

        //Retorno para a view para alimentação do filtro inicial
        return view('medico.index')->with(
            array(
                'postos' => $postos,
                'convenios' => $convenios,
            )
        );
    }
    /**
     * Metodo chamado via jquery para alimentar o grid dos pacientes do médico
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFilterclientes(){
        //Pego todos os valores enviado do formulario
        $requestData = Request::all();
        //Pego o ID_MEDICO da sessao do usuario
        $idMedico = $this->auth->user()['id_medico']; 

        //Verifico se da dataInicio e dataFim seja diferente de nulo
        if($requestData['dataInicio'] != null && $requestData['dataFim'] != null){
            //Passo os parametros para uma consulta via repositorio
            $result = $this->medico->getClientes(
                $idMedico,
                $requestData['dataInicio'],
                $requestData['dataFim'],
                $requestData['posto'],
                $requestData['convenio'],
                $requestData['situacao']
            );
            //retorno o json com os resultados para a view
            return response()->json(array(
                'message' => 'Recebido com sucesso.',
                'data' => $result,
            ), 200);
        }
    }

    /**
     * Função responsavel por retornar todos os atendimentos solicitados pelo medico ao paciente
     * @param $registro
     * @return \Illuminate\View\View
     */
    public function getPaciente($registro){
        //Como e passado o registro do cliente via get com encode token,
        //precisamos fazer a engenharia reversa para verificar junto ao
        //banco os dados a serem exibidos
        $registro = base64_decode(strtr($registro, '-_', '+/'));
        $registro = (int) trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, config('system.key'),$registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));

        $idMedico = $this->auth->user()['id_medico'];

        //Pego os atendimentos do paciente solicitado pelo medigo no repositorio
        $atendimentos = $this->medico->getAtendimentosPacienteByMedico($registro,$idMedico);
        //Caso nao exista registro o sistema libera um erro 404
        if(!sizeof($atendimentos)){
            \App::abort(404);
        }
        //Envia para a vio os atendimentos
        return view('medico.paciente',compact('atendimentos'));
    }

    /**
     * Retorna os exames do atendimento
     * @param $posto
     * @param $atendimento
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamesatendimento($posto,$atendimento){
        //Verifico junto ao repositorio do medico se o atendimento foi ele que solicitou,
        //dessa forma garanto que apenas o medico solicitante tenha acesso as informações
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);
        //Caso não encontre ele retorna o error 4040
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
     * Verifica Detalhes do resultado dos exame de acordo com o correlativo
     * @param $posto
     * @param $atendimento
     * @param $correl
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){
        //Verifica se o medico autenticado é o medico solicitante do atendimento
        $ehAtendimentoMedico = $this->medico->ehAtendimentoMedico($this->auth->user()['id_medico'],$posto,$atendimento);

        //Caso não encontre registro, o sistema retorna o error 203
        if(!$ehAtendimentoMedico){
            return response()->json(array(
                'message' => 'Atendimento não é do medico autenticado.'
            ), 203);
        }
        //Verifica se o atendimento tem saldo devedor, caso tenha o sistema não libera o acesso aos resultadoso
        $saldoDevedor = $this->atendimento->getSaldoDevedor($posto,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendências'
            ), 203);
        }
        //Retorna para a view os dados do resultado para exibição
        $exames = $this->exames->getDetalheAtendimentoExameCorrel($posto, $atendimento,$correl);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_decode($exames),
        ), 200);
    }

    /**
     * Responsavel para enviar para o DataSnapService a solicitação de Gerar PDF
     * @return string
     */
    public function postExportarpdf(){
        //Pega os dados enviados na requisição
        $dados = current(Request::input('dados'));
        //Separa os dados o posto, atendimento e correl
        $posto = $dados['posto'];
        $atendimento = $dados['atendimento'];
        $correlativos = $dados['correlativos'];    

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
        //Solicito para o dataSnap a geração do PDF
        return $this->dataSnap->exportarPdf($posto,$atendimento,$pure,$correlativos);
    }

    /**
     * Responsavel por alterar senha de acesso do médico
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function postAlterarsenha(){
        //Faço a verificação dos campo enviados de acordo com as regras de validação do medico
        $validator = Validator::make(Request::all(), $this->medicoAcesso->getValidator());

        //Caso não seja valido os dados
        if ($validator->fails()) {
            return response(['message'=>'Erro ao validar','data' => Request::all()],400);
        }

        //Gero o ID do medico com um md5 do ID_MEDICO
        $id = strtoupper(md5($this->auth->user()['id_medico']));

        //Verifico a tenha atual do medico para liberar a alteração para a nova senha
        $verifyAcesso = $this->medicoAcesso->findWhere(['id' => $id, 'pure' => strtoupper(Request::input('senhaAtual'))])->count();

        if(!$verifyAcesso){
            return response(['message'=>'Senha atual não confere','data' => Request::all()],203);
        }
        //Envio os dados para o repository alterar a senha
        $acesso = $this->medicoAcesso->alterarSenha($id,Request::input('novaSenha'));
        
        if(!$acesso){
            return response(['message' => 'Erro ao salvar.','data' => $acesso],500);
        }

        return response(['message' => 'Salvo com sucesso.','data' => $acesso],200);
    }
}