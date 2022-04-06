<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class IncomingCall extends Model
{
    protected $table = 'ChamadaRecebida';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;
    
    public function getIncomingCall(){
        $call = $this
                    ->where('Cd_Estacao', $_SERVER['REMOTE_ADDR'])
                    ->where('Fl_Atendida', 0)
                    ->orderBy('Dt_momento', 'Desc')
                    ->get();

        if ($call->count() > 0) return $call[0];

        return $call;
    }

    public function getCallInProgress(){
        $call = $this
                    ->where('Cd_Estacao', $_SERVER['REMOTE_ADDR'])
                    ->where('Fl_Atendida', 1)
                    ->where('Fl_Encerrada', 0)
                    ->get();

        if ($call->count() > 0) return $call[0];

        return $call;
    }

    public function clearCalls(){
        return $this
                    ->where('Cd_Estacao', $_SERVER['REMOTE_ADDR'])
                    ->where('Fl_Atendida', 0)
                    ->update(['Fl_Atendida' => 1]);
    }

}