<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posto extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lis.VEX_POSTOS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'posto';
}
