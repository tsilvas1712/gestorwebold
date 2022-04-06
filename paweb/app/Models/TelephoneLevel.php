<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class TelephoneLevel extends Model
{
    protected $table = 'ClassificacaoTelefone';
    protected $guarded = ['_token', 'oper'];

    public function getTelephoneLevels(){
        $telephoneLevels = DB::table($this->table)
                            ->select('cd_classificacao', 'ds_classificacao')
                            ->orderBy('nr_ordem')
                            ->get();

        $telephoneLevels = convert_from_latin1_to_utf8_recursively($telephoneLevels);

        return $telephoneLevels;
    }

}