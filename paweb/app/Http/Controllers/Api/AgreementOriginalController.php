<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AgreementOriginal;

class AgreementOriginalController extends Controller
{
    private $agreementOriginal;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AgreementOriginal $agreementOriginal)
    {
        $this->middleware('auth.ldap');
        $this->agreementOriginal = $agreementOriginal;
    }

    public function get(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $idAgreement = $request->input('idAgreement');
        
        return $this->agreementOriginal->getAgreementOriginals($debtorId, $idAgreement);
    }
}
