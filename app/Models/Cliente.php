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
    protected $primaryKey = 'registro';
}