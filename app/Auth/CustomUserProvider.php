<?php
namespace App\Auth;

use App\Models\Atendimento;
use App\Models\AtendimentoAcesso;
use App\Repositories\AtendimentoRepository;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class CustomUserProvider implements UserProvider {

    protected $model;

    public function __construct(UserContract $model)
    {
        $this->model = $model;
    }

    public function retrieveById($identifier)
    {
        return new \Exception('-not implemented');
    }

    public function retrieveByToken($identifier, $token)
    {
        $user->set("remember_token",$token);
        $user->save();
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        return new \Exception('not implemented');
    }

    public function retrieveByCredentials(array $credentials)
    {
        $user =  $this->validaUser($credentials);
        $this->user = $user;
        return $user;
    }

    public function validateCredentials(UserContract $user, array $credentials)
    {
        return true;
    }

    protected function validaUser(array $credentials)
    {
        switch($credentials['tipoAcesso']){
            case 'PAC':
                if($credentials['tipoLoginPaciente'] == 'ID'){
                    //CarregaAtendimento
                    $atendimento = new Atendimento();
                    $atendimento = $atendimento->where(['posto' => $credentials['posto'],'atendimento' => $credentials['atendimento']])->get()->toArray();

                    if(sizeof($atendimento)){
                        //Completa do 0 a esquerda do posto e do atendimento de acordo com a configuraçao no config.system
                        $posto = str_pad($atendimento[0]['posto'],config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
                        $atend = str_pad($atendimento[0]['atendimento'],config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

                        $id = strtoupper(md5($posto.$atend));

                        $atendimentoAcesso = new AtendimentoAcesso();
                        $atendimentoAcesso = $atendimentoAcesso->where(['id' => $id])->get()->toArray();

                        if(strtoupper($atendimentoAcesso[0]['pure']) == strtoupper($credentials['password'])){
                            $atributes = array(
                                'id' => 123,
                                'remember_token' => "",
                                'username' => 'chuckles',
                                'password' => 'ddd',
                                'name' => 'Dummy User',
                                'tipoAcesso' => 'PAC',
                                'tipoLoginPaciente' => 'ID',
                                'id' => $id,
                                'username' => $credentials['posto'].'/'.$credentials['atendimento'],
                            );

                            return new GenericUser($atributes);
                        }
                    }
                }
                break;
        }

        return null;
    }
}