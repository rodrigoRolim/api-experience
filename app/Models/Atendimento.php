<?php namespace App\Models;

class Atendimento extends BaseModel {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'VEX_ATENDIMENTOS';

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
