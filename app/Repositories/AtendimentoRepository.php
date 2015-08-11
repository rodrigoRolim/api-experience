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
            $sql = 'SELECT posto,atendimento,data_atd, (GET_MNEMONICOS(posto,atendimento)) mnemonicos
                    FROM vw_atendimentos
                    WHERE posto = :posto AND atendimento = :atendimento';

            $atendimento[] = current(DB::select(DB::raw($sql), ['posto' => $data[0],'atendimento' => $data[1]]));
        }

        return $atendimento;
    }
}
