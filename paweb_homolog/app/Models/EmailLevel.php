<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EmailLevel extends Model
{
    protected $table = 'ClassificacaoEmail';
    protected $guarded = ['_token', 'oper'];

    public function getEmailLevels(){
        $emailLevels = DB::table($this->table)
                            ->select('cd_classificacao', 'ds_classificacao')
                            ->orderBy('nr_ordem')
                            ->get();

        $emailLevels = convert_from_latin1_to_utf8_recursively($emailLevels);

        return $emailLevels;
    }

}