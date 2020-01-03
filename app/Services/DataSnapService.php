<?php

/**
 * Service Responsavel por comunicar diretamente com o DATASNAP para exportação do PDF
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Services;

use App\Models\Monitoramento;
use Mail;
use DB;

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

		try {
			$result = file_get_contents($url);
			$result = json_decode($result);

			if($result->result[0]->Action != 'actERROR'){
	        	return config('system.PDFUrlTemp').$result->result[0]->Value;
			}
		} catch (\Exception $e) {
			$model = new Monitoramento();

			//Busca Mnemonico pelo correlativo
			$sql = "SELECT MNEMONICO FROM ".config('system.userAgilDB')."VEX_EXAMES WHERE POSTO = :posto AND ATENDIMENTO = :atendimento and CORREL IN(".$correlativos.")";

	        $mnemonicos = DB::select(DB::raw($sql),[
	            'posto' => $posto,
	            'atendimento' => $atendimento,
	        ]);

	        $correlativos .= ' (';
	        
	        foreach ($mnemonicos as $key => $mnemonico) {
	        	$correlativos .= $mnemonico->mnemonico.',';	
	        }

	        $correlativos .= ' )';

			$data = [
				'mon_posto' => $posto,
				'mon_atendimento' => $atendimento,
				'mon_correls' => $correlativos,
				'mon_error' => $e->getMessage()
			];

			$log = $model->create($data);

			/*Mail::send('emails.alerta', ['log' => $log], function ($m) {
	            $m->from(env('EMAIL_ERRO_DATASNAP'), 'Experience - DataSnap')->subject('Problema DataSnap!');
	        });*/

		    //Grava dados
		    return 'false';
		}

		return 'false';
	}
}