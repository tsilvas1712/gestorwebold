<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Workgroup;
use DB;

class Contract extends Model
{
    protected $table = 'contrato';
    protected $guarded = ['_token', 'oper'];

    public static function getCreditorSummary($debtorId, $creditoId){
        $workgroup = new Workgroup();
        $workgroups = $workgroup->getWorkgroupsByComissioned();

        $strDebtors = objectToStrIn($workgroups, 'Cd_GrupoTrabalho');

        return DB::select("
                    select c.Cd_Credor, count(distinct Cd_Contrato) Qty_Contracts, count(Cd_Contrato) Qty_Due, min(c.Dt_Vencimento) Min_Due,
                        DATEDIFF(day, min(c.Dt_Vencimento), getdate()) Max_Delay, Sum(c.Vl_Capital - c.Vl_Pagamento) Sum_Amount
                    from Contrato c (NOLOCK) join Credor cre (NOLOCK)
                        on c.Cd_Credor = cre.Cd_Credor
                    where Cd_Devedor = :debtorId
                      and c.Cd_Credor = :creditoId
                      and cre.Cd_GrupoTrabalho in ({$strDebtors})
                      and cre.Cd_Situacao = 0
                    group by c.Cd_Credor
                    order by c.Cd_Credor", ['debtorId' => $debtorId, 'creditoId' => $creditoId])[0];
    }

    public function getContract($debtorId, $creditorId, $contractId, $installmentId, $dueDate){
        $workgroup = new Workgroup();
        $workgroups = $workgroup->getWorkgroupsByComissioned();

        $dueDate = formatDateAuto($dueDate);

        $strDebtors = objectToStrIn($workgroups, 'Cd_GrupoTrabalho');

        $contract = DB::select("
                    select c.*
                    from Contrato c (NOLOCK) join Credor cre (NOLOCK)
                        on c.Cd_Credor = cre.Cd_Credor
                    where c.Cd_Devedor = :debtorId
                      and c.Cd_Credor = :creditorId
                      and c.Cd_Contrato = :contractId
                      and c.Nr_Parcela = :installmentId
                      and c.Dt_Vencimento = :dueDate
                    and cre.Cd_GrupoTrabalho in ({$strDebtors})
                    and cre.Cd_Situacao = 0
                    Order by c.Cd_Credor, c.Cd_Contrato, c.Dt_Vencimento, c.Nr_Parcela", ['debtorId' => $debtorId, 
                                                                                          'creditorId' => $creditorId, 
                                                                                          'contractId' => $contractId, 
                                                                                          'installmentId' => $installmentId, 
                                                                                          'dueDate' => $dueDate
                                                                                         ])[0];

        $contract = convert_from_latin1_to_utf8_recursively($contract);

        return $contract;
    }

    public function getContracts($debtorId){
        $workgroup = new Workgroup();
        $workgroups = $workgroup->getWorkgroupsByComissioned();

        $strDebtors = objectToStrIn($workgroups, 'Cd_GrupoTrabalho');

        $contracts = DB::select("
                    select c.Cd_Credor, c.Cd_Contrato, c.Nr_Parcela, c.Cd_Especie, datediff(day, c.Dt_Vencimento, getDate()) Qt_Atraso, 
                            Dt_Vencimento, c.Vl_Capital, c.Vl_Pagamento, Dt_Pagamento, Dt_Devolucao, c.Ds_Observacao, c.Cd_DevCre,
                            IsNull((Select top 1 da.Nr_Acordo
                            from DevedorAcordo da (NOLOCK) JOIN DevedorAcordoContrato dac (NOLOCK)
                                on da.Nr_Acordo = dac.Nr_Acordo
                                and da.Cd_Credor = dac.Cd_Credor
                                and da.Cd_Devedor = dac.Cd_Devedor
                            where dac.Cd_Devedor = c.Cd_Devedor
                            and dac.Cd_Contrato = c.Cd_Contrato
                            and dac.Cd_DevCre = c.Cd_DevCre
                            and dac.Nr_Parcela = c.Nr_Parcela
                            and dac.Dt_Vencimento = c.Dt_Vencimento
                            and da.Fl_Acordo = 'F'
                            order by da.Nr_Acordo Desc
                        ),0)Nr_Acordo, 
                        '' Ds_Filial,
                        case when c.Vl_Capital - c.Vl_Pagamento > 0 then 1 else 0 end Fl_Active
                    from Contrato c (NOLOCK) join Credor cre (NOLOCK)
                        on c.Cd_Credor = cre.Cd_Credor
                    where Cd_Devedor = :debtorId
                    and cre.Cd_GrupoTrabalho in ({$strDebtors})
                    and cre.Cd_Situacao = 0
                    Order by c.Cd_Credor, c.Cd_Contrato, c.Dt_Vencimento, c.Nr_Parcela", ['debtorId' => $debtorId]);

        $contracts = convert_from_latin1_to_utf8_recursively($contracts);

        return $contracts;
    }

}