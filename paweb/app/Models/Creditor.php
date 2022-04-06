<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    protected $table = 'Credor';
    protected $guarded = ['_token', 'oper'];

    public function getCreditor($id){
        return $this
                ->where('Cd_Credor', $id)
                ->get()[0];       
    }

}