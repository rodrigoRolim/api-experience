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
        echo '<pre>';

        $atendimentos = $this->atendimento->all();
        $postos = $this->posto->all()->toArray();

        foreach ($atendimentos as $key => $atendimento){
            //dd($atendimento->getPosto()->get()->toArray()[0]['posto']);
            var_dump($atendimento->getPosto()->first()->toArray()['nome']);
            dd($atendimento->registro);
//            var_dump($atendimento->registro);
//            var_dump($atendimento->getPosto());
            //var_dump($atendimento->get());

            exit;
        }


        echo 'bruno';
//        $clientes = Cliente::;
//        return View::make('home.index');
    }
}
