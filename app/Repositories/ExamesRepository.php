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
            switch($exame['situacao_experience']){
                case 'FINALIZADO':
                    //VERDE
                    $exames[$key]['class'] = 'success-element';
                    $exames[$key]['msg'] = 'Finalizado';
                    $exames[$key]['view'] = true; //pode imprimir
                    break;
                case 'AGUARDANDO':
                    //AMARELO
                    $exames[$key]['class'] = 'aguardando-element';
                    $exames[$key]['msg'] = 'Aguardando Liberação';
                    $exames[$key]['view'] = false;
                    break;
                case 'ANDAMENTO':
                     //LARANJA
                    $exames[$key]['class'] = 'warning-element';
                    $exames[$key]['msg'] = 'Em Andamento';
                    $exames[$key]['view'] = false;
                case 'PENDENCIA':
                    //VERMELHO
                    $exames[$key]['class'] = 'danger-element';
                    $exames[$key]['msg'] = 'Existem Pendências';
                    $exames[$key]['view'] = false;
                    break;                
                default:
                    //CINZA - NAO REALIZADO
                    $exames[$key]['class'] = 'naoRealizado-element';
                    $exames[$key]['msg'] = 'Não Realizado';
                    $exames[$key]['view'] = false;
                    break;
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
        $sql = 'SELECT '.config('system.userAgilDB').'get_resultado_json(:posto,:atendimento,:correl) as resultado FROM DUAL';

        $detalheExames = current(DB::select(DB::raw($sql),[
            'posto' => $posto,
            'atendimento' => $atendimento,
            'correl' => $correl,
        ]));

        return $detalheExames->resultado;
    }
}
