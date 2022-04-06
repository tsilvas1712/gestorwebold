<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class SimulationOriginal extends Model
{
    protected $table = 'AcordoSimulacaoContrato';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function getSimulationOriginals($simulationId){
        return $this
                    ->where('Cd_Simulacao', $simulationId)
                    ->get();
    }

    public function storeSimulationOriginal($simulationId, $contractId, $installmentId, $dueDate){
        $dueDate =  str_replace('T00:00:00Z', '', $dueDate);
        $dueDate =  str_replace('T00:00:00', '', $dueDate);
        
        $dueDate = formatDateAuto($dueDate);

        $simulationOriginal = new simulationOriginal;
        $simulationOriginal->Cd_Simulacao = $simulationId;
        $simulationOriginal->Cd_Contrato = $contractId;
        $simulationOriginal->Nr_Parcela = $installmentId;
        $simulationOriginal->Dt_Vencimento = $dueDate;
        return $simulationOriginal->save();
    }
}