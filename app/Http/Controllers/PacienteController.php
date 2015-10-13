<?php namespace App\Http\Controllers;

use App\Repositories\AtendimentoRepository;
use App\Models\AtendimentoAcesso;
use App\Repositories\ExamesRepository;
use Illuminate\Contracts\Auth\Guard;

use Request;
use Redirect;




class PacienteController extends Controller {
    protected $auth;
    protected $atendimento;
    protected $exames;

    public function __construct(Guard $auth, AtendimentoRepository $atendimento, ExamesRepository $exames)
    {
        $this->auth = $auth;
        $this->atendimento = $atendimento;
        $this->exames = $exames;
    }

    public function getIndex()
    {
        $tipoLoginPaciente = $this->auth->user()['tipoLoginPaciente'];
        $atendimentos = $this->atendimento->atendimentos($this->auth->user());

        return view('paciente.index',compact('atendimentos','tipoLoginPaciente'));
    }

    public function getExamesatendimento($posto,$atendimento){
        $ehCliente = $this->atendimento->ehCliente($this->auth,$posto,$atendimento);

        if(!$ehCliente){
            \App::abort(404);
        }

        $exames = $this->exames->getExames($posto, $atendimento);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => $exames,
        ), 200);
    }

    public function getDetalheatendimentoexamecorrel($posto,$atendimento,$correl){        

        $saldoDevedor = $this->atendimento->getSaldoDevedor($posto,$atendimento);

        if($saldoDevedor){
            return response()->json(array(
                'message' => 'Existe pendências'
            ), 203);
        }

        $exames = $this->exames->getDetalheAtendimentoExameCorrel($posto, $atendimento,$correl);

        return response()->json(array(
            'message' => 'Recebido com sucesso.',
            'data' => json_decode($exames),
        ), 200);
    }

    public function postExportarpdf(){    

        $dados = Request::input('dados');
        $posto = $dados[0]['posto'];
        $atendimento = $dados[0]['atendimento'];
        $correlativos = $dados[0]['correlativos'];    
        
        $postoID = str_pad($posto,config('system.qtdCaracterPosto'),'0',STR_PAD_LEFT);
        $atendimentoID = str_pad($atendimento,config('system.qtdCaracterAtend'),'0',STR_PAD_LEFT);

        $id = strtoupper(md5($postoID.$atendimentoID));

        $atendimentoAcesso = new AtendimentoAcesso();
        $atendimentoAcesso = $atendimentoAcesso->where(['id' => $id])->get()->toArray();

        $pure = $atendimentoAcesso[0]['pure'];            

        $json = file_get_contents('http://192.168.0.3:8084/datasnap/rest/TsmExperience/getLaudoPDF/'.$posto.'/'.$atendimento.'/'.$pure.'/');
        
        $responsePdf = json_decode($json);

        $arquivoPdf = $responsePdf->result[0]->Value;

        $caminhoPdf = 'http://192.168.0.3:8083/TempPDF/'.$arquivoPdf;

        return $caminhoPdf;

    }
}
