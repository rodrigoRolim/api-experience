<?php namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Exame;
use Illuminate\Support\Facades\View;

class HomeController extends Controller {
    public function index()
    {
        $clientes = Cliente::orderBy('nome','ASC')->get();

        echo '<pre>';
        var_dump($clientes);
        exit;

//        return View::make('home.index')->with('clientes',$clientes);
//
//        $exames = Exame::orderBy('POSTO','ASC')->get();
//
//        dd($exames);
//
//
//        echo sizeof($exames->posto->nome);
//        echo '<br>';
//
//        return View::make('home.index')->with('exames',$exames);
    }
}
