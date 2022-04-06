<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Simulation extends Model
{
    protected $table = 'AcordoSimulacao';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getSimulation($id){
        $simulation = DB::select("
        select sp.Nr_Parcela, sp.Dt_Vencimento, sp.Vl_Parcela, s.Cd_DevCre, s.Cd_Credor, s.Nr_Plano, s.Vl_Entrada, s.Al_Desconto, s.Ds_Retorno
        from AcordoSimulacaoParcela sp (nolock) join AcordoSimulacao s (nolock)
            on sp.Cd_Simulacao = s.Cd_Simulacao 
        where s.Cd_Simulacao = :id
        order by sp.Nr_Parcela", ['id' => $id]);
        
        $simulation = convert_from_latin1_to_utf8_recursively($simulation);

        return $simulation;
    }

    public function storeSimulation($debtorExternalId, $creditorId, $downpayment, $plan, $paydate, $discount, $return){
        $paydate =  str_replace('-', '', $paydate);

        $simulation = new Simulation;        
        $simulation->Cd_DevCre = $debtorExternalId;
        $simulation->Cd_Credor = $creditorId;
        $simulation->Vl_Entrada = $downpayment;
        $simulation->Nr_Plano = $plan;
        $simulation->Dt_Entrada = $paydate;
        $simulation->Al_Desconto = $discount;
        $simulation->Ds_Retorno = $return;
        $simulation->Cd_Usuario = \User::getUserId();
        $simulation->save();
        return $simulation->id;
    }
}