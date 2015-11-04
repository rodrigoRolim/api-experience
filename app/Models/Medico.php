<?php namespace App\Models;

class Posto extends BaseModel {

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