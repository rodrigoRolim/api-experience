<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ClienteRepository extends Repository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\Cliente';
    }
}
