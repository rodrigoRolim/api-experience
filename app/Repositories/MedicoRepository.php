<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use DB;

class MedicoRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Medico';
    }

    public function clientes($idMedico,$dataInicio,$dataFim)
    {
        $sql = 'SELECT
                  c.nome,GET_ATENDIMENTOS_SOLICITANTE(c.registro, m.id_medico,:maskPosto,:maskAtendimento)
                FROM
                  VW_ATENDIMENTOS A
                  INNER JOIN VW_MEDICOS M ON A.solicitante = m.crm
                  INNER JOIN VW_CLIENTES C ON a.registro = c.registro
                WHERE A.DATA_ATD >= TO_DATE(:dataInicio,"DD/MM/YYYY HH24:MI")
                  AND A.DATA_ATD <= TO_DATE(:dataFim,"DD/MM/YYYY HH24:MI")
                  AND M.ID_MEDICO = :idMedico
                ORDER BY nome';

        $clientes[] = DB::select(DB::raw($sql),[
            'maskPosto'       => '00',
            'maskAtendimento' => '000000',
            'dataInicio'      => '01/08/2015 00:00',
            'dataFim'         => '20/08/2015 23:59',
            'idMedico'        => '302',
        ]);

        return $clientes[0];
    }
}
