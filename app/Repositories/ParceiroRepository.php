<?php

/**
 * Classe reponsável por manipular dados do banco de dados
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Experience\Util\DataNascimento;
use Experience\Util\Formatar;
use DB;
use Auth;
use Crypt;
class ParceiroRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Posto';
    }

    /**
     * Função responsavel por buscar os dados de um atendimento especifico
     * @param $posto
     * @param $atendimento
     * @return array
     */
    public function getAtendimento($posto,$atendimento){
        $sql = "SELECT DISTINCT
                 a.situacao_exames_experience, a.posto, a.atendimento,a.data_atd,a.nome_convenio, c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2, ".config('system.userAgilDB')."get_mnemonicos(a.posto, a.atendimento,null) as mnemonicos,a.data_entrega
              FROM
                ".config('system.userAgilDB')."VEX_ATENDIMENTOS A                  
                INNER JOIN ".config('system.userAgilDB')."VEX_CLIENTES C ON a.registro = c.registro
              WHERE a.posto = :posto AND a.atendimento = :atendimento
                  AND ".config('system.userAgilDB')."get_mnemonicos(a.posto,a.atendimento,null) is not null
              ORDER BY a.data_atd, c.nome";

        $clientes = DB::select(DB::raw($sql),[
          'posto' => $posto,
          'atendimento' => $atendimento
        ]);

        return $this->renderCliente($clientes);
    }

    /**
     * Função responsavel por listar todos os atendimentos do posto de acordo com o filtro
     * @param $idPosto
     * @param $dataInicio
     * @param $dataFim
     * @param null $convenio
     * @param null $situacao
     * @param null $postoRealizante
     * @return array
     */
    public function getAtendimentos($idPosto,$dataInicio,$dataFim, $acomodacao=null,$situacao=null,$paciente = null)
    {
        $sql = "SELECT DISTINCT
                   a.situacao_exames_experience, a.posto, a.atendimento,a.data_atd,a.nome_convenio, c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2, ".config('system.userAgilDB')."get_mnemonicos(a.posto, a.atendimento,:postoRealizante) as mnemonicos,a.data_entrega
                FROM
                  ".config('system.userAgilDB')."VEX_ATENDIMENTOS A                  
                  INNER JOIN ".config('system.userAgilDB')."VEX_CLIENTES C ON a.registro = c.registro
                WHERE a.posto = :idPosto ";
        

        if($paciente == ''){
            $sql .= "AND A.DATA_ATD BETWEEN TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI')
            AND TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')       
            AND (:acomodacao IS NULL OR A.ACOMODACAO = :acomodacao)
            AND (:situacao IS NULL OR A.SITUACAO_EXAMES_EXPERIENCE = :situacao)
            AND ".config('system.userAgilDB')."get_mnemonicos(a.posto,a.atendimento,:postoRealizante) is not null ";

            $sql .= "ORDER BY c.nome, a.data_atd ";

            $clientes = DB::select(DB::raw($sql),[
                'idPosto' => $idPosto,
                'dataInicio' => $dataInicio.' 00:00',
                'dataFim' => $dataFim.' 23:59',            
                'acomodacao' => $acomodacao,
                'situacao' => $situacao,
                'postoRealizante' => null
            ]);
        }else{
            $sql .= "AND c.nome like :paciente ";

            $sql .= "ORDER BY c.nome, a.data_atd ";

            $clientes = DB::select(DB::raw($sql),[
                'idPosto' => $idPosto,
                'paciente' => '%'.mb_strtoupper($paciente).'%',
                'postoRealizante' => null
            ]);
        }

        return $this->renderCliente($clientes);
    }

    /**
     * Função responsavel por renderizar os dados de cliente
     * @param Array $clientes
     * @return array
     */    
    private function renderCliente($clientes){
      $dtNow = Carbon::now();

      for($i=0;$i<sizeof($clientes);$i++){
        $key = Crypt::encrypt($clientes[$i]->registro);

        $id = strtr(rtrim(base64_encode($key), '='), '+/', '-_');

          $clientes[$i]->key = $clientes[$i]->registro;

          switch ($clientes[$i]->situacao_exames_experience){
              case 'EA':
                  $clientes[$i]->situacaoAtendimento = 'warning-element';
                  break;
              case 'TF':
                  $clientes[$i]->situacaoAtendimento = 'success-element';
                  break;
              case 'PF':
                  $clientes[$i]->situacaoAtendimento = 'aguardando-element';
                  break;
              case 'EP':
                  $clientes[$i]->situacaoAtendimento = 'danger-element';
                  break;
              default:
                  $clientes[$i]->situacaoAtendimento = 'naoRealizado-element';
                  break;
          }

            if($clientes[$i]->posto > 100){
                $clientes[$i]->posto = str_pad($clientes[$i]->posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
            }
          
          // $clientes[$i]->posto = str_pad($clientes[$i]->posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
          $clientes[$i]->atendimento = str_pad($clientes[$i]->atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

          $clientes[$i]->data_atd = Formatar::data($clientes[$i]->data_atd,'Y-m-d H:i:s','d/m/Y');
          $clientes[$i]->data_nas = Formatar::data($clientes[$i]->data_nas,'Y-m-d H:i:s','d/m/Y');

          $clientes[$i]->data_entrega = Formatar::data($clientes[$i]->data_entrega,'Y-m-d H:i:s','d/m/Y');
      }

      return $clientes;
    }

    /**
     * Função responsavel por retornar todos os postos realizantes do posto logado
     * @return mixed
     */
    public function getPostosRealizantes($posto,$dataInicio,$dataFim)
    {
        $sql = "SELECT DISTINCT 
                    p.posto,p.nome 
                FROM 
                    ".config('system.userAgilDB')."VEX_ATENDIMENTOS a
                  INNER JOIN 
                    ".config('system.userAgilDB')."VEX_EXAMES e ON a.posto = e.posto AND a.atendimento = e.atendimento
                  INNER JOIN 
                    ".config('system.userAgilDB')."VEX_POSTOS p ON p.posto = e.posto_realizante
                WHERE 
                    a.posto = :posto AND a.DATA_ATD BETWEEN TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI') AND TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')
                ORDER BY nome";

        $data = DB::select(DB::raw($sql),[
            'posto' => $posto,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim
        ]);
        
        $postos = [];

        foreach ($data as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
    }

    /**
     * Retorna todo os postos realizante do atendimento
     * @param $posto
     * @param $atendimento
     * @return mixed
     */
    public function getPostosRealizantesAtendimento($posto,$atendimento)
    {
        $sql = 'SELECT 
                    DISTINCT p.posto,p.nome 
                FROM '.config('system.userAgilDB').'VEX_POSTOS p
                    INNER JOIN '.config('system.userAgilDB').'VEX_EXAMES e ON e.posto_realizante = p.posto
                WHERE 
                    p.realiza_exames = :tipo AND e.posto = :posto AND e.atendimento = :atendimento
                ORDER BY 
                    p.nome';
        
        $data = DB::select(DB::raw($sql),[
            'tipo' => 'S',
            'posto' => $posto,
            'atendimento' => $atendimento
        ]);

        $postos = [];

        foreach ($data as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
    }

    /**
     * Retorna todos os convenios para o posto
     * @param $idPosto
     * @return array
     */
    public function getConveniosPosto($idPosto)
    {
        $sql = 'SELECT
			     	DISTINCT convenio, nome_convenio
			  	FROM '.config('system.userAgilDB').'vex_atendimentos
			  	WHERE
			    	posto = :idPosto
			    ORDER BY
			    	nome_convenio';

        $data = DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
        ]);

        $convenios = array(''=>'Todos');       

	   foreach($data as $key => $value) {
            $convenios[$value->convenio] = $value->nome_convenio;
        }       

        return $convenios;
    }

    public function getAcomodacoesPosto($idPosto,$dataInicio,$dataFim)
    {
        $acomodacoes = [];

        $sql =  "SELECT
                    DISTINCT acomodacao
                FROM ".config('system.userAgilDB')."vex_atendimentos A 
                WHERE
                    posto = :idPosto
                    AND A.DATA_ATD BETWEEN TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI')
                    AND TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')                   
                ORDER BY
                    acomodacao";


        $data = DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
            'dataInicio' => $dataInicio.' 00:00',
            'dataFim' => $dataFim.' 23:59',   
        ]);

        foreach ($data as $key => $value) {
            $acomodacoes[$value->acomodacao] = $value->acomodacao;
        }      

        $acomodacoes = array(''=>'Todos') + $acomodacoes;


        return $acomodacoes;
    }

    /**
     * Função responsavel por retornar todos os atendimentos do paciente do posto
     * @param $registro
     * @param $idPosto
     * @param $idAtendimento
     * @return mixed
     */
    public function getAtendimentosPacienteByPosto($registro,$idPosto,$idAtendimento){
        $sql = 'SELECT c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.posto,a.atendimento,a.acomodacao,data_atd, INITCAP(a.nome_convenio) AS nome_convenio, INITCAP(a.nome_solicitante) AS nome_solicitante, ('.config('system.userAgilDB').'GET_MNEMONICOS(a.posto,a.atendimento)) mnemonicos,a.data_entrega,a.saldo_devedor
            FROM '.config('system.userAgilDB').'vex_atendimentos a              
              INNER JOIN '.config('system.userAgilDB').'VEX_CLIENTES c ON a.registro = c.registro
            WHERE c.registro = :registro 
            AND posto = :idPosto 
            AND a.atendimento = :idAtendimento
            ORDER BY data_atd DESC';

        $atendimento = DB::select(DB::raw($sql), ['registro' => $registro, 'idPosto' => $idPosto, 'idAtendimento' => $idAtendimento]);

        $atendimento = current($atendimento);
        $atendimento->idade = DataNascimento::idade($atendimento->data_nas);
        $atendimento->data_atd = Formatar::data($atendimento->data_atd,'Y-m-d H:i:s','d/m/Y');
        $atendimento->data_entrega = Formatar::data($atendimento->data_entrega,'Y-m-d H:i:s','d/m/Y');

        return $atendimento;    
    }

    /**
     * Verifica se o atendimento é do posto
     * @param $idPosto
     * @param $atendimento
     * @return bool
     */
    public function ehAtendimentoPosto($idPosto,$atendimento){

        $sql = 'SELECT * FROM '.config('system.userAgilDB').'vex_atendimentos a                 
                WHERE
                  posto = :idPosto
                AND a.atendimento = :atendimento';

        $data = DB::select(DB::raw($sql),['idPosto'=>$idPosto,'atendimento'=>$atendimento]);

        return (bool) sizeof($data);
    }
}
