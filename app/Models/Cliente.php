<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'CLIENTES';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'REGISTRO';

    /**
     * Todos os atendimentos do Cliente
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function atendimetos(){
        return $this->hasMany('App\Models\Atendimento', 'REGISTRO');
    }
}