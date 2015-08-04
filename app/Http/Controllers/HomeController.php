<?php namespace App\Http\Controllers;


use App\Models\Cliente;
use App\Repositories\AtendimentoRepository;
use App\Repositories\PostoRepository;

class HomeController extends Controller {
    protected $posto;
    protected $atendimento;
    protected $cliente;

    public function __construct(PostoRepository $posto,
                                AtendimentoRepository $atendimento,
                                Cliente $cliente)
    {
        $this->posto = $posto;
        $this->atendimento = $atendimento;
        $this->cliente = $cliente;
    }

    public function index()
    {
        //$atendimentos = $this->atendimento->model();

        $atendimentos = $this->atendimento->findWhere(['posto' => 0,'atendimento' => 1715]);

        dd($atendimentos);
        $atendimentos = $atendimentos->all();

        //dd($atendimentos[0]->cliente()->get());

        foreach($atendimentos as $key => $atendimento){
            echo '<b>POSTO:</b> '.$atendimento->posto .'<br>';
            echo '<b>ATEND:</b> '.$atendimento->atendimento .'<br>';
            echo '<b> NOME:</b> '.$atendimento->cliente->nome.'<br><br>';
        }

//        dd($atendimentos->getCliente());
//        $atendimentos = $this->atendimento->all();
//        $postos = $this->posto->all()->toArray();
//
//        foreach ($atendimentos as $key => $atendimento){
//            //dd($atendimento->getPosto()->get()->toArray()[0]['posto']);
//            var_dump($atendimento->getPosto()->first()->toArray()['nome']);
//            dd($atendimento->registro);
////            var_dump($atendimento->registro);
////            var_dump($atendimento->getPosto());
//            //var_dump($atendimento->get());
//
//            exit;
//        }
//
//
//        echo 'bruno';
//        $clientes = Cliente::;
//        return View::make('home.index');
    }
}
