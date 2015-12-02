<?php

/**
 * Classe Model
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Models;

class ClienteAcesso extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'CLIENTES_PASS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = array('id','pure');

    public $timestamps = false;

    //Regras de validação
    public $rules = array(
        'novaSenha' => 'required|min:6|max:15',
    );
}