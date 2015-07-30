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
        $postos = $this->posto->all();

        dd($atendimentos);


        foreach ($atendimentos as $key => $atendimento){
            var_dump($atendimento->registro);

            //var_dump($atendimento->get());

            exit;
        }


        echo 'bruno';
//        $clientes = Cliente::;
//        return View::make('home.index');
    }
}
