<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoAcesso extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'MEDICOS_PASS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'ID';
}