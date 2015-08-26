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
        $idMedico = $this->auth->user()['id_medico'];

        $postos = $this->medico->getPostoAtendimento($idMedico);
        $convenios = $this->medico->getConvenioAtendimento($idMedico);

        return view('medico.index')->with(
            array(
                'postos'=>$postos,
                'convenios'=>$convenios,
            )
        );
    }
}
