<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AgreementOriginal extends Model
{
    protected $table = 'DevedorAcordoContrato';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getAgreementOriginals($debtorId, $idAgreement){
        return DB::select("
                        select dac.Cd_Credor, dac.Cd_DevCre, dac.Cd_Contrato, c.Cd_Especie, dac.Dt_Vencimento, dac.Nr_Parcela, dac.Vl_Capital, dac.Vl_Saldo, c.Nr_Campanha, dac.Vl_Acordo
                        from DevedorAcordoContrato dac (nolock) JOIN Contrato c (nolock) 
                            on dac.Cd_Credor = c.Cd_Credor
                            and dac.Cd_DevCre = c.Cd_DevCre
                            and dac.Cd_Contrato = c.Cd_Contrato
                            and dac.Nr_Parcela = c.Nr_Parcela
                            and dac.Dt_Vencimento = c.Dt_Vencimento
                            and dac.Cd_Devedor = c.Cd_Devedor
                        where dac.Cd_Devedor = :debtorId
                        and dac.Nr_Acordo = :idAgreement", ['debtorId' => $debtorId, 'idAgreement' => $idAgreement ]);          
    }

    public function storeAgreementOriginal($agreementOriginalInfo){
        $dueDate = str_replace('-', '', $agreementOriginalInfo['Dt_Vencimento']);

        $agreementOriginal = new AgreementOriginal;
        $agreementOriginal->Cd_Devedor = $agreementOriginalInfo['Cd_Devedor'];
        $agreementOriginal->Nr_Acordo = $agreementOriginalInfo['Nr_Acordo'];
        $agreementOriginal->Cd_Credor = $agreementOriginalInfo['Cd_Credor'];
        $agreementOriginal->Cd_DevCre = $agreementOriginalInfo['Cd_DevCre'];
        $agreementOriginal->Cd_Contrato = $agreementOriginalInfo['Cd_Contrato'];
        $agreementOriginal->Nr_Parcela = $agreementOriginalInfo['Nr_Parcela'];
        $agreementOriginal->Dt_Vencimento = $dueDate;
        $agreementOriginal->Vl_Capital = $agreementOriginalInfo['Vl_Capital'];
        $agreementOriginal->Vl_Saldo = $agreementOriginalInfo['Vl_Saldo'];
        $agreementOriginal->Vl_Corrigido = $agreementOriginalInfo['Vl_Corrigido'];
        $agreementOriginal->Vl_Minimo = $agreementOriginalInfo['Vl_Minimo'];
        
        return $agreementOriginal->save();
    }

}