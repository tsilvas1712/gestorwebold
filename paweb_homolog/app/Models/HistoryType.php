<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class HistoryType extends Model
{
    protected $table = 'historico';
    protected $guarded = ['_token', 'oper'];

    public function getHistoryTypes(){
        $historyTypes = DB::table($this->table)
                            ->select('Cd_Historico', 'Ds_Historico')
                            ->where('Cd_Historico', '>', 0)
                            ->where('Fl_TipoHistorico', '=', 'M')
                            ->whereIn('Fl_Visibilidade', ['I', 'T'])
                            ->orderBy('Ds_Historico')
                            ->get();

        $historyTypes = convert_from_latin1_to_utf8_recursively($historyTypes);

        return $historyTypes;
    }

}