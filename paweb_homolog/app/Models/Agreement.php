<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Agreement extends Model
{
    protected $table = 'DevedorAcordo';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getAgreements($debtorId){
        return $this
                ->select('Nr_Acordo', 'Ds_Acordo', 'Dt_Acordo', 'Dt_Limite', 'Tp_Acordo', 'Fl_Acordo', 'Dt_Fechamento', 'Cd_Contrato', 'Cd_AcordoExterno', 'Vl_MultaSO', 'Vl_JurosSO', 'Vl_TaxaAdmSO', 'Cd_Negociador', 'Ds_Observacao')
                ->where('Cd_Devedor', $debtorId)
                ->orderBy('Nr_Acordo', 'desc')
                ->get();       
    }

    public function getAgreement($debtorId, $agreementId){
        $agreement = $this
                        ->select('Nr_Acordo', 'Ds_Acordo', 'Dt_Acordo', 'Dt_Limite', 'Tp_Acordo', 'Fl_Acordo', 'Dt_Fechamento', 'Cd_Contrato', 'Cd_AcordoExterno', 'Vl_MultaSO', 'Vl_JurosSO', 'Vl_TaxaAdmSO', 'Cd_Negociador', 'Ds_Observacao', 'Cd_Credor')
                        ->where('Cd_Devedor', $debtorId)
                        ->where('Nr_Acordo', $agreementId)
                        ->orderBy('Nr_Acordo', 'desc')
                        ->get();
        if ($agreement){
            return $agreement[0];
        }

        return $agreement;
    }

    public function storeAgreement($agreementInfo){
        $id = $this->getNextId($agreementInfo['Cd_Devedor']);

        $agreement = new Agreement;
        $agreement->Cd_Devedor = $agreementInfo['Cd_Devedor'];
        $agreement->Nr_Acordo = $id;
        $agreement->Ds_Acordo = $agreementInfo['Ds_Acordo'];
        $agreement->Dt_Acordo = date("Ymd H:i:s");
        $agreement->Dt_Limite = date('Ymd H:i:s', strtotime('+15 days'));
        $agreement->Tp_Acordo = $agreementInfo['Tp_Acordo'];
        $agreement->Fl_Acordo = $agreementInfo['Fl_Acordo'];
        $agreement->Ds_Observacao = $agreementInfo['Ds_Observacao'];
        $agreement->Cd_Usuario = \User::getUserId();
        $agreement->Dt_Fechamento = date("Ymd H:i:s");
        $agreement->Nr_PropostaParcelada = $agreementInfo['Nr_PropostaParcelada'];
        $agreement->Vl_Entrada = $agreementInfo['Vl_Entrada'];
        $agreement->Tp_EnvioBloqueto = $agreementInfo['Tp_EnvioBloqueto'];
        $agreement->Cd_PeriodicidadeBloqueto = $agreementInfo['Cd_PeriodicidadeBloqueto'];
        $agreement->Cd_AcordoExterno = $agreementInfo['Cd_AcordoExterno'];
        $agreement->Cd_Negociador = \User::getUserComissionadoId();
        $agreement->Cd_Credor = $agreementInfo['Cd_Credor'];
        $agreement->Vl_PercDesconto = $agreementInfo['Vl_PercDesconto'];

        if ($agreement->save()){
            return $id;
        }else{
            return 0;
        }
    }

    public function cancelAgreement($debtorId, $agreementId){
        return $this
                    ->where('Nr_Acordo', $agreementId)
                    ->where('Cd_devedor', $debtorId)
                    ->update(['Fl_Acordo' => 'N']);
    }

    private function getNextId($debtorId){
        $max = $this->where('cd_Devedor', $debtorId)->max('Nr_Acordo');
        return $max + 1;
    }

}