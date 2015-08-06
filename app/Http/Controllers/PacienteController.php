<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

class PacienteController extends Controller {
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getIndex()
    {
        return view('paciente.index');
    }
}
