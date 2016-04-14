<?php

/**
* Classe reponsável pela verificação junto ao banco de dados do login
*
* @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
* @version 1.0
*/

namespace App\Auth;

use App\Models\Atendimento;
use App\Models\AtendimentoAcesso;
use App\Models\Cliente;
use App\Models\ClienteAcesso;
use App\Models\Medico;
use App\Models\MedicoAcesso;
use App\Models\Posto;
use Experience\Util\Formatar;
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
        //Gera token de autenticação
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
        //Envia os dados do credencias para a funcao de verificação
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
        /*
        * De acordo com os tipos de acesso 'PAC = Acesso paciente,MED = Acesso Médico',POS = Acesso posto', 
        * faço as devidas verificação de acordo com suas particularidades
        */

        switch($credentials['tipoAcesso']){
            //Acesso do paciente
            case 'PAC':
            case 'AUTO':
                //Caso o acesso do paciente seja do tipo ID = 'Acesso via cartao do atendimento'
                if($credentials['tipoLoginPaciente'] == 'ID'){
                    $atendimento = new Atendimento();
                    //Verifico no banco de dados de existe o atendimento
                    $atendimento = $atendimento->where(['posto' => $credentials['posto'],'atendimento' => $credentials['atendimento']])->get();
                    //Verifico se a verificação acima retornou algum valor
                    if(sizeof($atendimento)){
                        //Pego os valores do cliente atras do atendimento encontrado
                        $cliente = $atendimento[0]->cliente->toArray();                     
                        $atendimento = $atendimento->toArray();

                        $qtdCaracterPosto = config('system.qtdCaracterPosto');

                        if($atendimento[0]['posto'] < 100){
                            $qtdCaracterPosto = 2;
                        }

                        //Completa do 0 a esquerda do posto e do atendimento de acordo com a configuraçao no config.system
                        $posto = str_pad($atendimento[0]['posto'],$qtdCaracterPosto,'0',STR_PAD_LEFT);
                        $atend = str_pad($atendimento[0]['atendimento'],config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

                        //Para verificação da senha do usuario é necessario criar o ID de verificação com um md5 de posto+atendimento,
                        $id = strtoupper(md5($posto.$atend));
                        //Devido a senha do atendimento esta em outra tabela do banco de dados preciso trazes a senha atraves do ID
                        $atendimentoAcesso = new AtendimentoAcesso();
                        $atendimentoAcesso = $atendimentoAcesso->where(['id' => $id])->get()->toArray();

                        if(!sizeof($atendimentoAcesso)){
                            return null;
                        }

                        //Verifico se a senha eviada pelo formulario é igual a senha enviada pelo formulario
                        if(strtoupper($atendimentoAcesso[0]['pure']) == strtoupper($credentials['password'])){
                            //Caso seja igual preparo os valores para ser enviado para a sessao do usuario

                            //Valores que seram guardados em cache, caso necessite de algo a mais pode ser implementado nesse objeto
                            $atributes = array(
                                'remember_token' => str_random(60),
                                'id' => array(
                                    'tipoAcesso' => 'PAC',
                                    'tipoLoginPaciente' => 'ID',
                                    'nome' => Formatar::nomeCurto($cliente['nome']),
                                    'sexo' => $cliente['sexo'],
                                    'data_nas' => $cliente['data_nas'],
                                    'cpf' => $cliente['cpf'],
                                    'pure' => $atendimentoAcesso[0]['pure'],
                                    'registro' => $cliente['registro'],
                                    'username' => $credentials['posto'].'/'.$credentials['atendimento'],
                                ),
                            );
                            //Cria a sessão do usuario
                            return new GenericUser($atributes);
                        }
                    }
                }

                //Acesso do paciente via CPF
                if($credentials['tipoLoginPaciente'] == 'CPF'){
                    $cliente = new Cliente();

                    $dataNasc = \DateTime::createFromFormat('d/m/Y', $credentials['nascimento']);
                    //Verifico no banco de dados se existe valores para com CPF,NASCIMENTO
                    $cliente = $cliente->where(['cpf' => $credentials['cpf'],'data_nas' => $dataNasc->format('Y-m-d')])->get()->toArray();
                    //Verificar se retornou registro do banco
                    if(sizeof($cliente)){
                        $cliente = $cliente[0];
                        //Para o acesso do cliente é preciso criar um md5 do registro retornado no select acima
                        $registro = $cliente['registro'];
                        $id = strtoupper(md5($registro));

                        //Pego o id gerado e faço a consulta na tablea clienteAcesso para pegar a senha guardada no banco de dados
                        $clienteAcesso = new ClienteAcesso();
                        $clienteAcesso = $clienteAcesso->where(['id' => $id])->get()->toArray();

                        if(!sizeof($clienteAcesso)){
                            return null;
                        }

                        //Caso a senha esteja correta
                        if(strtoupper($clienteAcesso[0]['pure']) == strtoupper($credentials['password'])){
                            //Prepara para pegar o nome e sobrenome para guardar na sessao
                            $arrNome = explode(' ',$cliente['nome']);
                            $nome = ucfirst(mb_strtolower($arrNome[0])).' '.ucfirst(mb_strtolower($arrNome[sizeof($arrNome)-1]));

                            //Valores que seram guardados em cache, caso necessite de algo a mais pode ser implementado nesse objeto
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
                            //Cria a sessao do usuarios
                            return new GenericUser($atributes);
                        }
                    }
                }
                break;
            //Acesso do médico
            case 'MED':
                //Verifica no banco de dados se os valores do login existem
                $medico = new Medico();
                $medico = $medico->where(['TIPO_CR' => $credentials['tipoCr'],'CRM' => $credentials['cr'],'uf_conselho' => $credentials['uf']])->get()->toArray();

                if(sizeof($medico)){
                    //Precisamos criar o ID do medico para verificar sua senha de acesso,
                    //devido alguns medicos nao teram id_medico, tambem é feito uma forma de verificação atraves do crm.
                    //Entao é criado um md5 para o ID e para o CRM
                    $id = strtoupper(md5($medico[0]['id_medico']));
                    $idAlt = strtoupper(md5($medico[0]['crm']));

                    //Faz a verificação do medico via ID_MEDICO
                    $medicoAcesso = new MedicoAcesso();
                    $medicoAcesso = $medicoAcesso->where(['id' => $id])->get()->toArray();


                    if(!sizeof($medicoAcesso)){
                        //Caso não encontre o medico pelo ID_MEDICO é verificado pelo CRM
                        $medicoAcesso = new MedicoAcesso();
                        $medicoAcesso = $medicoAcesso->where(['id' => $idAlt])->get()->toArray();    
                    }

                    if(!sizeof($medicoAcesso)){
                        return null;
                    }

                    //Verifica se a senha informada é a mesma encontrada no banco de dados
                    if(strtoupper($medicoAcesso[0]['pure']) == strtoupper($credentials['password'])){
                        //Prepara o nome e sobrenome do medico para exibição
                        $arrNome = explode(' ',$medico[0]['nome']);
                        $nome = ucfirst(mb_strtolower($arrNome[0])).' '.ucfirst(mb_strtolower($arrNome[sizeof($arrNome)-1]));
                        //Valores que seram guardados em cache, caso necessite de algo a mais pode ser implementado nesse objeto
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
                        //Cria a sessao do usuario
                        return new GenericUser($atributes);
                    }
                }

                break;
            //Acesso do tipo POSTO
            case 'POS';
                $posto = new Posto();
                $posto = $posto->where(['posto' => $credentials['posto']])->get()->toArray();       
                //Verifica se o codigo do posto existe no banco de dados
                if(sizeof($posto)){
                    //Verifica se a senha esta correta
                    if(strtoupper($posto[0]['pass']) == strtoupper($credentials['password'])){
                        //Valores que seram guardados em cache, caso necessite de algo a mais pode ser implementado nesse objeto
                        $atributes = array(
                            'remember_token' => str_random(60),
                            'id' => array(
                                'tipoAcesso' => 'POS',
                                'nome' => $posto[0]['nome'],
                                'posto' => $posto[0]['posto'],
                            ),
                        );
                        //Cria a sessao do usuario
                        return new GenericUser($atributes);
                    }
                }
        }

        return null;
    }
}