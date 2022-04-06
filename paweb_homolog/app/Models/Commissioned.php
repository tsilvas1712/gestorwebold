<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Commissioned extends Model
{
    protected $table = 'Comissionado';
    protected $guarded = ['_token', 'oper'];
    
    public function getCommissioned($id){
        $commissioned = $this
                        ->where('Cd_Comissionado', $id)
                        ->get();
        $commissioned = convert_from_latin1_to_utf8_recursively($commissioned);
        return $commissioned;
    }

}