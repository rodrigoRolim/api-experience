<?php

namespace App\Repositories;

use Carbon\Carbon;
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

    public function getAtendimentos($idPosto,$dataInicio,$dataFim, $convenio=null,$situacao=null,$idPostoRealizante=null)
    {
        $sql = "SELECT DISTINCT
                   a.posto, a.atendimento,a.data_atd,a.nome_convenio, c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2, get_mnemonicos(a.posto, a.atendimento) as mnemonicos
                FROM
                  VW_ATENDIMENTOS A                  
                  INNER JOIN VW_CLIENTES C ON a.registro = c.registro
                  INNER JOIN VW_EXAMES E ON a.posto = e.posto AND a.atendimento = e.atendimento
                WHERE a.posto = :idPosto
                    AND A.DATA_ATD >= TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI')
                    AND A.DATA_ATD <= TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')                   
                    AND (:convenio IS NULL OR A.CONVENIO = :convenio)
                    AND (:situacao IS NULL OR A.SITUACAO_EXAMES_EXPERIENCE = :situacao)
                    AND (:postoRealizante IS NULL OR E.posto_realizante = :postoRealizante)
                ORDER BY c.nome";       

        $clientes[] = DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
            'dataInicio' => $dataInicio.' 00:00',
            'dataFim' => $dataFim.' 23:59',            
            'convenio' => $convenio,
            'situacao' => $situacao,
            'postoRealizante' => $idPostoRealizante
        ]);

        $clientes = $clientes[0];

        $dtNow = Carbon::now();

        for($i=0;$i<sizeof($clientes);$i++){           

            //Calcular idade
            $dtNascimento = Carbon::parse($clientes[$i]->data_nas);
            $data = $dtNow->diff($dtNascimento);

            $ano = (int) $data->y;
            $mes = (int) $data->m;
            $dia = (int) $data->d;

            $resultData = '';

            if($ano > 0){
                $resultData .= $ano.' ano'.($ano>1?'s':'').' ';
            }

            if($mes > 0){
                $resultData .= $mes.' mes'.($mes>1?'es':'').' ';
            }

            if($dia > 0){
                $resultData .= $dia.' dia'.($dia>1?'s':'').' ';
            }

            $clientes[$i]->idade = $resultData;

            $key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, config('system.key'), $clientes[$i]->registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
            $id = strtr(rtrim(base64_encode($key), '='), '+/', '-_');

            $clientes[$i]->key = $id;
        }

        return $clientes;
    }

    public function getPostosRealizantes()
    {
        $sql = 'SELECT posto,nome FROM POSTOS WHERE realiza_exames = "S" order by nome';
        $data [] = DB::select(DB::raw($sql));

        $postos = array ('' => 'Selecione');

        foreach ($data[0] as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
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

    public function getAtendimentosPacienteByPosto($registro,$idPosto){

        $sql = 'SELECT c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.posto,a.atendimento,data_atd, INITCAP(a.nome_convenio) AS nome_convenio, INITCAP(a.nome_solicitante) AS nome_solicitante, (GET_MNEMONICOS(a.posto,a.atendimento)) mnemonicos,a.saldo_devedor
            FROM vw_atendimentos a              
              INNER JOIN VW_CLIENTES c ON a.registro = c.registro
            WHERE c.registro = :registro 
            AND posto = :idPosto 
            ORDER BY data_atd DESC';

        $atendimento[] = DB::select(DB::raw($sql), ['registro' => $registro, 'idPosto' => $idPosto]);


        return $atendimento[0];
    }

    public function ehAtendimentoPosto($idPosto,$atendimento){
        $sql = "SELECT * FROM vw_atendimentos a                 
                WHERE
                  posto = :idPosto
                AND a.atendimento = :atendimento";

        $data = DB::select(DB::raw($sql),['idPosto'=>$idPosto,'atendimento'=>$atendimento]);
        return (bool) sizeof($data);
    }
}
