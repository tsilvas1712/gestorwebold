<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Debtor extends Model
{
    protected $table = 'devedor';
    protected $guarded = ['_token', 'oper'];
    protected $appends = ['Ds_Nome', 'Dt_Nascimento', 'Cd_Sexo']; // adicionando item na serialização

    public function getDebtor($id){
        $debtor = DB::select("
                        Select *
                        from Devedor (nolock)
                        where cd_Devedor = :id", ['id' => $id]);
        
        if ($debtor){
            $debtor = $debtor[0];
            $debtor = convert_from_latin1_to_utf8_recursively($debtor);

            if ($debtor->Dt_Nascimento === null){
                $debtor->Dt_Nascimento = '';
            }else{
                $debtor->Dt_Nascimento = formatDateDDMMYYYY_YYYYMMDD($debtor->Dt_Nascimento);
            }    
        }

        return $debtor;
    }

    public function searchDebtors($field, $text){
        $sql = "select distinct top 30 d.Cd_Devedor, d.Ds_Nome, d.Cd_CICCGC, c.Ds_Credor
                from devedor d (nolock) join DevedorCredor dc (nolock)
                        on d.cd_devedor = dc.cd_devedor
                    join Credor c (nolock)
                        on c.Cd_Credor = dc.Cd_Credor";

        if ( ($field == 'Cd_Devedor') || ($field == 'Cd_CICCGC') || ($field == 'Cd_Telefone') ){
            $operator = '=';
        }else{
            $operator = 'like';
            $text .= "%";
        }
                
        switch ($field) {
            case 'Ds_Nome':
                $field = "d." . $field;
                break;
            case 'Cd_Devedor':
                $field = "d." . $field;
                break;
            case 'Cd_CICCGC':
                $field = "d." . $field;
                $text = montarCGCCIC($text);
                break;
            case 'Cd_Contrato':
                $sql .= " join Contrato co (nolock)
                            on co.Cd_Devedor = dc.Cd_Devedor
                            and co.Cd_Credor = dc.Cd_Credor ";
                $field = "co." . $field;
                break;
            case 'Cd_DevCre':
                $field = "dc." . $field;
                break;
            case 'Cd_Telefone':
                $sql .= " join DevedorTelefone dt (nolock)
                        on dt.Cd_Devedor = d.Cd_Devedor 
                        and IsNull(dt.Cd_Situacao, 'A') <> 'D'
                        and IsNull(dt.Cd_Classificacao,'N') <> 'F'";
                $field = "dt." . $field;
                break;
            case 'Ds_Email':
                $sql .= " join DevedorEmail de (nolock)
                        on de.Cd_Devedor = d.Cd_Devedor 
                        and de.fl_situacao = 'A'";

                $field = "de." . $field;
                break;
        }

        $sql .= " where {$field} {$operator} '{$text}'";

        $sql .= " and c.Cd_Situacao = 0
        order by d.Ds_Nome, d.Cd_Devedor";

        //dd($sql);

        $debtors = DB::select($sql);
        $debtors = convert_from_latin1_to_utf8_recursively($debtors);
        return response()->json($debtors, 200, [
                                                'Content-Type' => 'application/json;charset=UTF-8', 
                                                'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function getStatus($debtorId, $creditorId ){       
        $status = DB::select("
                        Select top 1 gs.cd_GrupoStatus, gs.ds_GrupoStatus
                        from StatusFicha sf (nolock), historicoCredor hc (nolock), GrupoStatus gs (nolock)
                        where hc.cd_historico = sf.cd_historico
                        and hc.Cd_Credor = sf.cd_Credor
                        and gs.Cd_GrupoStatus = hc.Cd_GrupoStatus
                        and sf.cd_Devedor = :debtorId
                        and sf.cd_credor = :creditorId
                        Order by dt_alteracao Desc", ['debtorId' => $debtorId, 'creditorId' => $creditorId]);
        
        $status = convert_from_latin1_to_utf8_recursively($status);
        return $status;
    }

    public function getExternalId($debtorId, $creditorId){
        $debtor = DB::select("
                            select Cd_DevCre
                            from DevedorCredor (nolock)
                            where Cd_Devedor = :debtorId
                            and Cd_Credor = :creditorId", 
                            ['debtorId' => $debtorId, 'creditorId' => $creditorId]);
        
        return $debtor[0]->Cd_DevCre;
    }

    /********************************** init Mutators **********************************/
    public function getDsNomeAttribute()
    {
        return strtoupper($this->attributes['Ds_Nome']);
    }

    public function getDtNascimentoAttribute()
    {
        if ($this->attributes['Dt_Nascimento'] === null){
            return '';
        }else{
            return formatDateDDMMYYYY_YYYYMMDD($this->attributes['Dt_Nascimento']);
        }
    }

    public function getCdSexoAttribute()
    {
        if ($this->attributes['Cd_Sexo'] === null){
            return '';
        }else{
            return $this->attributes['Cd_Sexo'];
        }
    }

}