<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class Workgroup extends Model
{
    protected $table = 'GrupoTrabalho';
    protected $guarded = ['_token', 'oper'];

    public function getWorkgroupsByComissioned($comissionedId = null)
    {
        if ($comissionedId == null){
            $comissionedId = Session::get('commissionedId');
        }

        //> if $comissionedId is zero, then return all workgroups
        if ($comissionedId == 0){
            $workgroup = $this
                         ->orderBy('Ds_GrupoTrabalho')
                         ->get();
        }else{
            $workgroup = DB::select("
                select gt.Cd_GrupoTrabalho, gt.Ds_GrupoTrabalho
                from GrupoTrabalho gt (nolock) join ComissionadoGrupoTrabalho cgt (nolock)
                    on gt.Cd_GrupoTrabalho = cgt.Cd_GrupoTrabalho
                where cgt.Cd_Comissionado = :id
                Order by gt.Ds_GrupoTrabalho", ['id' => $comissionedId]);

            //> If commissioned don't have workgroup, then return all
            if (!$workgroup){
                $workgroup = $this
                             ->orderBy('Ds_GrupoTrabalho')
                             ->get();
                             
            }
        }
        
        $workgroup = convert_from_latin1_to_utf8_recursively($workgroup);

        return $workgroup;
    }

    public function getWorkgroups($id)
    {
        $workgroup = $this
                    ->where('Cd_GrupoTrabalho', $id)
                    ->orderBy('Ds_GrupoTrabalho')
                    ->get();
        
        $workgroup = convert_from_latin1_to_utf8_recursively($workgroup);

        return $workgroup;
    }
}