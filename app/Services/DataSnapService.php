<?php

/**
 * Service Responsavel por comunicar diretamente com o DATASNAP para exportação do PDF
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Services;

class DataSnapService
{
	/**
	 * Exporta PDF
	 * @param $posto
	 * @param $atendimento
	 * @param $pure
	 * @param array $correls
	 * @return string
     */
	public static function exportarPdf($posto,$atendimento,$pure,Array $correls,$cabecalho){

		$correlativos = implode(",", $correls['correl']);

		$url = config('system.PDFUrl').$posto.'/'.$atendimento.'/'.$pure.'/'.$correlativos.'/'.$cabecalho;

        $result = @file_get_contents($url);

		if(!$result){
			return 'false';
		}

		$result = json_decode($result);

		if($result->result[0]->Action != 'actERROR'){
        	return config('system.PDFUrlTemp').$result->result[0]->Value;
		}

		return 'false';
	}
}