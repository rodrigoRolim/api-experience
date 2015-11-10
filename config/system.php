<?php

return [
    'key' => 'DHXR|e4H>Q38ZjERT"4L+7~|^P0W_j',
    'userAgilDB' => 'lis.',
    'skinPadrao'  => 'green.css', 
    'clienteNome' => 'Lab. Teste',
    'clienteLogo' => '/assets/images/logo_cedro.png',
    'experienceLogo' => '/assets/images/icone_experience.png',
    'clienteUrl'  => 'http://www.cliente.com',
    'PDFUrl'      => 'http://192.168.0.3:8084/datasnap/rest/TsmExperience/getLaudoPDF/',
    'PDFUrlTemp'  => 'http://192.168.0.3:8083/TempPDF/',
    'clienteUF'   => 'MA',
    'clienteMsg'  => 'Fone: 98 9988 8798',

    'loginText'	  =>  [
    	'title' 		=> 'eXperience',
    	'subTitle' 		=> '<br><br>is provided with two main layouts <br>three skins and separate configure options.',
    	'description' 	=> '<p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.</p><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s.</p>',
    	'footerText'	=> '<strong>Codemed</strong> ©2014-2015',
    ],
    'messages' => [
        'login' => [
            'usuarioSenhaInvalidos'   => 'Credenciais de acesso não confere',
        ],
        'pacientes' => [
            'saldoDevedor' => 'Existe pendência, diriga-se ao laboratório',
        ],
        'paciente' => [
            'msgCpfAcesso' => 'Solicite sua senha de acesso no laboratório',
        ],
        'exame' => [
            'tipoEntregaInvalido' => 'Este exame só poderá ser impresso no laboratório.'
        ],
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
    ],
    'medico' => [
        'qtdDiasFiltro' => 7
    ],
    'posto' => [
        'qtdDiasFiltro' => 60
    ]
];
