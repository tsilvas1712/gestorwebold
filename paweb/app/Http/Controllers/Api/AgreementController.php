<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Soap\SoapCalcardController;
use App\Http\Controllers\Api\BilletController;
use App\Models\Contract;
use App\Models\Agreement;
use App\Models\AgreementInstallment;
use App\Models\AgreementProposal;
use App\Models\AgreementOriginal;
use App\Models\Email;
use App\Models\Telephone;
use App\Models\Address;
use App\Models\History;
use App\Models\Simulation;
use App\Models\SimulationOriginal;

class AgreementController extends Controller
{
    private $contract;
    private $agreement;
    private $agreementInstallment;
    private $agreementProposal;
    private $agreementOriginal;
    private $email;
    private $telephone;
    private $address;
    private $simulation;
    private $simulationOriginal;
    private $billetController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Contract $contract, 
                                Agreement $agreement, 
                                AgreementInstallment $agreementInstallment,
                                AgreementProposal $agreementProposal,
                                AgreementOriginal $agreementOriginal,
                                Email $email, 
                                Telephone $telephone, 
                                Address $address,
                                History $history,
                                Simulation $simulation,
                                SimulationOriginal $simulationOriginal)
    {
        $this->middleware('auth.ldap');

        $this->contract = $contract;
        $this->agreement = $agreement;
        $this->agreementInstallment = $agreementInstallment;
        $this->agreementProposal = $agreementProposal;
        $this->agreementOriginal = $agreementOriginal;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->address = $address;
        $this->history = $history;
        $this->simulation = $simulation;
        $this->simulationOriginal = $simulationOriginal;
    }

    public function store(Request $request)
    {
        $dataForm = $request->all();
        $jsonTelephone = [];
        $jsonEmail = [];
        $jsonAddress = [];

        $debtorId = $dataForm['debtorId'];

        if (isset($dataForm['telephones'])){
            $jsonTelephone = $dataForm['telephones'];
        }
        if (isset($dataForm['emails'])){
            $jsonEmail = $dataForm['emails'];
        }
        if (isset($dataForm['addresses'])){
            $jsonAddress = $dataForm['addresses'];
        }
        $simulationId = Session::get('simulationId');
        $simulationId = Crypt::decrypt($simulationId);

        //> Update Telephones
        foreach ($jsonTelephone as $item) {
            if (! $this->telephone->updateTelephone($debtorId, $item['areaCode'], $item['number'], $item['status'])){
                $return['success'] = 0;
                $return['message'] = "Erro ao atualizar telefone.";
                return $return;
            }
        }

        //> Update Emails
        foreach ($jsonEmail as $item) {
            if (! $this->email->updateEmail($debtorId, $item['email'], $item['status'])){
                $return['success'] = 0;
                $return['message'] = "Erro ao atualizar email.";
                return $return;
            }
        }

        //> Update Addresses
        foreach ($jsonAddress as $item) {
            if (! $this->address->updateAddress($debtorId, $item['id'], $item['status'])){
                $return['success'] = 0;
                $return['message'] = "Erro ao atualizar endereço.";
                return $return;
            }
        }

        $simulation = $this->simulation->getSimulation($simulationId);
        $creditorId = $simulation[0]->Cd_Credor;
        $debtorExternalId = $simulation[0]->Cd_DevCre;

        $response = $this->storeAgreement($debtorId, $debtorExternalId, $simulation);
        if ($response['success'] == 1){
            $agreementId = $response['return'];
        }else{
            return $response;
        }

        if ($agreementId > 0){
            if ($this->storeAgreementInstallment($debtorId, $agreementId, $simulation)){
                if ($this->storeAgreementProposal($debtorId, $agreementId, $simulation)){
                    if ($this->storeAgreementOriginal($debtorId, $creditorId, $agreementId, $simulationId)){
                        $return['success'] = 1;
                        $return['message'] = "Acordo gravado com sucesso.";
                    }
                }
            }
        }

        //> If store agreement with successful, then send SMS, WhatsApp and Email and store history 3
        if ($return['success'] == 1){
            $this->billetController = new BilletController();
            $agreementRequest = $this->agreement->getAgreement($debtorId, $agreementId);
            $agreementInstallmentRequest = $this->agreementInstallment->getAgreementInstallment($debtorId, $agreementId, 1);
            $return['sms'] = $this->sendMessage($debtorId, $debtorExternalId, $creditorId, $agreementId, $agreementRequest, $agreementInstallmentRequest, 's');
            $return['whatsapp'] = $this->sendMessage($debtorId, $debtorExternalId, $creditorId, $agreementId, $agreementRequest, $agreementInstallmentRequest, 'w');
            $return['email'] = $this->sendEmail($debtorId, $debtorExternalId, $creditorId, $agreementId, $agreementRequest, $agreementInstallmentRequest);

            //> Store history
            $dataForm['history-dtAgenda'] = date("Ymd H:i:s");
            $dataForm['history-cdDevedor'] = $debtorId;
            $dataForm['history-cdCredor'] = $creditorId;
            $dataForm['history-cdHistorico'] = 3;

            if (count($simulation) == 1){
                $text = 'ACORDO À VISTA FECHADO' . PHP_EOL .
                        'Valor ' . asCurrency($simulation[0]->Vl_Parcela) . PHP_EOL .
                        'Vcto: ' . formatDateYYYYMMDD_DDMMYYYY($simulation[0]->Dt_Vencimento) . PHP_EOL .
                        'Perc. Desconto: ' . $simulation[0]->Al_Desconto;
            }else{
                $text = 'ACORDO PARCELADO FECHADO' . PHP_EOL .
                        'Entrada de ' . asCurrency($simulation[0]->Vl_Parcela) . ' + ' . count($simulation) . ' de '. asCurrency($simulation[0]->Vl_Parcela) . PHP_EOL .
                        '1° Vcto: ' . formatDateYYYYMMDD_DDMMYYYY($simulation[0]->Dt_Vencimento) . PHP_EOL .
                        'Perc. Desconto: ' . $simulation[0]->Al_Desconto . PHP_EOL;
            }
            $dataForm['history-dsHistorico'] = $text;
            $this->history->storeHistory($dataForm);
        }

        return $return;
    }

    public function cancel(Request $request)
    {
        $dataForm = $request->all();
        $debtorId = $dataForm['debtorId'];
        $debtorExternalId = $dataForm['debtorExternalId'];
        $agreementId = $dataForm['agreementId'];
        $agreementExternalId = $dataForm['agreementExternalId'];
        $creditorId = $dataForm['creditorId'];

        $externalCancel = true;

        switch ($creditorId) {
            //> Calcard
            case '5291':
                $externalCancel = $this->cancelAgreementCalcard($debtorExternalId, $agreementExternalId);
                break;
            default:
                $error['success'] = 0;
                $error['return'] = 'Credor não está implementado no sistema.';
                return $error;
                break;
        }

        if ($externalCancel == 1){
            $this->agreement->cancelAgreement($debtorId, $agreementId);
            return 1;
        }else{
            return $externalCancel;
        }
    }

    private function cancelAgreementCalcard($debtorExternalId, $agreementExternalId){
        $soap = new SoapCalcardController();
        $response = $soap->cancelarAcordo($debtorExternalId, $agreementExternalId);

        if ($response == 1){
            return 1;
        }

        return $response;
    }

    private function storeAgreement($debtorId, $debtorExternalId, $simulation){
        $creditorId = $simulation[0]->Cd_Credor;

        $response = $this->storeExternalAgreement($creditorId, $debtorExternalId, $simulation[0]->Ds_Retorno);

        if ($response['success'] == 1){
            $agreementExternalId = $response['return'];
        }else{
            return $response;
        }

        $agreementInfo['Cd_Devedor'] = $debtorId;
        $agreementInfo['Ds_Acordo'] = 'ACORDO AGENDADO';
        $agreementInfo['Tp_Acordo'] = 'M';
        $agreementInfo['Fl_Acordo'] = 'F';
        $agreementInfo['Ds_Observacao'] = '';
        $agreementInfo['Nr_PropostaParcelada'] = $simulation[0]->Nr_Plano;
        $agreementInfo['Vl_Entrada'] = ($simulation[0]->Vl_Entrada == 0 ? $simulation[0]->Vl_Parcela : $simulation[0]->Vl_Entrada);
        $agreementInfo['Tp_EnvioBloqueto'] = 'E';
        $agreementInfo['Cd_PeriodicidadeBloqueto'] = 'V';
        $agreementInfo['Cd_AcordoExterno'] = $agreementExternalId;
        $agreementInfo['Cd_Credor'] = $creditorId;
        $agreementInfo['Vl_PercDesconto'] = $simulation[0]->Al_Desconto;

        $store = $this->agreement->storeAgreement($agreementInfo);
        
        if ($store > 0){
            $return['success'] = 1;
            $return['return'] = $store;
        }else{
            $return['success'] = 0;
            $return['return'] = 'Erro ao gravar DevedorAcordo';
        }

        return $return;
    }

    private function storeAgreementInstallment($debtorId, $agreementId, $simulation){
        $agreementInstallmentInfo['Cd_Devedor'] = $debtorId;
        $agreementInstallmentInfo['Nr_Acordo'] = $agreementId;
        $agreementInstallmentInfo['Tp_EnvioBloqueto'] = 'C';

        foreach ($simulation as $item) {
            $agreementInstallmentInfo['Nr_Parcela'] = str_pad($item->Nr_Parcela, 2, "0", STR_PAD_LEFT);
            $agreementInstallmentInfo['Dt_Vencimento'] = $item->Dt_Vencimento;
            $agreementInstallmentInfo['Vl_Parcela'] = $item->Vl_Parcela;
            $agreementInstallmentInfo['Dt_Emissao'] = $item->Dt_Vencimento;
            
            $store = $this->agreementInstallment->storeAgreementInstallment($agreementInstallmentInfo);
            if (!$store){
                return false;
            }
        }

        return true;
    }

    private function storeAgreementProposal($debtorId, $agreementId, $simulation){
        $agreementProposalInfo['Cd_Devedor'] = $debtorId;
        $agreementProposalInfo['Nr_Acordo'] = $agreementId;

        if ($simulation[0]->Nr_Plano == 1){
            $agreementProposalInfo['Ds_Proposta'] = 'A Vista';
        }else{
            $agreementProposalInfo['Ds_Proposta'] = 'Ent+' . ($simulation[0]->Nr_Plano-1);
        }
        $sumInstallments = 0;

        foreach ($simulation as $item) {
            $sumInstallments += $item->Vl_Parcela;
        }
        $agreementProposalInfo['Vl_Proposta'] = $sumInstallments;
        return $this->agreementProposal->storeAgreementProposal($agreementProposalInfo);
    }

    private function storeAgreementOriginal($debtorId, $creditorId, $agreementId, $simulationId){
        $simulationOriginal = $this->simulationOriginal->getSimulationOriginals($simulationId);

        $agreementOriginalInfo['Cd_Devedor'] = $debtorId;
        $agreementOriginalInfo['Nr_Acordo'] = $agreementId;
        $agreementOriginalInfo['Cd_Credor'] = $creditorId;

        foreach ($simulationOriginal as $item) {
            $contract = $this->contract->getContract($debtorId, $creditorId, $item->Cd_Contrato, $item->Nr_Parcela, $item->Dt_Vencimento);

            $agreementOriginalInfo['Cd_DevCre'] = $contract->Cd_DevCre;
            $agreementOriginalInfo['Cd_Contrato'] = $contract->Cd_Contrato;
            $agreementOriginalInfo['Nr_Parcela'] = $contract->Nr_Parcela;
            $agreementOriginalInfo['Dt_Vencimento'] = $contract->Dt_Vencimento;
            $agreementOriginalInfo['Vl_Capital'] = $contract->Vl_Capital;
            $agreementOriginalInfo['Vl_Saldo'] = $contract->Vl_Capital - $contract->Vl_Pagamento;
            $agreementOriginalInfo['Vl_Corrigido'] = $contract->Vl_Capital;
            $agreementOriginalInfo['Vl_Minimo'] = $contract->Vl_Capital;

            $store = $this->agreementOriginal->storeAgreementOriginal($agreementOriginalInfo);
            if (!$store){
                return false;
            }
        }

        return true;
    }

    private function storeExternalAgreement($creditorId, $debtorExternalId, $simulationReturn){
        switch ($creditorId) {
            //> Calcard
            case '5291':
                return $this->storeExternalAgreementCalcard($debtorExternalId, $simulationReturn);
                break;
            default:
                $error['success'] = 0;
                $error['return'] = 'Credor não está implementado no sistema.';
                return $error;
                break;
        }
    }

    private function storeExternalAgreementCalcard($debtorExternalId, $simulationReturn){
        $soap = new SoapCalcardController();
        $response = $soap->confirmarAcordo($debtorExternalId, $simulationReturn);

        if ($response['success']){
            $return['success'] = 1;
        }else{
            $return['success'] = 0;
        }
        $return['return'] = $response['return'];

        return $return;
    }

    private function sendMessage($debtorId, $debtorExternalId, $creditorId, $agreementId, $agreementRequest, $agreementInstallmentRequest, $type){
        $telephone = $this->telephone->getTelephones($debtorId, 'M');
        $areaCode = $telephone[0]->Cd_DDD;
        $number = $telephone[0]->Cd_Telefone;

        $send = $this->billetController->sendMessage($debtorId, $areaCode, $number, $debtorExternalId, $agreementRequest, $agreementInstallmentRequest, $type);
        return $send['success'];
    }

    private function sendEmail($debtorId, $debtorExternalId, $creditorId, $agreementId, $agreementRequest, $agreementInstallmentRequest){
        $email = $this->email->getEmails($debtorId);
        if (sizeof($email) > 0){
            $emailAddress = $email[0]->Ds_Email;

            $send = $this->billetController->sendEmail($debtorId, $emailAddress, $debtorExternalId, $agreementRequest, $agreementInstallmentRequest);
            return $send['success'];
        }else{
            return 0;
        }
    }

}
