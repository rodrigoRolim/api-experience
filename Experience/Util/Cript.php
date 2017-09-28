<?php 

namespace Experience\Util;

class Cript
{
	public static function hash($sStr, $sChave){
		$result = $sStr;
		$iTamanhoString = strlen($sStr);
		$iTamanhoChave  = strlen($sChave);
		     
		for ($i=0; $i < $iTamanhoString; $i++) { 
			$iPos = (($i+1) % $iTamanhoChave);

			if($iPos == 0){
          		$iPos = $iTamanhoChave;
          	}

          	$iPosLetra = (ord($result[$i]) ^ ord($sChave[$iPos-1]));

          	if($iPosLetra == 0){
          		$iPosletra = ord($result[$i]);	
          	}
             
			$result[$i] = chr($iPosLetra);
		}

		return $result;
	}
}