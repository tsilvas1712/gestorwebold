<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Debtor;
use App\Models\Contract;

class DebtorController extends Controller
{
    private $debtor;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Debtor $debtor, Contract $contract)
    {
        $this->middleware('auth.ldap');

        $this->debtor = $debtor;
        $this->contract = $contract;
    }

    public function search(Request $request)
    {
        $field = $request->input('field');
        $text = $request->input('text');

        if (($field == null) || ($text == null) ||
           ($field == '') || ($text == '') ){
            return response('Parâmetros não informados corretamente.',400);
        }else{
            return $this->debtor->searchDebtors($field, $text);
        }
    }

    public function get(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $contractRequest = $request->input('contract');
        
        $creditorId = $contractRequest[0]["Cd_Credor"];        
        $contractId = $contractRequest[0]["Cd_Contrato"];
        $installmentId = $contractRequest[0]["Nr_Parcela"];
        $dueDate = $contractRequest[0]["Dt_Vencimento"];

        if ($debtorId > 0) {
            $debtor = $this->debtor->getDebtor($debtorId);
            $contract = $this->contract->getContract($debtorId, $creditorId, $contractId, $installmentId, $dueDate);

            return response()->json(['debtor' => $debtor, 'contract' => $contract], 200, [
                'Content-Type' => 'application/json', 
                ], JSON_UNESCAPED_UNICODE);

        }
    }
}
