<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicoAcesso extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'MEDICOS_PASS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $fillable = array('id','pure');

    public $timestamps = false;

    public $rules = array(
        'novaSenha' => 'required|min:6|max:15',
    );
}