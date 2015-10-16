<?php 

namespace App\Services;

class DataSnapService
{
	public static function exportarPdf($posto,$atendimento,$pure,Array $correls){
        $result = file_get_contents(config('system.PDFUrl').$posto.'/'.$atendimento.'/'.$pure.'/'.implode(",",$correls));
		$result = json_decode($result);

        return config('system.PDFUrlTemp').$result->result[0]->Value;
	}
}