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
        return new \Exception('not implemented');
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
                    $atendimento = new Atendimento();
                    $atendimento = $atendimento->where(['posto' => $credentials['posto'],'atendimento' => $credentials['atendimento']])->get()->toArray();

                    $posto = str_pad($atendimento[0]['posto'],config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
                    $atend = str_pad($atendimento[0]['atendimento'],config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

//                    echo 'POSTO: '.$posto.' ATEND: '.$atend;

//                    echo ' '.$posto.$atend.'<br>';
                    echo md5('A11PIT');
                    dd(md5($posto.$atend));
                }
                break;
        }





        dd($credentials);

        if(sizeof($atendimento)){
            dd($atendimento->toArray()[0]);
        }

        exit;

        $attributes = array(
            'id' => 123,
            'remember_token' => "",
            'username' => 'chuckles',
            'password' => \Hash::make('SuperSecret'),
            'name' => 'Dummy User',
       );
       return new GenericUser($attributes);
    }
}