<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class AgreementProposal extends Model
{
    protected $table = 'DevedorAcordoProposta';
    protected $guarded = ['_token', 'oper'];
    public $timestamps = false;

    public function storeAgreementProposal($agreementProposalInfo){
        $agreementProposal = new AgreementProposal;
        $agreementProposal->Nr_Seq = 1;
        $agreementProposal->Cd_Devedor = $agreementProposalInfo['Cd_Devedor'];
        $agreementProposal->Nr_Acordo = $agreementProposalInfo['Nr_Acordo'];
        $agreementProposal->Ds_Proposta = $agreementProposalInfo['Ds_Proposta'];
        $agreementProposal->Vl_Proposta = $agreementProposalInfo['Vl_Proposta'];
        return $agreementProposal->save();
    }

}