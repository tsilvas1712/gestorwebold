<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Billet extends Model
{
    protected $table = 'Bloqueto';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getBillet($id){
        $billet = $this
                    ->where('Nr_Seq', $id)
                    ->get();
        
        if ($billet){
            return $billet[0];
        }

        return $billet;
    }

    public function getBillets($debtorId){
        return $this
                ->select('Nr_Seq', 'Cd_Cedente', 'Nr_NossoNumero', 'Dt_Processamento', 'Dt_Vencimento', 'Vl_Documento', 'Cd_Identificacao', 'Cd_Credor')
                ->where('Cd_Devedor', $debtorId)
                ->orderBy('Dt_Processamento', 'desc')
                ->get();       
    }

    public function getBilletsByOurNumber($debtorId, $creditorId, $ourNumber){
        return $this
                ->select('Nr_Seq', 'Cd_Cedente', 'Nr_NossoNumero', 'Dt_Processamento', 'Dt_Vencimento', 'Vl_Documento', 'Cd_Identificacao', 'Cd_Credor')
                ->where('Cd_Devedor', $debtorId)
                ->where('Cd_Credor', $creditorId)
                ->where('Nr_NossoNumero', $ourNumber)
                ->orderBy('Dt_Processamento', 'desc')
                ->get();       
    }
    
    public function storeBillet($billetInfo){
        //$paydate =  str_replace('-', '', $paydate);
        $billetInfo['Cd_Identificacao'] = str_replace('.', '', $billetInfo['Cd_Identificacao']);
        $billetInfo['Cd_Identificacao'] = str_replace(' ', '', $billetInfo['Cd_Identificacao']);

        $billetInfo['Vl_Documento'] = str_replace(',', '.', $billetInfo['Vl_Documento']);

        $billet = new Billet;
        $billet->Cd_Usuario = \User::getUserId();
        $billet->Cd_Cedente = $billetInfo['Cd_Cedente'];
        $billet->Nr_NossoNumero = $billetInfo['Nr_NossoNumero'];
        $billet->Cd_Barras = $billetInfo['Cd_Barras'];
        $billet->Cd_Identificacao = $billetInfo['Cd_Identificacao'];
        $billet->Dt_Processamento = date("Ymd H:i:s");
        $billet->Dt_Vencimento = $billetInfo['Dt_Vencimento'];
        $billet->Dt_Documento = $billetInfo['Dt_Documento'];
        $billet->Nr_Documento = $billetInfo['Nr_Documento'];
        $billet->Cd_Carteira = $billetInfo['Cd_Carteira'];
        $billet->Vl_Documento = $billetInfo['Vl_Documento'];
        $billet->Cd_Devedor = $billetInfo['Cd_Devedor'];
        $billet->Cd_Operacao = $billetInfo['Cd_Operacao'];
        $billet->Nr_Operacao = $billetInfo['Nr_Operacao'];
        $billet->MM_Texto = $billetInfo['MM_Texto'];
        $billet->Nr_Cedente = $billetInfo['Nr_Cedente'];
        $billet->Ds_Endereco = $billetInfo['Ds_Endereco'];
        $billet->Cd_Aprovacao = $billetInfo['Cd_Aprovacao'];
        $billet->Cd_Credor = $billetInfo['Cd_Credor'];
        $billet->Cd_BoletoExt = $billetInfo['Cd_BoletoExt'];
        $billet->Tp_Documento = '';
        $billet->save();

        return $billet->id;
    }
}