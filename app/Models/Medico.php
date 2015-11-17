<?php

/**
 * Classe Model
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Models;

class Medico extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'VEX_MEDICOS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = array('CRM','TIPO_CR','UF_CONSELHO');


}