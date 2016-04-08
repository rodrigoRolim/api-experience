<?php

return [
    'key' => env('APP_KEY'),
    'userAgilDB' => env('USER_AGIL_DB', ''),
    'skinPadrao'  => env('APP_SKIN'), 
    'clienteNome' => env('APP_CLIENTE_NOME'),
    'clienteLogo' => env('APP_LOGO'),
    'devLogo'     => '/assets/images/logo.png',
    'experienceLogo' => '/assets/images/icone_experience.png',
    'eXperienceLogoHorizontal' => '/assets/images/logo_experience.png',
    'clienteUrl'  => env('APP_CLIENTE_URL'),
    'PDFUrl'      => env('APP_PDF_URL'),
    'PDFUrlTemp'  => env('APP_PDF_TEMP'),
    'clienteUF'   => env('APP_CLIENTE_UF'),
    'clienteMsg'  => env('APP_CLIENTE_FONE'),
    'acessoMedico' => env('APP_ACESSO_MEDICO'),
    'acessoPosto' => env('APP_ACESSO_POSTO'),
    'acessoPaciente' => env('APP_ACESSO_PACIENTE'),
    'loginText'	  =>  [
    	'title' 		=> 'eXperience',
    	'subTitle' 		=> '<h2 style="color:#76C1CC">Aplicação para visualização de resultados</h2>',
    	'description' 	=> '<p>Solução tecnológica desenvolvida por <a href="www.codemed.com.br" target="_new">Codemed</a></p>',
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
        '' => 'Todos',
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
    ],
    'experience' => [
        'sobre' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
    ]
];