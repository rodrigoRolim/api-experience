<?php

return [
    'key' => env('APP_KEY'),
    'userAgilDB' => env('USER_AGIL_DB', ''),
    'skinPadrao'  => env('APP_SKIN'), 
    'clienteNome' => env('APP_CLIENTE_NOME'),
    'clienteLogo' => env('APP_LOGO'),
    'devLogo'     => '/assets/images/logo_cod.png',
    'experienceLogo' => '/assets/images/icone_experience.png',
    'eXperienceLogoHorizontal' =>  env('APP_LOGO_EXPERIENCE'),
    'clienteUrl'  => env('APP_CLIENTE_URL'),
    'PDFUrl'      => env('APP_PDF_URL'),
    'PDFUrlTemp'  => env('APP_PDF_TEMP'),
    'clienteUF'   => env('APP_CLIENTE_UF'),
    'clienteMsg'  => env('APP_CLIENTE_FONE'),
    'acessoMedico' => env('APP_ACESSO_MEDICO'),
    'acessoPosto' => env('APP_ACESSO_POSTO'),
    'AutoAtendimento' => 'Acesso QR CODE',
    'acessoPaciente' => env('APP_ACESSO_PACIENTE'),
    'acessoAutoAtendimentoTeclado' => env('APP_ACESSO_AUTOATENDIMENTO_TECLADO'),
    'HOSTNAME_AUTOATENDIMENTO' => env('HOSTNAME_AUTOATENDIMENTO'),
    'impressaoTimbrado' => env('CABECALHO'),
    'versao' => env('VERSAO'),
    'loginText'   =>  [
        'title'         => 'eXperience',
        'subTitle'      => '<h2 class="corTituloExperienceAuth">Aplicação para visualização de resultados</h2>',
        'description'   => '<p>Solução tecnológica desenvolvida por <a href="http://www.codemed.com.br" target="_new">Codemed</a></p>',
        'footerText'    => '<strong>Codemed</strong> ©2014-2015',
    ],
    'messages' => [
        'loading' => '<h2 class="textoTamanho" style="padding-top:23vh"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>',
        'loadingExame' => '<h2 class="textoTamanho" style="padding-top:16vh"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns minutos. Aguarde!</small></h1>',
        'loadingExameMobile' => '<h5 style="margin-bottom:10vh;text-align:center"><b><span class="fa fa-refresh iconLoad"></span><br>Carregando registros.</br><small>Esse processo pode levar alguns instantes. Aguarde!</small></h1>',
        'loadingExportPdf' => '<h2 style="margin:0px;margin-top:10px;font-size:18px"><b><span class="fa fa-refresh iconLoad"></b>&nbsp;&nbsp;Exportando Laudo, Aguarde...</h2>',
        'login' => [
            'usuarioSenhaInvalidos'   => 'Credenciais de acesso não conferem',
            'usuarioQrInvalido' => 'Dados do qrcode não localizados em nossa base de dados'
        ],
        'pacientes' => [
            'saldoDevedor' => 'Existe pendência, diriga-se ao laboratório',
        ],
        'dataSnap' => [
            'ErroExportar' => 'Problemas ao exportar o seus resultados, tente mais tarde.',
        ],
        'paciente' => [
            'msgCpfAcesso' => 'Solicite sua senha de acesso no laboratório',
        ],
        'exame' => [
            'tipoEntregaInvalido' => 'Este exame só poderá ser impresso no laboratório.'
        ],
        'amostras' => [
            'descricao' => 'Resultado obtido através de uma nova amostra.'
        ],
    ],
    'qtdCaracterPosto' => env('APP_QTD_CHAR_POSTO'),
    'qtdCaracterAtend' => env('APP_QTD_CHAR_ATD'),
    'atendimentoMask'  => env('APP_ATD_MASK'),
    'postoMask'        => env('APP_POSTO_MASK'),
    'atdMaskZeros'     => env('APP_QTD_ZEROS_ATD'),
    'postoMaskZeros'   => env('APP_QTD_ZEROS_POSTO'),
    'selectFiltroSituacaoAtendimento' => [
        '' => 'Todos',
        'TF' => 'Finalizados',
        'PF' => 'Parcialmente Finalizado',
        'EP' => 'Existêm pendências',
        'EA' => 'Em Andamento',
        'NR' => 'Não Realizados'
    ],
    'medico' => [
        'qtdDiasFiltro' => env('APP_MEDICO_QTD_DIAS')
    ],
    'posto' => [
        'qtdDiasFiltro' => env('APP_POSTO_QTD_DIAS')
    ],
    'experience' => [
        'sobre' => '<p> O <b>eXperience</b> é uma ferramenta que fornece a você, de forma objetiva e bastante simples, a possibilidade de verificar os resultados dos exames de seus clientes em qualquer lugar, a qualquer hora, acompanhando o andamento de suas análises.</p><p>Evite custos desnecessários. Esta é a mais nova proposta que temos para você</p>'
    ]
];
