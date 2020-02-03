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
class AmostrasRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Amostra';
    }

    /**
     * Retorna dados da amostra.
     *
     * @return array
     */
    public function getAmostras($posto,$atendimento,$correl)
    {
        $sql = 'SELECT data_cad,data_cole,observacoes FROM '.config('system.userAgilDB').'VEX_AMOSTRAS  
        		WHERE posto = :posto AND atendimento = :atendimento AND correl = :correl';

        $dadosAmostra = DB::select(DB::raw($sql), 
        	['posto' => $posto, 'atendimento' => $atendimento, 'correl' => $correl]);
        
        return $dadosAmostra;
    }
}
