<?php

/**
 * Essa classe foi criada para resolver problemas do usuario de criação das tabelas no oracle,
 * essa classe complementa o nome da tabela com um sufixo pre-definido no config.system
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    /**
     * @return mixed|string
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return \Config::get('system.userAgilDB').'.'.$this->table;
        }

        return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }    
}