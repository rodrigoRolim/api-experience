<?php

return [
    'clienteNome' => 'Lab. Teste',
    'clienteLogo' => '/assets/img/logo.png',
    'clienteUrl'  => 'http://www.cliente.com',
    'clienteUF'   => 'MA',
    'clienteMsg'  => 'Fone: 98 9988 8798',
    'loginText'	  =>  [
    	'title' 		=> 'INSPINIA - Responsive Admin Theme',
    	'subTitle' 		=> '<br><br>is provided with two main layouts <br>three skins and separate configure options.',
    	'description' 	=> '<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.</p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
    	'footerText'	=> '<strong>Copyright</strong> Codemed ©2014-2015',
    ],
    'messages' => [
        'login' => [
            'usuarioSenhaInvalidos'   => 'Credenciais de acesso não confere',
        ],
        'paciente' => [
            'saldoDevedor' => 'Existe pendência, diriga-se ao laboratório',
        ]
    ],
    'qtdCaracterPosto' => 2,
    'qtdCaracterAtend' => 6,
    'atendimentoMask'  => '99/999999',
    'postoMask'        => '99',
    'selectFiltroSituacaoAtendimento' => [
        '' => 'Selecione',
        'TF' => 'Finalizados',
        'PF' => 'Parcialmente Finalizado',
        'EP' => 'Existêm pendências',
        'EA' => 'Em Andamento',
    ]
];
