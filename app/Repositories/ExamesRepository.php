<?php

/**
 * Classe reponsável por manipular dados do banco de dados
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use DB;

class ExamesRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Exame';
    }

    /**
     * Retorna todos os exames do atendimento, pode ser parametrizado com o postoRealizante a consulta,
     * essa função já retorna com a situação de cada exame para apresentação na view
     * @param $posto
     * @param $atendimento
     * @param null $postoRealizante
     * @return mixed
     */
    public function getExames($posto,$atendimento,$postoRealizante = null){

        if(!is_null($postoRealizante)){
            $exames = $this->findWhere(['posto' => $posto, 'atendimento' => $atendimento,'posto_rea' => $postoRealizante])->toArray();
        }else{
            $exames = $this->findWhere(['posto' => $posto, 'atendimento' => $atendimento])->toArray();
        }

        foreach($exames as $key => $exame){
            if($exames[$key]['posto'] > 100){
                $exames[$key]['posto'] = str_pad($exames[$key]['posto'],config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
            }
            
            $exames[$key]['atendimento'] = str_pad($exames[$key]['atendimento'],config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

            switch($exame['situacao_experience']){
                case 'FINALIZADO':
                    //VERDE
                    $exames[$key]['class'] = 'success-element';
                    $exames[$key]['corStatus'] = 'corStatusFinalizado';
                    $exames[$key]['msg'] = 'Finalizado';
                    $exames[$key]['view'] = true; //pode imprimir
                    break;
                case 'AGUARDANDO':
                    //AMARELO
                    $exames[$key]['class'] = 'aguardando-element';
                    $exames[$key]['msg'] = 'Parc. Finalizado';
                    $exames[$key]['view'] = false;
                    break;
                case 'ANDAMENTO':
                     //LARANJA
                    $exames[$key]['class'] = 'warning-element';
                    //$exames[$key]['msg'] = 'Em Processo';
                    $exames[$key]['msg'] = 'Em Andamento';
                    $exames[$key]['view'] = false;
                    break;
                case 'PENDENCIA':
                    //VERMELHO
                    $exames[$key]['class'] = 'danger-element';
                    $exames[$key]['corStatus'] = 'corStatusPendencias';
                    $exames[$key]['msg'] = 'Existem Pendências';
                    $exames[$key]['view'] = false;
                    break;
                case 'TERCEIRIZADO':
		            $exames[$key]['class'] = '';
                    $exames[$key]['corStatus'] = '';
                    $exames[$key]['msg'] = '';
                    $exames[$key]['view'] = false;
                default:
                    //PURPLE - NAO REALIZADO
                    $exames[$key]['class'] = 'naoRealizado-element';
                    $exames[$key]['corStatus'] = 'corStatusNaoRealizado';
                    $exames[$key]['msg'] = 'Em Andamento';
                    $exames[$key]['view'] = false;
                    break;
            }
            // tipo_procedimento não existe na view 
            if($exame['nome_procedimento'] != 'L'){
	    	     $exames[$key]['class'] = 'semLaudo';
                 $exames[$key]['corStatus'] = '';
                 $exames[$key]['msg'] = '';
                 $exames[$key]['view'] = false;
	        }

        }

        return $exames;
    }

    /**
     * Função responsavel por buscar os resultados do exame (CORREL)
     * @param $posto
     * @param $atendimento
     * @param $correl
     * @return mixed
     */
    public function getDetalheAtendimentoExameCorrel($posto,$atendimento,$correl){
        $sql = "
            SELECT 
                P.NOME PROCEDIMENTO, 
                'C' TIPO_LAUDO, 
                e.TIPO_ENTREGA,
                e.AMOSTRA, 
                e.mnemonico,
                TO_CHAR(E.DATA_COLE,'DD/MM/YY HH24:MI') DATA_COLE,
                TO_CHAR(E.DATA_REA1,'DD/MM/YY HH24:MI') DATA_REA1,
                NVL(M.TIPO_CR,'NULL') TIPO_CR,
                NVL(M.UF_CONSELHO,'NULL') UF_CONSELHO,
                NVL(M.CRM,'NULL') CRM,
                NVL(M.NOME,'NULL') NOME,
                V.NOME ANALITO,
                NVL(V.UNIDADE,'NULL') UNIDADE,
                V.DECIMAIS,
                V.VARIAVEL,
                V.TIPO_VARIAVEL,
                R.VALOR,
                R.NUMERO,
                TIPO 
            FROM 
                ".config('system.userAgilDB')."VEX_EXAMES E, 
                ".config('system.userAgilDB')."VEX_PROCEDIMENTOS P, 
                ".config('system.userAgilDB')."VEX_MEDICOS M, 
                ".config('system.userAgilDB')."VEX_RESULTADOS R, 
                ".config('system.userAgilDB')."VEX_VARIAVEIS V 
            WHERE E.POSTO = :posto AND E.ATENDIMENTO = :atendimento AND E.CORREL = :correl
                AND R.POSTO = E.POSTO AND R.ATENDIMENTO = E.ATENDIMENTO AND R.CORREL = E.CORREL
                AND E.REALIZANTE1 = M.CRM(+)
                AND P.MNEMONICO = E.MNEMONICO
                AND V.VARIAVEL = R.VARIAVEL
            ORDER BY V.ORDEM_VISUALIZACAO";
        // variavel não existe
        $dataResult = DB::select(DB::raw($sql),[
            'posto' => $posto,
            'atendimento' => $atendimento,
            'correl' => $correl,
        ]);

        $sqlTextos = "SELECT * FROM ".config('system.userAgilDB')."VEX_TEXTOS WHERE mnemonico = :mnemonico AND numero = :numero"; 

        $result = [];

        foreach ($dataResult as $key => $data) {
            $dataTextos = DB::select(
                DB::raw($sqlTextos),[
                    'mnemonico' => $data->mnemonico,
                    'numero' => $data->numero,
                ]
            );

            $textoLaudo = array_shift($dataTextos)->texto;

            $separadorVariavel = '';

            if($data->tipo_variavel == 'E') {
                $separadorVariavel = '[';
            }

            if($data->tipo_variavel == 'S') {
                $separadorVariavel = '|';
            }

            $variavel = $separadorVariavel.str_pad($data->variavel,4,'0',STR_PAD_LEFT);


            if(strpos($textoLaudo, $variavel) != false) {
                $result['PROCEDIMENTO'] = $data->procedimento;
                $result['TIPO_LAUDO']   = $data->tipo_laudo;
                $result['TIPO_ENTREGA'] = $data->tipo_entrega;
                $result['REALIZANTE']   = array(
                    'NOME' => $data->nome,
                    'TIPO_CR' => $data->tipo_cr,
                    'UF_CONSELHO' => $data->uf_conselho,
                    'CRM' => $data->crm
                );
                $result['DATA_REALIZANTE'] = $data->data_rea1;
                $result['DATA_COLETA'] = $data->data_cole;
                $result['AMOSTRAS'] = $data->amostra;

                $result['ANALITOS'][] = array(
                    'ANALITO' => $data->analito,
                    'VALOR' => $data->valor,
                    'UNIDADE' => $data->unidade,
                    'DECIMAIS' => $data->decimais,
                    'VALOR_REFERENCIA' => NULL
                );
            }
        }

        if(sizeof($result) && $result['TIPO_ENTREGA'] != '*'){
            return false;
        }

        //ATUALIZO QUE O EXAME FOI VISUALIZADO PELA INTERNET
        return json_encode($result);
    }
}
