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

    public function getClientes($idMedico,$dataInicio,$dataFim,$posto=null, $convenio=null,$situacao=null)
    {
        $sql = "SELECT
                  c.nome,c.data_nas,c.registro,get_atendimentos_solicitante(c.registro,m.id_medico,:maskPosto,:maskAtendimento)
                FROM
                  VW_ATENDIMENTOS A
                  INNER JOIN VW_MEDICOS M ON A.solicitante = m.crm
                  INNER JOIN VW_CLIENTES C ON a.registro = c.registro
                WHERE M.ID_MEDICO = :idMedico
                    AND A.DATA_ATD >= TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI')
                    AND A.DATA_ATD <= TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')
                    AND (:posto IS NULL OR A.POSTO = :posto)
                    AND (:convenio IS NULL OR A.CONVENIO = :convenio)
                    AND (:situacao IS NULL OR A.SITUACAO_EXAMES_EXPERIENCE = :situacao)
                ORDER BY c.nome";

        $mask = config('system.atendimentoMask');
        $mask = explode("/",$mask);

        $clientes[] = DB::select(DB::raw($sql),[
            'idMedico' => $idMedico,
            'dataInicio' => $dataInicio.' 00:00',
            'dataFim' => $dataFim.' 23:59',
            'maskPosto' => $mask[0],
            'maskAtendimento' => $mask[1],
            'posto' => $posto,
            'convenio' => $convenio,
            'situacao' => $situacao
        ]);

        return $clientes[0];
    }
}
