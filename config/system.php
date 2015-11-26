<?php

return [
    'key' => env('APP_KEY'),
    'userAgilDB' => env('USER_AGIL_DB', ''),
    'skinPadrao'  => env('APP_SKIN'), 
    'clienteNome' => env('APP_CLIENTE_NOME'),
    'clienteLogo' => env('APP_LOGO'),
    'experienceLogo' => '/assets/images/icone_experience.png',
    'clienteUrl'  => env('APP_CLIENTE_URL'),
    'PDFUrl'      => env('APP_PDF_URL'),
    'PDFUrlTemp'  => env('APP_PDF_TEMP'),
    'clienteUF'   => env('APP_CLIENTE_UF'),
    'clienteMsg'  => env('APP_CLIENTE_FONE'),
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
    'qtdCaracterPosto' => env('APP_QTD_CHAR_POSTO'),
    'qtdCaracterAtend' => env('APP_QTD_CHAR_ATD'),
    'atendimentoMask'  => env('APP_ATD_MASK'),
    'postoMask'        => env('APP_POSTO_MASK'),
    'selectFiltroSituacaoAtendimento' => [
        '' => 'Selecione',
        'TF' => 'Finalizados',
        'PF' => 'Parcialmente Finalizado',
        'EP' => 'Existêm pendências',
        'EA' => 'Em Andamento',
    ],
    'medico' => [
        'qtdDiasFiltro' => env('APP_MEDICO_QTD_DIAS')
    ],
    'posto' => [
        'qtdDiasFiltro' => env('APP_POSTO_QTD_DIAS')
    ]
];