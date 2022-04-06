<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Assignor extends Model
{
    protected $table = 'Cedente';
    protected $guarded = ['_token', 'oper'];

    public function getAssignors(){
        return $this->get();
    }
}