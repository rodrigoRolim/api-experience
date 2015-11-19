<?php

/**
 * Classe Model
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Models;

class AtendimentoAcesso extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'RESULTADOS_PASS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = array('ID');
}
