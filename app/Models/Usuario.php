<?php

/**
 * Classe Model
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Models;

class Usuario extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'vex_usuarios';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'user_codigo';
}
