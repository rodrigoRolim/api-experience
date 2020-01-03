<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoramento extends Model {

    protected $connection = 'mysql';

    protected $table = 'monitoramentos';
    
    protected $primaryKey = 'mon_id';

    protected $fillable = [
		'mon_posto',
		'mon_atendimento',
		'mon_correls',
		'mon_error'
    ];
}