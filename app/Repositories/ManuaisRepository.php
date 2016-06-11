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

  public function getProcedimentos($descricao){
    $sql = "SELECT DISTINCT MNEMONICO as mnemonico, NOME as procedimento, NOME_SETOR as nome_setor, tipo_coleta, NOME_MATERIAL as material
            FROM ".config('system.userAgilDB')."VEX_PROCEDIMENTOS
            WHERE MNEMONICO LIKE(:input) OR NOME LIKE(:input)";

    $procedimentos = DB::select(DB::raw($sql),[
      'input' => $descricao
    ]);

    return $procedimentos;
  }

  public function getPreparo($mnemonico){
    $mnemonico = mb_strtoupper($mnemonico);

    $sql = "SELECT DISTINCT *
            FROM ".config('system.userAgilDB')."VEX_PREPAROS
            WHERE MNEMONICO = :mnemonico";

    $preparo = DB::select(DB::raw($sql),[
      'mnemonico' => $mnemonico
    ]);

    return current($preparo);
  }
}
