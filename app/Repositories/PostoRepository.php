<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use DB;

class PostoRepository extends BaseRepository
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

    public function getAtendimentosPosto($idPosto){
        $sql = 'SELECT posto,atendimento,registro,data_atd,nome_solicitante,nome_convenio,nome_posto,situacao_exames_experience
                FROM
                  vw_atendimentos                 
                WHERE
                  posto = :idPosto
               	';

        $data[] = DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
        ]);

        $atendimentos = $data;

        
        return $atendimentos;
    }

    public function getConveniosPosto($idPosto)
    {
        $sql = 'SELECT
			     	DISTINCT convenio, nome_convenio
			  	FROM
			    	vw_atendimentos
			  	WHERE
			    	posto = :idPosto
			    ORDER BY
			    	nome_convenio';

        $data[] = DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
        ]);

        $convenios = array(''=>'Selecione ');       

	   	foreach ($data[0] as $key => $value) {
            $convenios[$value->convenio] = $value->nome_convenio;
        }       

        return $convenios;
    }
}
