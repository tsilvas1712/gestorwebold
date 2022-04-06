<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class SimulationInstallment extends Model
{
    protected $table = 'AcordoSimulacaoParcela';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function storeSimulationInstallment($simulationId, $installmentId, $dueDate, $amount){
        $dueDate =  str_replace('-', '', $dueDate);
        $dueDate =  str_replace('T00:00:00Z', '', $dueDate);
        $dueDate =  str_replace('T00:00:00', '', $dueDate);

        $simulationInstallment = new SimulationInstallment;
        $simulationInstallment->Cd_Simulacao = $simulationId;
        $simulationInstallment->Nr_Parcela = $installmentId;
        $simulationInstallment->Dt_Vencimento = $dueDate;
        $simulationInstallment->Vl_Parcela = $amount;
        return $simulationInstallment->save();
    }
}