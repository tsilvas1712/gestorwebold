<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use App\Http\Controllers\Soap\SoapCalcardController;
use App\Models\Workgroup;
use App\Models\Debtor;
use DB;

class History extends Model
{
    protected $table = 'Ocorrencia';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getHistories($id){
        $workgroup = new Workgroup();
        $workgroups = $workgroup->getWorkgroupsByComissioned();

        $strDebtors = objectToStrIn($workgroups, 'Cd_GrupoTrabalho');

        $histories = DB::select("
                    select top 50 cre.Ds_Credor, oco.Dt_Ocorrencia, com.Ds_Comissionado, oco.Cd_DDD, oco.Cd_Telefone, 
                           his.Ds_Historico, oco.MM_Texto, IsNull(his.FL_Positivo,0) FL_Positivo, IsNull(Fl_TipoHistorico, 'M') Fl_TipoHistorico
                    from Ocorrencia oco (nolock) join Credor cre (nolock)
                            on oco.Cd_Credor = cre.Cd_Credor
                        join Comissionado com (nolock)
                            on oco.Cd_Negociador = com.Cd_Comissionado
                        join Historico his (nolock)
                            on oco.Cd_Historico = his.Cd_Historico
                    where oco.Cd_Devedor = :id
                    and cre.Cd_GrupoTrabalho in ({$strDebtors})
                    and cre.Cd_Situacao = 0
                    Order by oco.Dt_Ocorrencia Desc", ['id' => $id]);
        
        $histories = convert_from_latin1_to_utf8_recursively($histories);

        return $histories;
    }

    private function checkExportHistory($dataForm){
        $creditorId = $dataForm['history-cdCredor'];

        switch ($creditorId) {
            //> Calcard
            case '5291':
                return $this->exportHistoryCalcard($dataForm);
                break;
            default:
                return 1;
                break;
        }
    }
    
    private function checkExportDialer($dataForm){
        $dialerId = Session::get('dialerId');
        if ($dialerId != ''){
            return $this->exportDialer($dataForm);
        }
    }

    private function exportDialer($dataForm){
        $Dt_Contato = $dataForm['history-dtAgenda'];
        $Dt_Contato =  str_replace('-', '', $Dt_Contato) . '000000';
        $endpoint = config('app.izzycall.endpoint');
        $dialerUserId = \User::getDialerUserId();

        $client = new \GuzzleHttp\Client();
        $response = $client->post($endpoint.'update', 
                        [ \GuzzleHttp\RequestOptions::JSON => 
                            [
                                'user_id' => $dialerUserId,
                                'job_id' => Session::get('dialerId'),
                                'scheduling_id' => $dataForm['history-cdHistorico'],
                                'scheduling_date' => '&scheduling_date',
				                'debtor_id' => $dataForm['history-cdDevedor']
                            ]
                        ]
                    );

        if ($response->getStatusCode() == 200){
            return true;
        }

        return false;
    }

    private function exportHistoryCalcard($dataForm){
        $debtorId = $dataForm['history-cdDevedor'];
        $creditorId = $dataForm['history-cdCredor'];
        $historyId = $dataForm['history-cdHistorico'];
        $historyText = $dataForm['history-dsHistorico'];
        $areaCode = Session::get('Cd_ddd');
        $phoneNumber = Session::get('Cd_Telefone');
        if ($areaCode == '') {
            $areaCode = '0';
        }

        if ($phoneNumber == '') {
            $phoneNumber = '0';
        }

        $historyExternalId = $this->getExternalId($historyId, $creditorId);

        if ( ($historyExternalId != '') && ($historyExternalId != '0') ){
            $debtor = new Debtor();
            $debtorExternalId = $debtor->getExternalId($debtorId, $creditorId);
    
            $soap = new SoapCalcardController();
            if ( ($historyExternalId == '21') || ($historyExternalId == '43') ) {

                $payDate = $dataForm['history-dtAgenda'];        
                $payDate =  str_replace('-', '', $payDate);

                $response = $soap->inserirAcaoComDetalhe($debtorExternalId, $historyExternalId, $historyText, $areaCode, $phoneNumber, $payDate);
            }else{
                $response = $soap->inserirAcao($debtorExternalId, $historyExternalId, $historyText, $areaCode, $phoneNumber);
            }
            return $response;
        }

        return 1;
    }

    private function getExternalId($historyId, $creditorId){
        $history = DB::select("
                            select Cd_HCredor
                            from HistoricoCredor (nolock)
                            where cd_Historico = :historyId
                            and Cd_Credor = :creditorId",
                            ['historyId' => $historyId, 'creditorId' => $creditorId]);
        
        if ($history) return trim($history[0]->Cd_HCredor);

        return '';
    }

    public function storeHistory($dataForm){
        $this->checkExportHistory($dataForm);
        $this->checkExportDialer($dataForm);

        $Cd_ddd = Session::get('Cd_ddd');
        $Cd_Telefone = Session::get('Cd_Telefone');
        $Dt_Contato = $dataForm['history-dtAgenda'];

        if ($Cd_ddd == '') {
            $Cd_ddd = '0';
        }

        if ($Cd_Telefone == '') {
            $Cd_Telefone = '0';
        }

        $Dt_Contato =  str_replace('-', '', $Dt_Contato);


        /*Fruki - Para os historicos 517 invalidar numero*/
        /*if($dataForm['history-cdCredor']==9530 AND $dataForm['history-cdHistorico']){

        }*/


        $history = new History;
        $history->Cd_Devedor = $dataForm['history-cdDevedor'];
        $history->Cd_Credor = $dataForm['history-cdCredor'];
        $history->Cd_Historico = $dataForm['history-cdHistorico'];
        $history->MM_Texto = $dataForm['history-dsHistorico'];
        $history->Dt_Contato = $Dt_Contato;
        $history->Dt_Ocorrencia = date("Ymd H:i:s");
        $history->Cd_CobradorInt = \User::getUserComissionadoId();
        $history->Cd_Origem = 'G';
        $history->Cd_Negociador = \User::getUserComissionadoId();
        $history->Cd_Usuario = \User::getUserId();
        $history->Cd_Estacao = $_SERVER['REMOTE_ADDR'];
        $history->Cd_DDD = $Cd_ddd;
        $history->Cd_Telefone = $Cd_Telefone;

        return $history->save();
    }
}
