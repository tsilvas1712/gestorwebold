<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AgreementInstallment;

class AgreementInstallmentController extends Controller
{
    private $agreementInstallment;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AgreementInstallment $agreementInstallment)
    {
        $this->middleware('auth.ldap');
        $this->agreementInstallment = $agreementInstallment;
    }

    public function get(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $idAgreement = $request->input('idAgreement');
        
        return $this->agreementInstallment->getAgreementInstallments($debtorId, $idAgreement);
    }
}
