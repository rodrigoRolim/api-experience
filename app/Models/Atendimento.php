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
    protected $primaryKey = array('POSTO', 'ATENDIMENTO');

    /**
     * Dados do posto do atendimento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posto()
    {
        return $this->belongsTo('App\Models\Posto', 'POSTO','POSTO');
    }

    /**
     * Dados do cliente do atendimento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->hasOne('App\Models\Cliente', 'registro','registro');
    }
}
