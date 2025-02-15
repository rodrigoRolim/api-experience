<?php
/**
 * Classe reponsável por manipular dados do banco de dados.
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 *
 * @version 1.0
 */

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Experience\Util\DataNascimento;
use Experience\Util\Formatar;
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

    /**
     * Função responsavel em buscar todos os clientes que tenham
     * algum atendimento com o médico solicitante dentro do filtro definido.
     *
     * @param $idMedico
     * @param $dataInicio
     * @param $dataFim
     * @param null $posto
     * @param null $convenio
     * @param null $situacao
     *
     * @return array
     */
    public function getClientes($idMedico, $dataInicio = null, $dataFim = null, $paciente = null)
    {
        $sql = 'SELECT DISTINCT
                  c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.acomodacao,'.config('system.userAgilDB').'get_atendimentos_solicitante(c.registro,m.id_medico,:maskPosto,:maskAtendimento) as atendimentos
                FROM
                  '.config('system.userAgilDB').'VEX_ATENDIMENTOS A
                  INNER JOIN '.config('system.userAgilDB').'VEX_MEDICOS M ON A.solicitante = m.crm
                  INNER JOIN '.config('system.userAgilDB').'VEX_CLIENTES C ON a.registro = c.registro
                WHERE M.ID_MEDICO = :idMedico ';

        $order = "ORDER BY c.nome ";

        $mask = config('system.atendimentoMask');
        $mask = explode('/', $mask);

        if($paciente == ""){
            $sql .= "AND A.DATA_ATD >= TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI') AND A.DATA_ATD <= TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI') ";
        
            $clientes = DB::select(DB::raw($sql.$order), [
                'idMedico' => $idMedico,
                'dataInicio' => $dataInicio.' 00:00',
                'dataFim' => $dataFim.' 23:59',
                'maskPosto' => $mask[0],
                'maskAtendimento' => $mask[1],
            ]);
        }else{
            $sql .= "AND c.nome LIKE :paciente ";

            $clientes = DB::select(DB::raw($sql.$order), [
                'idMedico' => $idMedico,
                'paciente' => '%'.mb_strtoupper($paciente).'%',
                'maskPosto' => $mask[0],
                'maskAtendimento' => $mask[1],
            ]);
        }

        for ($i = 0; $i < sizeof($clientes); ++$i) {
            $atd = explode(',', $clientes[$i]->atendimentos);
            array_pop($atd);
            $clientes[$i]->atendimentos = $atd;

            $clientes[$i]->idade = DataNascimento::idade($clientes[$i]->data_nas);
           // $cipher = "aes-256-cbc";
           // $ivlen = openssl_cipher_iv_length($cipher);
            //$iv = openssl_random_pseudo_bytes($ivlen);
           // $key = openssl_encrypt($clientes[$i]->registro, $cipher, config('system.key'), 0, config('system.iv'));
            //$key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, config('system.key'), $clientes[$i]->registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
            //$id = strtr(rtrim(base64_encode($key), '='), '+/', '-_');

            $clientes[$i]->key = $clientes[$i]->registro;
        }

        return $clientes;
    }

    /**
     * Função retorna apenas os atendimentos que o médico solicitou do paciente.
     *
     * @param $registro
     * @param $solicitante
     *
     * @return mixed
     */
    public function getAtendimentosPacienteByMedico($registro, $solicitante)
    {
        $sql = 'SELECT c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.acomodacao,a.posto,a.atendimento,a.data_entrega,a.data_atd, INITCAP(a.nome_convenio) AS nome_convenio, INITCAP(a.nome_solicitante) AS nome_solicitante, ('.config('system.userAgilDB').'GET_MNEMONICOS(a.posto,a.atendimento)) mnemonicos,a.saldo_devedor
                FROM '.config('system.userAgilDB').'vex_atendimentos a
                  INNER JOIN '.config('system.userAgilDB').'VEX_MEDICOS m ON a.solicitante = m.crm
                  INNER JOIN '.config('system.userAgilDB').'VEX_CLIENTES c ON a.registro = c.registro
                WHERE c.registro = :registro AND m.ID_MEDICO = :solicitante
                ORDER BY data_atd DESC';

        $atendimentos = DB::select(DB::raw($sql), ['registro' => $registro, 'solicitante' => $solicitante]);

        for ($i = 0; $i < sizeof($atendimentos); ++$i) {
            $atendimentos[$i]->idade = DataNascimento::idade($atendimentos[$i]->data_nas);
            $atendimentos[$i]->data_atd = Formatar::data($atendimentos[$i]->data_atd, 'Y-m-d H:i:s', 'd/m/Y');
        }

        return $atendimentos;
    }

    /**
     * Retorna os postos que o medico tenha atendimento.
     *
     * @param $idMedico
     */
    public function getPostoAtendimento($idMedico, $dataInicio, $dataFim)
    {
        $sql = 'SELECT p.posto, p.nome
                FROM
                  '.config('system.userAgilDB').'vex_medicos M
                  INNER JOIN '.config('system.userAgilDB').'vex_atendimentos A ON M.crm = A.solicitante
                  INNER JOIN '.config('system.userAgilDB')."vex_postos P ON A.posto = p.posto
                WHERE
                  m.id_medico = :idMedico AND A.DATA_ATD BETWEEN TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI') AND TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')
                GROUP BY p.posto,p.nome
                ORDER BY p.nome";

        $data = DB::select(DB::raw($sql), [
            'idMedico' => $idMedico,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        $postos = [];

        foreach ($data as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
    }

    /**
     * Retorna os convenios que o medico tenha atendimento.
     *
     * @param $idMedico
     */
    public function getConvenioAtendimento($idMedico, $dataInicio, $dataFim)
    {
        $sql = 'SELECT c.convenio,c.nome
                FROM
                  '.config('system.userAgilDB').'vex_medicos M
                  INNER JOIN '.config('system.userAgilDB').'vex_atendimentos A ON M.crm = A.solicitante
                  INNER JOIN '.config('system.userAgilDB')."vex_convenios C ON a.convenio = c.convenio
                WHERE
                  m.id_medico = :IdMedico AND A.DATA_ATD BETWEEN TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI') AND TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')
                GROUP BY c.convenio,c.nome
                ORDER BY c.nome";

        $data = DB::select(DB::raw($sql), [
            'idMedico' => $idMedico,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
        ]);

        $convenios = [];

        foreach ($data as $key => $value) {
            $convenios[$value->convenio] = $value->nome;
        }

        array_unshift($convenios, 'Selecione');

        return $convenios;
    }

    /**
     * Verifica se o atendimento passado é do médico.
     *
     * @param $idMedico
     * @param $posto
     * @param $atendimento
     *
     * @return bool
     */
    public function ehAtendimentoMedico($idMedico, $posto, $atendimento)
    {
        $sql = 'SELECT * FROM '.config('system.userAgilDB').'vex_medicos M
                  INNER JOIN '.config('system.userAgilDB').'vex_atendimentos A ON M.crm = A.solicitante
                WHERE
                  m.id_medico = :idMedico
                  AND a.posto = :posto AND a.atendimento = :atendimento';

        $data = DB::select(DB::raw($sql), ['idMedico' => $idMedico, 'posto' => $posto, 'atendimento' => $atendimento]);

        return (bool) sizeof($data);
    }

    public function localizapaciente($idMedico, $nome, $nascimento)
    {
        $sql = "SELECT DISTINCT
                c.nome,TO_CHAR(c.data_nas,'DD/MM/YYYY') as data_nas,c.registro,c.sexo
            FROM
                cedro.VEX_CLIENTES C
                INNER JOIN cedro.VEX_ATENDIMENTOS A ON a.registro = c.registro
                INNER JOIN cedro.VEX_MEDICOS M ON A.solicitante = m.crm
            WHERE 
                C.nome LIKE :nome
                AND M.ID_MEDICO = :idMedico
            ORDER BY c.nome";

        $clientes = DB::select(DB::raw($sql), [
            'nome' => '%'.mb_strtoupper($nome).'%',
            'idMedico' => $idMedico,
            //'nascimento' => $nascimento,
        ]);

        for ($i = 0; $i < sizeof($clientes); ++$i) {
            $key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, config('system.key'), $clientes[$i]->registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
            $id = strtr(rtrim(base64_encode($key), '='), '+/', '-_');

            $clientes[$i]->key = $id;
        }

        return $clientes;
    }
}

