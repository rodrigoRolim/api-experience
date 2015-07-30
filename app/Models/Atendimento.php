<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ATENDIMENTOS';

    /**
     * The database primary key
     *
     * @var string
     */
//    protected $primaryKey = array('POSTO', 'ATENDIMENTO');

    /**
     * Dados do posto do atendimento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getPosto()
    {
        return $this->belongsTo('App\Models\Posto', 'posto');
    }

    /**
     * Dados do cliente do atendimento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'REGISTRO');
    }
}
