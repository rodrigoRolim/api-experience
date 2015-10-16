<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use DB;

class ClienteAcessoRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\ClienteAcesso';
    }
    
    public function getValidator(){
    	return $this->model->rules;
    }

    public function alterarSenha($registro,$novaSenha){
        try {
            DB::connection()->getPdo()->beginTransaction();

            $acesso = $this->find($registro);

            $acessoData = ['pure' => strtoupper($novaSenha)];

            $result = $this->update($acessoData,$registro,'id');

            DB::connection()->getPdo()->commit();
        } catch(Exception $e) {
            DB::connection()->getPdo()->rollBack();
            return false;
        }

        return true;
    }
}