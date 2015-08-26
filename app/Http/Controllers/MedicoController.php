<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\MedicoRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;

class MedicoController extends Controller {
    protected $auth;
    protected $medico;
    protected $convenio;
    protected $posto;

    public function __construct(
        Guard $auth,
        MedicoRepository $medico,
        ConvenioRepository $convenio,
        PostoRepository $posto
    )
    {
        $this->auth = $auth;
        $this->medico = $medico;
        $this->convenio = $convenio;
        $this->posto = $posto;
    }

    public function getIndex()
    {
        $postos = $this->posto->all()->lists('nome', 'posto');
        $convenios = $this->convenio->all()->lists('nome', 'convenio');

        //$idMedico = $this->auth->user()['id_medico'];
        //dd($this->medico->getClientes($idMedico,'15/08/2015','26/08/2015'));

        return view('medico.index')->with(array('postos'=>$postos,'convenios'=>$convenios));
    }
}
