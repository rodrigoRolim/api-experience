<?php

/**
 * Classe de Controle do Posto
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\ParceiroRepository;
use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use Carbon\Carbon;

use App\Services\DataSnapService;

use Illuminate\Contracts\Auth\Guard;

use Request;
use Auth;

class PostoController extends Controller {

    protected $auth;    
    protected $convenio;
    protected $parceiro;
    protected $atendimento;
    protected $exames;
    protected $dataSnap;

    /**
     * Referenciada os repositorio/model utilizados no controlelr
     *
     * @param Guard $auth
     * @param ConvenioRepository $convenio
     * @param ParceiroRepository $parceiro
     * @param ExamesRepository $exames
     * @param AtendimentoRepository $atendimento
     * @param DataSnapService $dataSnap
     */
    public function __construct(
        Guard $auth,        
        ConvenioRepository $convenio,
        ParceiroRepository $parceiro,
        ExamesRepository $exames,
        AtendimentoRepository $atendimento,
        DataSnapService $dataSnap
    )
    {
        $this->auth = $auth;        
        $this->convenio = $convenio;
        $this->posto = $parceiro;
        $this->exames = $exames;
        $this->atendimento = $atendimento;
        $this->dataSnap = $dataSnap;
    }

    /**
     * Responsavel por exibição dos atendimentos do posto
     * @return $this
     */
    public function getIndex()
    {
        //Pega o id do posto na sessão
        $idPosto = $this->auth->user()['posto'];

        $postos = $this->posto->orderBy('nome')->lists('nome', 'posto');

        return view('posto.index', compact('postos'));
    }

   /**
     * Responsavel por localizar atendimento no posto dependente do filtro buscando pelo numero do atendimento
     * @return string
     */
    public function postLocalizaatendimento(){
        $dadosAtend = explode('/',Request::input('atendimento'));
        $parceiro = $dadosAtend[0];
        $atendimento = $dadosAtend[1];

        $result = $this->posto->getAtendimento($parceiro,$atendimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_encode($result),
        ), 200);        
    }    

    /**
    * Carrega acomodacao de acordo com o periodo do filtro
    *
    */
    public function postSelectacomodacao(){
        $idPosto = Request::get('posto');
        $acomodacoes = $this->posto->getAcomodacoesPosto($idPosto,Request::get('dataInicio'),Request::get('dataFim'));
    
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $acomodacoes,
        ), 200);
    }

    /**
    * Carrega postos realizantes a partir do filtro.
    *
    */
    public function postSelectpostorealizante(){
        $idPosto = Request::get('posto');
      
        $parceiroRealizantes = $this->posto->getPostosRealizantes($idPosto,Request::get('dataInicio'),Request::get('dataFim'));
    
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $parceiroRealizantes,
        ), 200);
    }

    /**
     * Responsavel por filtrar os atendimentos do posto
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFilteratendimentos(){
        //Pega os dados enviados do formulario do filtro
        $requestData = Request::all();
        //Pega o ID do posto na sessão
        $idPosto = Request::get('posto');

        //Verifica se dataInicio e dataFim seja diferente de nulo
        if($requestData['dataInicio'] != null && $requestData['dataFim'] != null){
            //Envia os valores para o repository filtrar
            $result = $this->posto->getAtendimentos(
                $idPosto,
                $requestData['dataInicio'],
                $requestData['dataFim'],
                $requestData['acomodacao'],
                $requestData['situacao'],
                $requestData['postoRealizante']
            );
            //Retorna em Json
           
            return response()->json(array(
                'message' => 'Recebido com sucesso.',
                'data' => $result,
            ), 200);
        }
    }

    /**
     * Reponsavel por listar dos os atendimetos do paciente feitos no seu posto
     * @param $registro
     * @param $parceiro
     * @param $atendimento
     * @return \Illuminate\View\View
     */
    public function getPaciente($registro,$parceiro,$atendimento){
        //Faz a descriptografia do token enviado via get
        $registro = base64_decode(strtr($registro, '-_', '+/'));
        //$registro = (int) trim(@mcrypt_decrypt(MCRYPT_RIJNDAEL_256, config('system.key'),$registro, MCRYPT_MODE_ECB, @mcrypt_create_iv(@mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
        $cipher = "aes-128-gcm";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $registro = (int) trim(openssl_encrypt($registro, $cipher, config('system.key'), $options=0, $iv, $tag));
        //ista todos os atendimentos do paciente para aquele posto
        $atendimento = $this->posto->getAtendimentosPacienteByPosto($registro,$parceiro,$atendimento);
        
        if(!sizeof($atendimento)){
            \App::abort(404);
        }

        $user = Auth::user();

        return view('paciente.posto',compact('atendimento','user'));
    }

    /**
     * Reponsavel por enviar os dados dos exames do atendimento
     * @param $parceiro
     * @param $atendimento
     * @param null $parceiroRealizante
     * @return \Illuminate\Http\JsonResponse
     */
    public function getExamesatendimento($parceiro,$atendimento,$parceiroRealizante = null){
        //Verifica se o atendmiento é do posto
        // $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($this->auth->user()['posto'],$atendimento);

        // if(!$ehAtendimentoPosto){
        //     \App::abort(404);
        // }
        
        //Lista os exames do atendimento
        $exames = $this->exames->getExames($parceiro, $atendimento,$parceiroRealizante);
     
        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    /**
     * Reposavel por listar os resultados dos exames
     * @param $parceiro
     * @param $atendimento
     * @param $correl
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetalheatendimentoexamecorrel($parceiro,$atendimento,$correl){
        //Verifica se o atendimento é do posto
        $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($parceiro,$atendimento);

        // if(!$ehAtendimentoPosto){
        //     return response()->json(array(
        //         'message' => 'Atendimento não é do posto'
        //     ), 203);
        // }
        //Verifica saldo devedor do atendimento
        $saldoDevedor = $this->atendimento->getSaldoDevedor($parceiro,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendências'
            ), 203);
        }

        //Verifica os detalhes do resultado do exame
        $exames = $this->exames->getDetalheAtendimentoExameCorrel($parceiro, $atendimento,$correl);

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
     * Responsavel por gerar o pdf do resultado
     * @return string
     */
    public function postExportarpdf(){
     
        //Captura os valores do exame selecionado
        $dados = Request::input('dados');
        $parceiro = (int) $dados[0]['posto'];
        $atendimento = $dados[0]['atendimento'];
        $correlativos = $dados[0]['correlativos'];
        $cabecalho = $dados[0]['cabecalho'];

        // $ehAtendimentoPosto = $this->posto->ehAtendimentoPosto($parceiro,$atendimento);

        // if(!$ehAtendimentoPosto){
        //     \App::abort(404);
        // }

        $qtdCaracterPosto = config('system.qtdCaracterPosto');

        if($parceiro < 100){
            $qtdCaracterPosto = 2;
        }

        //Prepara o posto e atendimento com zero a esquerda de acordo com a quantidade de caracter estipulado no config
        $parceiroID = str_pad($parceiro,$qtdCaracterPosto,'0',STR_PAD_LEFT);
        $atendimentoID = str_pad($atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

        //Gera o ID do médico de acordo com POSTO e atendimento
        $id = strtoupper(md5($parceiroID.$atendimentoID));

        //Pega a senha do atendimento no banco de dados
        $atendimentoAcesso = new AtendimentoAcesso();
        $atendimentoAcesso = current($atendimentoAcesso->where(['id' => $id])->get()->toArray());

        $pure = $atendimentoAcesso['pure'];

        //Envia para o servico do datasnap
        return $this->dataSnap->exportarPdf($parceiro,$atendimento,$pure,$correlativos,$cabecalho);
    }

    public function getLogs()
    {
        //pega todos os logs
        $model = new \App\Models\Monitoramento();
        $logs = $model->orderBy('created_at', 'desc')->limit(30)->get();

        return view('posto.logs', compact('logs'));
    }
}