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
        
        Session::start();

        $credentials = array(
            'tipoAcesso' => 'PAC',
            'tipoLoginPaciente' => 'ID',
            'atendimento' => '00/001927',
            'password' => 'l1ukhl',
            '_token' => csrf_token()
        );

        $response = $this->call('POST', '/auth/login', $credentials);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertRedirectedTo('/auth/home');
        

    }
}
