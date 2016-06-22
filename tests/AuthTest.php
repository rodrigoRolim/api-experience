<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Acessar');
    }
    /**
     * Testa o redirecionamento para a rota /sobre, ao clicar no link com a id #linkSobre em /auth
     *
     * @return void
     */
    public function testLinkSobre()
    {
        $this->visit('/')
             ->click('#linkSobre')
             ->seePageIs('/sobre');
    }
    /**
     * Testa o redirecionamento para o acesso tipo paciente
     * Obs, criar acessos com dados genericos, para que os testes não rezlizados utilizando 
     * dados de postos/pacientes/medicos reais.
     *
     * @return void
     */
    public function testLoginPaciente()
    {
        $this->post('/login', ['tipoAcesso' => 'PAC', 'tipoLoginPaciente' => 'ID', 'atendimento' => '00/001927' ,'password' => 'l1ukhl'])
             ->seePageIs('/paciente');
    }
}
