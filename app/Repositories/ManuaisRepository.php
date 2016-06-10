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

class ManuaisRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Manuais';
    }

    public function getProcedimentos($input){

      $sql = "SELECT P.MNEMONICO,p.nome as procedimento,s.nome as nome_setor
              FROM ".config('system.userAgilDB')."PROCEDIMENTOS P                  
              INNER JOIN ".config('system.userAgilDB')."SETORES S ON P.SETOR = S.SETOR
              WHERE P.MNEMONICO LIKE(:input) OR p.nome LIKE(:input)";

        $procedimentos = DB::select(DB::raw($sql),[
          'input' => $input
        ]);

        return $procedimentos;
    }

   
}
