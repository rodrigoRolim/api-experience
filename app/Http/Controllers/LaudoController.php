<?php

namespace App\Http\Controllers;

use Experience\Report\Laudo\Cabecalho;

class LaudoController extends Controller{
	public function getIndex()
    {
    	$url = url("/")."/assets/layoutLaudo.xml";
    	$xml = simplexml_load_file($url);

    	$cabecalho = new Cabecalho();
    	$cabecalho->make($xml);

    	echo $cabecalho->render();

    	// dd($xml->bands->band['bandType']);

  //   	if (file_exists($url)){
		//     $xml = ;
		//     print_r($xml);
		// } else {
		//     exit('Falha ao abrir test.xml.');
		// }

    	// echo 'bruno';
    	// exit;
    }
}