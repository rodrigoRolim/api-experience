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

	/**
    * Função para formatação de DATA.
    * Ex. formatDate('2013-08-10','Y-m-d','d/m/Y') => 10/08/2013
    */

    public static function data($data,$entrada,$saida)
    {
        if(!is_null($data)){
            $val = \DateTime::createFromFormat($entrada,$data);
            return $val->format($saida);
        }

        return false;
    }
}