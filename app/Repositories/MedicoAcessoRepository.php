<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

use DB;

class MedicoAcessoRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'App\Models\MedicoAcesso';
    }
    
    public function getValidator(){
    	return $this->model->rules;
    }

    public function alterarSenha($id,$novaSenha){
        try {
            DB::connection()->getPdo()->beginTransaction();

            $acesso = $this->find($id);

            $acessoData = ['pure' => strtoupper($novaSenha)];

            $result = $this->update($acessoData,$id,'id');

            DB::connection()->getPdo()->commit();
        } catch(Exception $e) {
            DB::connection()->getPdo()->rollBack();
            return false;
        }

        return true;
    }
}