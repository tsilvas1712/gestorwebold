<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AgreementInstallment extends Model
{
    protected $table = 'DevedorParcelamento';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getAgreementInstallments($debtorId, $agreementId){
        return $this
                ->select('Nr_Parcela', 'Dt_Vencimento', 'Vl_Parcela', 'Tp_EnvioBloqueto', 'Cd_Cedente', 'Nr_NossoNumero', 'Dt_Pagamento', 'Vl_Pagamento', 'Nr_Recibo')
                ->where('Cd_Devedor', $debtorId)
                ->where('Nr_Acordo', $agreementId)
                ->orderBy('Nr_Parcela')
                ->get();       
    }

    public function getAgreementInstallment($debtorId, $agreementId, $installmentId){
        $agreementInstallment = $this
                                    ->where('Cd_Devedor', $debtorId)
                                    ->where('Nr_Acordo', $agreementId)
                                    ->where('Nr_Parcela', $installmentId)
                                    ->get();
        
        if ($agreementInstallment){
            return $agreementInstallment[0];
        }

        return $agreementInstallment;
    }

    public function updateBilletInfo($debtorId, $agreementId, $installmentId, $ourNumber, $assignorId){
        return $this
                    ->where('Nr_Acordo', $agreementId)
                    ->where('Nr_Parcela', $installmentId)
                    ->where('Cd_devedor', $debtorId)
                    ->update(['Nr_NossoNumero' => $ourNumber, 
                              'Cd_Cedente' => $assignorId]);
    }

    public function storeAgreementInstallment($agreementInstallmentInfo){
        dd("AQUIIIIII.... Model Agreement....");
        exit();
        $agreementInstallment = new AgreementInstallment;
        $dueDate = str_replace('-', '', $agreementInstallmentInfo['Dt_Vencimento']);
        $issueDate = str_replace('-', '', $agreementInstallmentInfo['Dt_Emissao']);

        $agreementInstallment->Cd_Devedor = $agreementInstallmentInfo['Cd_Devedor'];
        $agreementInstallment->Nr_Acordo = $agreementInstallmentInfo['Nr_Acordo'];
        $agreementInstallment->Nr_Parcela = $agreementInstallmentInfo['Nr_Parcela'];
        $agreementInstallment->Dt_Vencimento = $dueDate;
        $agreementInstallment->Vl_Parcela = $agreementInstallmentInfo['Vl_Parcela'];
        $agreementInstallment->Dt_Emissao = $issueDate;
        $agreementInstallment->Dt_EnvioBloqueto = date('Ymd H:i:s', strtotime('+14 days'));
        $agreementInstallment->Tp_EnvioBloqueto = $agreementInstallmentInfo['Tp_EnvioBloqueto'];
        return $agreementInstallment->save();
    }
}