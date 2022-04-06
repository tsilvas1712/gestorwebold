<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AddressLevel extends Model
{
    protected $table = 'ClassificacaoEndereco';
    protected $guarded = ['_token', 'oper'];

    public function getAddressLevels(){
        $addressLevels = DB::table($this->table)
                            ->select('cd_classificacao', 'ds_classificacao')
                            ->orderBy('nr_ordem')
                            ->get();

        $addressLevels = convert_from_latin1_to_utf8_recursively($addressLevels);

        return $addressLevels;
    }

}