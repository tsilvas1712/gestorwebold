<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Soap\SoapCalcardController;
use App\Models\Agreement;
use App\Models\AgreementInstallment;
use App\Models\Billet;
use App\Models\Creditor;
use App\Models\Telephone;
use App\Models\Email;

class BilletController extends Controller
{
    private $billet;
    private $creditor;
    private $agreement;
    private $telephone;
    private $email;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.ldap');

        $this->billet = new billet();
        $this->creditor = new creditor();
        $this->telephone = new telephone();
        $this->email = new email();
        $this->agreement = new agreement();
        $this->agreementInstallment = new agreementInstallment();
    }

    public function message(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $areaCode = $request->input('areaCode');
        $number = $request->input('number');
        $debtorExternalId = $request->input('debtorExternalId');
        $agreementRequest = $request->input('agreement');
        $agreementInstallmentRequest = $request->input('agreementInstallment');
        $type = $request->input('type');

        return $this->sendMessage($debtorId, $areaCode, $number, $debtorExternalId, $agreementRequest[0], $agreementInstallmentRequest[0], $type);
    }
    
    public function sendMessage($debtorId, $areaCode, $number, $debtorExternalId, $agreementRequest, $agreementInstallmentRequest, $type){
        $agreementId = $agreementRequest["Nr_Acordo"];
        $installmentId = $agreementInstallmentRequest["Nr_Parcela"];

        $agreement = $this->agreement->getAgreement($debtorId, $agreementId);
        $agreementInstallment = $this->agreementInstallment->getAgreementInstallment($debtorId, $agreementId, $installmentId);
        $creditorId = $agreement->Cd_Credor;
        $creditor = $this->creditor->getCreditor($creditorId);

        //> if already have our number, get data from billet
        if ($agreementInstallment->Nr_NossoNumero != ""){
            $billet = $this->billet->getBillets($debtorId);
            $billet = $this->billet->getBilletsByOurNumber($debtorId, $creditorId, $agreementInstallment->Nr_NossoNumero);
            $billet = $billet[0];
        }else{
            //> if not have our number yet, create new billet
            $billet = $this->create($debtorId, $creditorId, $creditor->Cd_CedenteDefault, $debtorExternalId, $agreement->Nr_Acordo, $agreement->Cd_AcordoExterno, $installmentId, false);
            if ($billet['success'] == false){
                $json = json_encode($billet['return']);
                $error = json_decode($json,TRUE);

                $return['success'] = 0;
                $return['return'] = $error[0];
                return $return;
            }else{
                $billet = $this->billet->getBillet($billet['return']);
            }
        }

        //> Check if telephone number exists
        $telephone = $this->telephone->getTelephone($debtorId, $areaCode, $number);
        //> If not exists, store
        if ($telephone->count() == 0){
            $telephoneInfo['telephone-cdDevedor'] = $debtorId;
            $telephoneInfo['telephone-cdDdd'] = $areaCode;
            $telephoneInfo['telephone-cdTelefone'] = $number;
            $telephoneInfo['telephone-cdClassificacao'] = 'H';

            $this->telephone->storeTelephone($telephoneInfo);
        }

        $digitableLine = $billet->Cd_Identificacao;
        $phone = $creditor->cd_0800;
        $phone = str_replace('.', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);

        $text = 'Boleto ' . $creditor->DS_APELIDO . ' no valor de ' . asCurrency($billet->Vl_Documento) .
                ' Linha digitável ' . substr($digitableLine,0,5)  . '.' .
                                      substr($digitableLine,5,5)  . ' ' .
                                      substr($digitableLine,10,5) . '.' .
                                      substr($digitableLine,15,6) . ' ' .
                                      substr($digitableLine,21,5) . '.' .
                                      substr($digitableLine,26,6) . ' ' .
                                      substr($digitableLine,32,1) . ' ' .
                                      substr($digitableLine,33,14) .
                ' Dúvidas ' . $phone . '.';

        if (strtolower($type) == 'w'){
            $return = $this->telephone->sendWhatsapp($areaCode, $number, $text);
        }else{
            $sms = $this->telephone->sendSMS($areaCode, $number, $text);
            $return['success'] = $sms['CodRetorno'];
            $return['return'] = $sms['DescRetorno'];
        }

        return $return;
    }

    public function email(Request $request){
        $debtorId = $request->input('debtorId');
        $emailAddress = $request->input('email');
        $debtorExternalId = $request->input('debtorExternalId');
        $agreementRequest = $request->input('agreement');
        $agreementInstallmentRequest = $request->input('agreementInstallment');

        return $this->sendEmail($debtorId, $emailAddress, $debtorExternalId, $agreementRequest[0], $agreementInstallmentRequest[0]);
    }

    public function sendEmail($debtorId, $emailAddress, $debtorExternalId, $agreementRequest, $agreementInstallmentRequest){
        $agreementId = $agreementRequest["Nr_Acordo"];
        $installmentId = $agreementInstallmentRequest["Nr_Parcela"];

        $agreement = $this->agreement->getAgreement($debtorId, $agreementId);
        $agreementInstallment = $this->agreementInstallment->getAgreementInstallment($debtorId, $agreementId, $installmentId);
        $creditorId = $agreement->Cd_Credor;
        $creditor = $this->creditor->getCreditor($creditorId);

        //> if already have our number, get data from billet
        if ($agreementInstallment->Nr_NossoNumero != ""){
            $billet = $this->billet->getBillets($debtorId);
            $billet = $this->billet->getBilletsByOurNumber($debtorId, $creditorId, $agreementInstallment->Nr_NossoNumero);
            $billet = $billet[0];
        }else{
            //> if not have our number yet, create new billet
            $billet = $this->create($debtorId, $creditorId, $creditor->Cd_CedenteDefault, $debtorExternalId, $agreement->Nr_Acordo, $agreement->Cd_AcordoExterno, $installmentId, false);
            if ($billet['success'] == false){
                $json = json_encode($billet['return']);
                $error = json_decode($json,TRUE);

                $return['success'] = 0;
                $return['return'] = $error[0];
                return $return;
            }else{
                $billet = $this->billet->getBillet($billet['return']);
            }
        }

        //> Check if email exists
        $email = $this->email->getEmail($debtorId, $emailAddress);
        //> If not exists, store
        if ($email->count() == 0){
            $emailInfo['email-cdDevedor'] = $debtorId;
            $emailInfo['email-dsEmail'] = $emailAddress;
            $emailInfo['email-cdClassificacao'] = 'H';

            $this->email->storeEmail($emailInfo);
        }

        $digitableLine = $billet->Cd_Identificacao;
        $phone = $creditor->cd_0800;
        $phone = str_replace('.', '', $phone);
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);

        $text = 'Boleto ' . $creditor->DS_APELIDO . ' no valor de ' . asCurrency($billet->Vl_Documento) .
                ' Linha digitável ' . substr($digitableLine,0,5)  . '.' .
                                      substr($digitableLine,5,5)  . ' ' .
                                      substr($digitableLine,10,5) . '.' .
                                      substr($digitableLine,15,6) . ' ' .
                                      substr($digitableLine,21,5) . '.' .
                                      substr($digitableLine,26,6) . ' ' .
                                      substr($digitableLine,32,1) . ' ' .
                                      substr($digitableLine,33,14) .
                ' Dúvidas ' . $phone . '.';

        $return = $this->email->sendEmail($emailAddress, $text);

        return $return;
    }

    public function printBillet(Request $request)
    {
        $debtorId = $request->input('debtorId');
        $debtorExternalId = $request->input('debtorExternalId');
        $agreementRequest = $request->input('agreement');
        $agreementInstallmentRequest = $request->input('agreementInstallment');

        $agreementId = $agreementRequest[0]["Nr_Acordo"];
        $installmentId = $agreementInstallmentRequest[0]["Nr_Parcela"];

        $agreement = $this->agreement->getAgreement($debtorId, $agreementId);
        $agreementInstallment = $this->agreementInstallment->getAgreementInstallment($debtorId, $agreementId, $installmentId);
        $creditorId = $agreement->Cd_Credor;
        $creditor = $this->creditor->getCreditor($creditorId);

        //> create new billet
        $billet = $this->create($debtorId, $creditorId, $creditor->Cd_CedenteDefault, $debtorExternalId, $agreement->Nr_Acordo, $agreement->Cd_AcordoExterno, $installmentId, true);
        if ($billet['success'] == false){
            $json = json_encode($billet['return']);
            $error = json_decode($json,TRUE);

            $return['success'] = 0;
            $return['return'] = $error[0];
            $return['file'] = '';
            return $return;
        }

        return $billet;
    }

    private function create($debtorId, $creditorId, $assignorId, $debtorExternalId, $agreementId, $agreementExternalId, $installmentId, $storeFile)
    {
        switch ($creditorId) {
            //> Calcard
            case '5291':
                return $this->getBilletInfoCalcard($debtorId, $creditorId, $assignorId, $debtorExternalId, $agreementId, $agreementExternalId, $installmentId, $storeFile);
                break;
            default:
                $error['success'] = false;
                $error['return'] = 'Credor não está implementado no sistema.';
                return $error;
                break;
        }
    }

    private function getBilletInfoCalcard($debtorId, $creditorId, $assignorId, $debtorExternalId, $agreementId, $agreementExternalId, $installmentId, $storeFile)
    {
        $soap = new SoapCalcardController();
        $response = $soap->emitirBoleto($debtorExternalId, $agreementExternalId, $installmentId);
        //dd($response);

        if ($response['success'] == "true"){
            //> Store billet
            $billetInfo['Cd_Cedente'] = $assignorId;
            $billetInfo['Nr_NossoNumero'] = $response['return']->Boleto->NOSSONUMERO;
            $billetInfo['Cd_Barras'] = $response['return']->Boleto->CODIGO_BARRAS_NUMERO;
            $billetInfo['Cd_Identificacao'] = $response['return']->Boleto->LINHA_DIGITAVEL;
            $billetInfo['Dt_Vencimento'] = $response['return']->Boleto->VENCIMENTO;
            $billetInfo['Dt_Documento'] = $response['return']->Boleto->DATA_DOCUMENTO;
            $billetInfo['Nr_Documento'] = $response['return']->Boleto->NUMERO_DOCUMENTO;
            $billetInfo['Cd_Carteira'] = $response['return']->Boleto->CARTEIRA;
            $billetInfo['Vl_Documento'] = $response['return']->Boleto->VALOR_DOCUMENTO;
            $billetInfo['Cd_Devedor'] = $debtorId;
            $billetInfo['Cd_Operacao'] = '6';
            $billetInfo['Nr_Operacao'] = '0';
            $billetInfo['MM_Texto'] = $response['return']->Boleto->INSTRUCAO_RECIBO_01 . PHP_EOL .
                                      $response['return']->Boleto->INSTRUCAO_RECIBO_02 . PHP_EOL .
                                      $response['return']->Boleto->INSTRUCAO_RECIBO_03 . PHP_EOL .
                                      $response['return']->Boleto->INSTRUCAO_RECIBO_04;
            $billetInfo['Nr_Cedente'] = $response['return']->Boleto->AGENCIA_CEDENTE;
            $billetInfo['Ds_Endereco'] = $response['return']->Boleto->ENDERECO . ', ' .
                                         $response['return']->Boleto->ENDERECO_NUMERO . ' ' .
                                         $response['return']->Boleto->ENDERECO_COMPLEMENTO . ' ' .
                                         $response['return']->Boleto->ENDERECO_BAIRRO . ' CEP:' .
                                         $response['return']->Boleto->ENDERECO_CEP . ' ' .
                                         $response['return']->Boleto->ENDERECO_CIDADE . '/' .
                                         $response['return']->Boleto->ENDERECO_UF;

            $billetInfo['Cd_Aprovacao']	= 'N';
            $billetInfo['Cd_Credor'] = $creditorId;
            $billetInfo['Cd_BoletoExt'] = '3';

            $fileName = '';
            if ($storeFile){
                //> Store billet in server
                $destinationPath = config('app.calcard.destinationPath');
                $fileName = $destinationPath . "/" . 'BOL_'.$debtorId."_".date('dmYHis').".pdf";
                \Storage::disk('public')->put($fileName,base64_decode($response['return']->arquivo->BOLETOEMBASE64));
            }

            //> Check if billet already exists
            $billet = $this->billet->getBilletsByOurNumber($debtorId, $creditorId, $billetInfo['Nr_NossoNumero']);
            //> If billet not exists, store
            if ($billet->count() == 0){
                $billetId = $this->billet->storeBillet($billetInfo);
            }else{
                $billetId = $billet[0]->Nr_Seq;
            }

            //> Update ourNumber of Agreement
            $this->agreementInstallment->updateBilletInfo($debtorId, $agreementId, $installmentId, $billetInfo['Nr_NossoNumero'], $billetInfo['Cd_Cedente']);
            
            $return['success'] = true;
            $return['return'] = $billetId;
            $return['file'] = $fileName;
            return $return;
        }

        return $response;
    }
}
