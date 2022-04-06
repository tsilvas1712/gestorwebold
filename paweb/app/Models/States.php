<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{
    protected $table = 'Uf';
    protected $guarded = ['_token', 'oper'];

    public function getStates(){
        return $this->orderBy('Cd_UF')->get();
    }

}