<?php namespace Experience\Util;

use Carbon\Carbon;

class DataNascimento
{
	public static function idade($data){
		$dtNow = Carbon::now();

		$dtOld = Carbon::parse($data);
        $data = $dtNow->diff($dtOld);

        $ano = (int) $data->y;
        $mes = (int) $data->m;
        $dia = (int) $data->d;

        $resultData = '';

        if($ano > 0){
            $resultData .= $ano.' ano'.($ano>1?'s':'').' ';
        }

        if($mes > 0){
            $resultData .= $mes.' mes'.($mes>1?'es':'').' ';
        }

        if($dia > 0){
            $resultData .= $dia.' dia'.($dia>1?'s':'').' ';
        }

        return $resultData;
	}
}