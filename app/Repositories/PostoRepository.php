<?php

/**
 * Classe reponsável por manipular dados do banco de dados
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Experience\Util\DataNascimento;
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

    /**
     * Função responsavel por listar todos os atendimentos do posto de acordo com o filtro
     * @param $idPosto
     * @param $dataInicio
     * @param $dataFim
     * @param null $convenio
     * @param null $situacao
     * @param null $postoRealizante
     * @return array
     */
    public function getAtendimentos($idPosto,$dataInicio,$dataFim, $convenio=null,$situacao=null,$postoRealizante=null)
    {
        $sql = "SELECT DISTINCT
                   a.situacao_exames_experience, a.posto, a.atendimento,a.data_atd,a.nome_convenio, c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2, ".config('system.userAgilDB')."get_mnemonicos(a.posto, a.atendimento) as mnemonicos
                FROM
                  ".config('system.userAgilDB')."VEX_ATENDIMENTOS A                  
                  INNER JOIN ".config('system.userAgilDB')."VEX_CLIENTES C ON a.registro = c.registro
                  INNER JOIN ".config('system.userAgilDB')."VEX_EXAMES E ON a.posto = e.posto AND a.atendimento = e.atendimento
                WHERE a.posto = :idPosto
                    AND A.DATA_ATD >= TO_DATE(:dataInicio,'DD/MM/YYYY HH24:MI')
                    AND A.DATA_ATD <= TO_DATE(:dataFim,'DD/MM/YYYY HH24:MI')                   
                    AND (:convenio IS NULL OR A.CONVENIO = :convenio)
                    AND (:situacao IS NULL OR A.SITUACAO_EXAMES_EXPERIENCE = :situacao)
                    AND (:postoRealizante IS NULL OR E.posto_realizante = :postoRealizante)
                ORDER BY c.nome";       

        $clientes[] = current(DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
            'dataInicio' => $dataInicio.' 00:00',
            'dataFim' => $dataFim.' 23:59',            
            'convenio' => $convenio,
            'situacao' => $situacao,
            'postoRealizante' => $postoRealizante
        ]));

        $dtNow = Carbon::now();

        for($i=0;$i<sizeof($clientes);$i++){
            $clientes[$i]->idade = DataNascimento::idade($clientes[$i]->data_nas);

            $key = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, config('system.key'), $clientes[$i]->registro, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
            $id = strtr(rtrim(base64_encode($key), '='), '+/', '-_');

            $clientes[$i]->key = $id;
        }

        return $clientes;
    }


    /**
     * Função responsavel por retornar todos os postos realizantes do posto logado
     * @return mixed
     */
    public function getPostosRealizantes()
    {
        $sql = 'SELECT posto,nome FROM '.config('system.userAgilDB').'VEX_POSTOS WHERE realiza_exames = :tipo order by nome';
        $data [] = current(DB::select(DB::raw($sql),[
            'tipo' => 'S'
        ]));

        $postos[''] = 'Selecione';

        foreach ($data as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }
        return $postos;
    }

    /**
     * Retorna todo os postos realizante do atendimento
     * @param $posto
     * @param $atendimento
     * @return mixed
     */
    public function getPostosRealizantesAtendimento($posto,$atendimento)
    {
        $sql = 'SELECT DISTINCT p.posto,p.nome 
                FROM '.config('system.userAgilDB').'VEX_POSTOS p
                  INNER JOIN '.config('system.userAgilDB').'VEX_EXAMES e ON e.posto_realizante = p.posto
                WHERE p.realiza_exames = :tipo AND e.posto = :posto AND e.atendimento = :atendimento
                ORDER BY p.nome';
        
        $data [] = current(DB::select(DB::raw($sql),[
            'tipo' => 'S',
            'posto' => $posto,
            'atendimento' => $atendimento
        ]));

        foreach ($data as $key => $value) {
            $postos[$value->posto] = $value->nome;
        }

        return $postos;
    }

    /**
     * Retorna todos os convenios para o posto
     * @param $idPosto
     * @return array
     */
    public function getConveniosPosto($idPosto)
    {
        $sql = 'SELECT
			     	DISTINCT convenio, nome_convenio
			  	FROM '.config('system.userAgilDB').'vex_atendimentos
			  	WHERE
			    	posto = :idPosto
			    ORDER BY
			    	nome_convenio';

        $data[] = current(DB::select(DB::raw($sql),[
            'idPosto' => $idPosto,
        ]));

        $convenios = array(''=>'Selecione ');       

	   foreach ($data as $key => $value) {
            $convenios[$value->convenio] = $value->nome_convenio;
        }       

        return $convenios;
    }

    /**
     * Função responsavel por retornar todos os atendimentos do paciente do posto
     * @param $registro
     * @param $idPosto
     * @param $idAtendimento
     * @return mixed
     */
    public function getAtendimentosPacienteByPosto($registro,$idPosto,$idAtendimento){

        $sql = 'SELECT c.nome,c.data_nas,c.registro,c.sexo,c.telefone,c.telefone2,a.posto,a.atendimento,data_atd, INITCAP(a.nome_convenio) AS nome_convenio, INITCAP(a.nome_solicitante) AS nome_solicitante, ('.config('system.userAgilDB').'GET_MNEMONICOS(a.posto,a.atendimento)) mnemonicos,a.saldo_devedor
            FROM '.config('system.userAgilDB').'vex_atendimentos a              
              INNER JOIN '.config('system.userAgilDB').'VEX_CLIENTES c ON a.registro = c.registro
            WHERE c.registro = :registro 
            AND posto = :idPosto 
            AND a.atendimento = :idAtendimento
            ORDER BY data_atd DESC';

        $atendimento[] = current(DB::select(DB::raw($sql), ['registro' => $registro, 'idPosto' => $idPosto, 'idAtendimento' => $idAtendimento]));
        $atendimento = current($atendimento);

        $atendimento->idade = DataNascimento::idade($atendimento->data_nas);

        return $atendimento;
    }

    /**
     * Verifica se o atendimento é do posto
     * @param $idPosto
     * @param $atendimento
     * @return bool
     */
    public function ehAtendimentoPosto($idPosto,$atendimento){
        $sql = 'SELECT * FROM '.config('system.userAgilDB').'vex_atendimentos a                 
                WHERE
                  posto = :idPosto
                AND a.atendimento = :atendimento';

        $data = DB::select(DB::raw($sql),['idPosto'=>$idPosto,'atendimento'=>$atendimento]);
        return (bool) sizeof($data);
    }
}
