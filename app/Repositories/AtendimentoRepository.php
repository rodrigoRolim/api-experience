<?php

/**
* Classe reponsável por manipular dados do banco de dados
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

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

    /**
     * Retorna os atendimentos do usuario paciente (ID ou CPF)
     * @param $user
     * @return array
     */
    public function atendimentos($user)
    {
        $data = $user['username'];
        $data = explode("/",$data);

        if($user['tipoLoginPaciente'] == 'ID'){
            $sql = 'SELECT posto,atendimento,data_atd, INITCAP(nome_convenio) AS nome_convenio, INITCAP(nome_solicitante) AS nome_solicitante, ('.config('system.userAgilDB').'GET_MNEMONICOS(posto,atendimento)) mnemonicos,saldo_devedor
                    FROM '.config('system.userAgilDB').'vex_atendimentos
                    WHERE posto = :posto AND atendimento = :atendimento';

            $atendimento[] = current(DB::select(DB::raw($sql), ['posto' => $data[0],'atendimento' => $data[1]]));

        }

        if($user['tipoLoginPaciente'] == 'CPF'){
            $sql = 'SELECT posto,atendimento,data_atd, INITCAP(nome_convenio) AS nome_convenio, INITCAP(nome_solicitante) AS nome_solicitante, ('.config('system.userAgilDB').'GET_MNEMONICOS(posto,atendimento)) mnemonicos,saldo_devedor
                    FROM '.config('system.userAgilDB').'vex_atendimentos
                    WHERE registro = :registro
                    ORDER BY data_atd DESC';

            $atendimento[] = current(DB::select(DB::raw($sql), ['registro' => $user['registro']]));
        }

        return $atendimento;
    }

    /**
     * Verifica se o atendimento é do paciente, dessa forma só é liberado o acesso,
     * se o atendimento for dele.
     * @param $auth
     * @param $posto
     * @param $atendimento
     * @return bool
     */
    public function ehCliente($auth,$posto,$atendimento){
        $registro = $auth->user()['registro'];
        return (bool) $this->findWhere(['registro' => $registro, 'posto' => $posto, 'atendimento' => $atendimento])->count();
    }

    /**
     * Verifica se o paciente tem saldo devedor com o laboratorio
     * @param $posto
     * @param $atendimento
     * @return bool
     */
    public function getSaldoDevedor($posto,$atendimento){
        $sql = 'SELECT saldo_devedor FROM '.config('system.userAgilDB').'vex_atendimentos WHERE posto = :posto AND atendimento = :atendimento';

        $atendimento = current(DB::select(DB::raw($sql), ['posto' => $posto,'atendimento' => $atendimento]));
        $saldo = $atendimento->saldo_devedor;
        
        return (($saldo > 0) ? true : false);
    }
}