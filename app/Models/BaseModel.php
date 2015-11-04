<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {
    public function getTable()
    {
        if (isset($this->table)) {
            return \Config::get('system.userAgilDB').$this->table;
        }

        return str_replace('\\', '', Str::snake(Str::plural(class_basename($this))));
    }    
}