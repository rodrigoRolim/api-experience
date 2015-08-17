<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use DB;

class AtendimentoRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Atendimento';
    }

    public function atendimentos($user)
    {
        $data = $user['username'];
        $data = explode("/",$data);

        if($user['tipoLoginPaciente'] == 'ID'){
            $sql = 'SELECT posto,atendimento,data_atd, INITCAP(nome_convenio), INITCAP(nome_solicitante), (GET_MNEMONICOS(posto,atendimento)) mnemonicos,saldo_devedor
                    FROM vw_atendimentos
                    WHERE posto = :posto AND atendimento = :atendimento';

            $atendimento[] = current(DB::select(DB::raw($sql), ['posto' => $data[0],'atendimento' => $data[1]]));
        }

        return $atendimento;
    }

    public function ehCliente($auth,$posto,$atendimento){
        $registro = $auth->user()['registro'];
        return (bool) $this->findWhere(['registro' => $registro, 'posto' => $posto, 'atendimento' => $atendimento])->count();
    }
}
