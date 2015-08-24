<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

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

    public function getExames($posto,$atendimento){
        $exames = $this->findWhere(['posto' => $posto, 'atendimento' => $atendimento])->toArray();

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
}
