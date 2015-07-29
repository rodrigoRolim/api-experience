<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exame extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'EXAMES';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'REGISTRO';
}
