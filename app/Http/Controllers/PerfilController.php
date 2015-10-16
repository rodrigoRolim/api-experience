<?php namespace App\Http\Controllers;

use App\Repositories\AtendimentoRepository;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Validator;


class PerfilController extends Controller {

    protected $auth;
    protected $atendimento;

    public function __construct(Guard $auth, AtendimentoRepository $atendimento)
    {
        $this->auth = $auth;
        $this->atendimento = $atendimento;
    }

       public function updateSenhaCliente($id,$senha)
    {
        $validator = Validator::make(Request::all(), $this->contato->getValidator());
        if ($validator->fails()) {
            return response(['message'=>'Erro ao validar.'],400);
        }

        $contato = $this->contato->find($idContato);

        if(!$contato){
            return response(['message'=>'Contato não existe.'],404);
        }

        $result = $this->contato->atualizar(Request::all());

        if(!$result){
            return response(['message' => 'Erro interno ao salvar.'],500);
        }

        return response(['message' => 'Atualizado com sucesso.', 'data' => $result],200);
    }

    
}
