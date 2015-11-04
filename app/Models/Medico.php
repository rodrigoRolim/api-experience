<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lis.VEX_MEDICOS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = array('CRM','TIPO_CR','UF_CONSELHO');


}