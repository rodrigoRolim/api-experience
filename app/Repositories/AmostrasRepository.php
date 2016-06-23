<?php

/**
 * Classe reponsável por manipular dados do banco de dados
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

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
}
