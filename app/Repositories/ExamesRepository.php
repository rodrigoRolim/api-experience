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
                    $exames[$key]['class'] = 'success-element';
                    $exames[$key]['msg'] = 'Finalizado';
                    break;
                case 'R':
                    $exames[$key]['class'] = 'warning-element';
                    $exames[$key]['msg'] = 'Aguardando Liberação';
                    break;
                case 'I':
                    $exames[$key]['class'] = 'danger-element';
                    $exames[$key]['msg'] = 'Não realizado';
                    break;
            }
        }

        return $exames;
    }
}
