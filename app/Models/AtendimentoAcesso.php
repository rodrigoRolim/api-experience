<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtendimentoAcesso extends Model {
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
