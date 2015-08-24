<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

class MedicoController extends Controller {
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function getIndex()
    {
        return view('medico.index');
    }
}
