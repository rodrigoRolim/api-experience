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
            switch($exame['situacao']){
                case 'I':
                    //VERDE
                    $exames[$key]['class'] = 'success-element';
                    $exames[$key]['msg'] = 'Finalizado';
                    $exames[$key]['view'] = true;
                    break;
                case 'R':
                    //LARANJA
                    $exames[$key]['class'] = 'warning-element';
                    $exames[$key]['msg'] = 'Aguardando Liberação';
                    $exames[$key]['view'] = false;
                    break;
                case 'N':
                    //VERMELHO
                    $exames[$key]['class'] = 'danger-element';
                    $exames[$key]['msg'] = 'Não realizado';
                    $exames[$key]['view'] = false;
                    break;
                default:
                    //CINZA
                    $exames[$key]['class'] = 'warning-element';
                    $exames[$key]['msg'] = 'default';
                    $exames[$key]['view'] = false;
                    break;
            }
        }

        return $exames;
    }
}
