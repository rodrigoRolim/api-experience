<?php

namespace Experience\Util;

class Formatar{
	public static function nomeCurto($nome)
	{
		$arrNome = explode(' ',$nome);

		if(sizeof($arrNome) == 1){
			return ucfirst(mb_strtolower($nome));
		}

		return $nome = ucfirst(mb_strtolower($arrNome[0])).' '.ucfirst(mb_strtolower($arrNome[sizeof($arrNome)-1]));
	}
}