<?php

/**
 * Classe de Manuais de Exames
 *
 * @author Bruno Araújo <brunoluan@gmail.com> e Vitor Queiroz <vitorvqz@gmail.com>
 * @version 1.0
 */

namespace App\Http\Controllers;

use App\Repositories\ManuaisRepository;
use Request;

class ManuaisController extends Controller{

	protected $procedimentos;    

    /**
     * Referenciada os repositorio/model utilizados no controlelr
     *
     * @param Guard $auth
     * @param ConvenioRepository $convenio
     * @param PostoRepository $posto
     * @param ExamesRepository $exames
     * @param AtendimentoRepository $atendimento
     * @param DataSnapService $dataSnap
     */
    public function __construct(
        ManuaisRepository $procedimentos        
    )
    {
        $this->procedimentos = $procedimentos;        
    }

	public function getIndex(){
		return view('manuais.index');
	}

	public function getProcedimentos($descricao){
        $descricao = '%'.$descricao.'%';

        $procedimentos = $this->procedimentos->getProcedimentos($descricao);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $procedimentos,
        ), 200);
	}

    public function getPreparo($mnemonico){
        $preparo = $this->procedimentos->getPreparo($mnemonico);

        if($preparo){
            $rtf = rtrim($preparo->preparo);

            $reader = new \App\Services\RtfReader();
            $result = $reader->Parse($rtf);

            $formatter = new \App\Services\RtfHtml();
            
            return response()->json(array(
                'message' => 'Recebido com sucesso',
                'data' => $formatter->Format($reader->root),
            ), 200);
        }
        // $preparo = $this->procedimentos->getPreparo($mnemonico);

        // if($preparo){
        //     $path = public_path().'/assets/temp/';
        //     $file = 'pre.rtf';
        //     $fileConvert = 'pre.html';

        //     $fp = fopen($path.'/'.$file, "a");
        //     $escreve = fwrite($fp, $preparo->preparo);
        //     fclose($fp);

        //     $unoconv = \Unoconv\Unoconv::create();
        //     $unoconv->transcode($path.$file,'html',$path.$fileConvert);

        //     $html = file_get_contents($path.$fileConvert);
            
        //     unlink($path.$file);
        //     unlink($path.$fileConvert);
            
        //     return response()->json(array(
        //         'message' => 'Recebido com sucesso',
        //         'data' => $html,
        //     ), 200);
        // }

        return response()->json(array(
            'message' => 'Exame sem preparo',
            'data' => ''
        ), 200);
    }
}