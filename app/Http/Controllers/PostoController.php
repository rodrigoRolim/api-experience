<?php namespace App\Http\Controllers;

use App\Repositories\ConvenioRepository;
use App\Repositories\ExamesRepository;
use App\Repositories\PostoRepository;
use Illuminate\Contracts\Auth\Guard;
//use Vinkla\Hashids\Facades\Hashids;

use Request;

class PostoController extends Controller {

    protected $auth;    
    protected $convenio;
    protected $posto;
    protected $exames;

      public function __construct(
        Guard $auth,        
        ConvenioRepository $convenio,
        PostoRepository $posto,
        ExamesRepository $exames
    )
    {
        $this->auth = $auth;        
        $this->convenio = $convenio;
        $this->posto = $posto;
        $this->exames = $exames;
    }


    public function getIndex()
    {   
        $idPosto = $this->auth->user()['posto'];        
  
        $convenios = $this->posto->getConveniosPosto($idPosto);

        return view('posto.index')->with(
            array(                
                'convenios'=>$convenios,               
            )
        );
        

    }

    public function postFilterclientes(){
        $requestData = Request::all();
        $idPosto = $this->auth->user()['posto']; 

        if($requestData['dataInicio'] != null && $requestData['dataFim'] != null){
            $result = $this->posto->getClientes(
                $idPosto,
                $requestData['dataInicio'],
                $requestData['dataFim'],              
                $requestData['convenio'],
                $requestData['situacao']
            );

            return response()->json(array(
                'message' => 'Recebido com sucesso.',
                'data' => $result,
            ), 200);
        }
    }

   
   
}