<?php
namespace App\Auth;

use App\Models\Atendimento;
use App\Models\AtendimentoAcesso;
use App\Models\Cliente;
use App\Models\ClienteAcesso;
use App\Models\Medico;
use App\Models\MedicoAcesso;
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
        return $identifier;
    }

    public function retrieveByToken($identifier, $token)
    {
        $user->set("remember_token",$token);
        $user->save();
    }

    public function updateRememberToken(UserContract $user, $token)
    {
        $user->set("remember_token",$token);
        $user->save();
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
                //Acesso via Atendimento
                if($credentials['tipoLoginPaciente'] == 'ID'){
                    //CarregaAtendimento
                    $atendimento = new Atendimento();
                    $atendimento = $atendimento->where(['posto' => $credentials['posto'],'atendimento' => $credentials['atendimento']])->get();

                    if(sizeof($atendimento)){

                        $cliente = $atendimento[0]->cliente->toArray();
                        $atendimento = $atendimento->toArray();

                        //Completa do 0 a esquerda do posto e do atendimento de acordo com a configuraçao no config.system
                        $posto = str_pad($atendimento[0]['posto'],config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
                        $atend = str_pad($atendimento[0]['atendimento'],config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

                        $id = strtoupper(md5($posto.$atend));

                        $atendimentoAcesso = new AtendimentoAcesso();
                        $atendimentoAcesso = $atendimentoAcesso->where(['id' => $id])->get()->toArray();

                        if(strtoupper($atendimentoAcesso[0]['pure']) == strtoupper($credentials['password'])){
                            $arrNome = explode(' ',$cliente['nome']);
                            $nome = ucfirst(md_strtolower($arrNome[0])).' '.ucfirst(md_strtolower($arrNome[sizeof($arrNome)-1]));

                            $atributes = array(
                                'remember_token' => str_random(60),
                                'id' => array(
                                    'tipoAcesso' => 'PAC',
                                    'tipoLoginPaciente' => 'ID',
                                    'nome' => $nome,
                                    'sexo' => $cliente['sexo'],
                                    'data_nas' => $cliente['data_nas'],
                                    'registro' => $cliente['registro'],
                                    'username' => $credentials['posto'].'/'.$credentials['atendimento'],
                                ),
                            );

                            return new GenericUser($atributes);
                        }
                    }
                }

                //Acesso via CPF
                if($credentials['tipoLoginPaciente'] == 'CPF'){
                    $cliente = new Cliente();

                    $dataNasc = \DateTime::createFromFormat('d/m/Y', $credentials['nascimento']);

                    $cliente = $cliente->where(['cpf' => $credentials['cpf'],'data_nas' => $dataNasc->format('Y-m-d')])->get()->toArray();

                    if(sizeof($cliente)){
                        $cliente = $cliente[0];

                        $registro = $cliente['registro'];
                        $id = strtoupper(md5($registro));

                        $clienteAcesso = new ClienteAcesso();
                        $clienteAcesso = $clienteAcesso->where(['id' => $id])->get()->toArray();

                        if(strtoupper($clienteAcesso[0]['pure']) == strtoupper($credentials['password'])){
                            $arrNome = explode(' ',$cliente['nome']);
                            $nome = ucfirst(mb_strtolower($arrNome[0])).' '.ucfirst(mb_strtolower($arrNome[sizeof($arrNome)-1]));

                            $atributes = array(
                                'remember_token' => str_random(60),
                                'id' => array(
                                    'tipoAcesso' => 'PAC',
                                    'tipoLoginPaciente' => 'CPF',
                                    'nome' => $nome,
                                    'sexo' => $cliente['sexo'],
                                    'data_nas' => $cliente['data_nas'],
                                    'registro' => $cliente['registro'],
                                    'username' => $cliente['cpf'],
                                ),
                            );

                            return new GenericUser($atributes);
                        }
                    }
                }
                break;
            case 'MED':
                $medico = new Medico();
                $medico = $medico->where(['TIPO_CR' => $credentials['tipoCr'],'CRM' => $credentials['cr'],'uf_conselho' => $credentials['uf']])->get()->toArray();

                if(sizeof($medico)){
                    $id = strtoupper(md5($medico[0]['id_medico']));

                    $medicoAcesso = new MedicoAcesso();
                    $medicoAcesso = $medicoAcesso->where(['id' => $id])->get()->toArray();

                    if(strtoupper($medicoAcesso[0]['pure']) == strtoupper($credentials['password'])){
                        $arrNome = explode(' ',$medico[0]['nome']);
                        $nome = ucfirst(mb_strtolower($arrNome[0])).' '.ucfirst(mb_strtolower($arrNome[sizeof($arrNome)-1]));

                        $atributes = array(
                            'remember_token' => str_random(60),
                            'id' => array(
                                'tipoAcesso' => 'MED',
                                'nome' => $nome,
                                'data_nas' => $medico[0]['data_nas'],
                                'tipo_cr' => $medico[0]['tipo_cr'],
                                'uf_conselho' => $medico[0]['uf_conselho'],
                                'crm' => $medico[0]['crm'],
                                'id_medico' => $medico[0]['id_medico'],
                                'username' => $medico[0]['cpf'],
                            ),
                        );

                        return new GenericUser($atributes);
                    }
                }

                break;
        }

        return null;
    }
}