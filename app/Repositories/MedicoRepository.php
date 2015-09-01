<?php

namespace App\Repositories;

use Carbon\Carbon;
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
                  c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,get_atendimentos_solicitante(c.registro,m.id_medico,:maskPosto,:maskAtendimento) as atendimentos
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

        $clientes = $clientes[0];

        $dtNow = Carbon::now();

        for($i=0;$i<sizeof($clientes);$i++){
            $atd = explode(",",$clientes[$i]->atendimentos);
            array_pop($atd);
            $clientes[$i]->atendimentos = $atd;

            //Calcular idade
            $dtNascimento = Carbon::parse('1987-10-2 00:00:00');
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
        }

        return $clientes;
    }

    public function getAtendimentosPacienteByMedico($registro,$solicitante){
        $sql = 'SELECT c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.posto,a.atendimento,data_atd, INITCAP(a.nome_convenio) AS nome_convenio, INITCAP(a.nome_solicitante) AS nome_solicitante, (GET_MNEMONICOS(a.posto,a.atendimento)) mnemonicos,a.saldo_devedor
                FROM vw_atendimentos a
                  INNER JOIN VW_MEDICOS m ON a.solicitante = m.crm
                  INNER JOIN VW_CLIENTES c ON a.registro = c.registro
                WHERE c.registro = :registro AND m.ID_MEDICO = :solicitante
                ORDER BY data_atd DESC';

        $atendimento[] = DB::select(DB::raw($sql), ['registro' => $registro, 'solicitante' => $solicitante]);
        return $atendimento[0];
    }

    /**
     * Retorna os postos que o medico tenha atendimento
     * @param $idMedico
     */
    public function getPostoAtendimento($idMedico){
        $sql = 'SELECT p.posto, p.nome
                FROM
                  vw_medicos M
                  INNER JOIN vw_atendimentos A ON M.crm = A.solicitante
                  INNER JOIN vw_postos P ON A.posto = p.posto
                WHERE
                  m.id_medico = :idMedico
                GROUP BY p.posto,p.nome
                ORDER BY p.nome';

        $data[] = DB::select(DB::raw($sql),[
            'idMedico' => $idMedico,
        ]);

        $postos = array(''=>'Selecione');

        foreach ($data[0] as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
    }

    /**
     * Retorna os convenios que o medico tenha atendimento
     * @param $idMedico
     */
    public function getConvenioAtendimento($idMedico)
    {
        $sql = 'SELECT c.convenio,c.nome
                FROM
                  vw_medicos M
                  INNER JOIN vw_atendimentos A ON M.crm = A.solicitante
                  INNER JOIN vw_convenios C ON a.convenio = c.convenio
                WHERE
                  m.id_medico = :IdMedico
                GROUP BY c.convenio,c.nome
                ORDER BY c.nome';

        $data[] = DB::select(DB::raw($sql),[
            'idMedico' => $idMedico,
        ]);

        $convenios = array(''=>'Selecione ');

        foreach ($data[0] as $key => $value) {
            $convenios[$value->convenio] = $value->nome;
        }

        return $convenios;
    }

    public function ehAtendimentoMedico($idMedico,$posto,$atendimento){
        $sql = "SELECT * FROM vw_medicos M
                  INNER JOIN vw_atendimentos A ON M.crm = A.solicitante
                WHERE
                  m.id_medico = :idMedico
                  AND a.posto = :posto AND a.atendimento = :atendimento";

        $data = DB::select(DB::raw($sql),['idMedico'=>$idMedico,'posto'=>$posto,'atendimento'=>$atendimento]);
        return (bool) sizeof($data);
    }
}
