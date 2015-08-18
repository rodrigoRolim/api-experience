<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteAcesso extends Model {

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
    protected $primaryKey = 'ID';
}