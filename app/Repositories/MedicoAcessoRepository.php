<?php

/**
 * Classe reponsável por manipular dados do banco de dados
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

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

    /**
     * Busca rules do model
     * @return mixed
     */
    public function getValidator(){
    	return $this->model->rules;
    }

    /**
     * Altera senha do médico
     * @param $id
     * @param $novaSenha
     * @return bool
     */
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