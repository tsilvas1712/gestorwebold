<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Soap\SoapCalcardController;
use App\Models\Creditor;
use App\Models\Simulation;
use App\Models\SimulationInstallment;
use App\Models\SimulationOriginal;

class EstimateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.ldap');
    }

    private function callSimulationCalcard($request, $manual)
    {
        $debtorId = $request->input('debtorId');
        $contractRequest = $request->input('contract');
        $creditorId = $contractRequest[0]['Cd_Credor'];
        $firstRow = 0;
        //> If creditor row
        if ( ($contractRequest[$firstRow]["Cd_Especie"] == "") || ($contractRequest[$firstRow]["Cd_Especie"] == "&nbsp;") ){
            $firstRow = 1;
        }

        if ($manual == 1){
            $downpayment = $request->input('downpayment');
            $plan = $request->input('plan');
            $paydate = $request->input('paydate');
            $discount = $request->input('discount');
        }else{
            $creditor = new creditor();
            $creditor = $creditor->getCreditor($creditorId);
            $downpayment = 0;
            $paydate = date("Y-m-d");
        
            $option = $request->input('opt');
            switch ($option) {
                case 1:
                    $plan = $creditor->Qt_Parcelas_Opc1;
                    $discount = $creditor->Al_Desconto_Opc1;
                    break;
                case 2:
                    $plan = $creditor->Qt_Parcelas_Opc2;
                    $discount = $creditor->Al_Desconto_Opc2;
                    break;
                case 3:
                    $plan = $creditor->Qt_Parcelas_Opc3;
                    $discount = $creditor->Al_Desconto_Opc3;
                    break;
                case 4:
                    $plan = $creditor->Qt_Parcelas_Opc4;
                    $discount = $creditor->Al_Desconto_Opc4;
                    break;
                default:
                    $plan = 0;
                    $discount = 0;
                    break;
            }
        }

        $soap = new SoapCalcardController();
        $response = $soap->calcularAcordo($debtorId, $contractRequest, $downpayment, $plan, $paydate, $discount);

        if ($response['success'] == "true"){           
            $xml_return = $response['return']->asXML();
            $xml_return = str_replace('<?xml version="1.0"?>', '', $xml_return);

            $debtorExternalId = str_pad($response['return']->IdCliente, 10, "0", STR_PAD_LEFT);

            //> Store simulation
            $simulation = new Simulation();
            $simulationId = $simulation->storeSimulation($debtorExternalId, $creditorId, $downpayment, $plan, $paydate, $discount, $xml_return);
            $response['simulationid'] = Crypt::encrypt($simulationId);

            //> Store simulation installment
            foreach ($response['return']->ParcelasAcordo->ParcelaAcordo as $item) {
                $simulationInstallment = new SimulationInstallment();
                $simulationInstallment->storeSimulationInstallment($simulationId, $item->Parcela, $item->DataParcela, $item->ValorParcela);
            }

            //> Store simulation originals
            //> Do loop for store originals
            for ($i = $firstRow; $i < sizeof($contractRequest); $i++) {
                $contractId = $contractRequest[$i]["Cd_Contrato"];
                $installmentId = $contractRequest[$i]["Nr_Parcela"];
                $dueDate = $contractRequest[$i]["Dt_Vencimento"];

                $simulationOriginal = new SimulationOriginal();
                $simulationOriginal->storeSimulationOriginal($simulationId, $contractId, $installmentId, $dueDate);
            }
        }
        
        return $response;
    }


    private function callSimulationTim($request, $manual)
    {
        echo "ADNOASLNDLNAS";

        $debtorId = $request->input('debtorId');
        $contractRequest = $request->input('contract');
        $creditorId = $contractRequest[0]['Cd_Credor'];
        $firstRow = 0;
        //> If creditor row
        if ( ($contractRequest[$firstRow]["Cd_Especie"] == "") || ($contractRequest[$firstRow]["Cd_Especie"] == "&nbsp;") ){
            $firstRow = 1;
        }

        if ($manual == 1){
            $downpayment = $request->input('downpayment');
            $plan = $request->input('plan');
            $paydate = $request->input('paydate');
            $discount = $request->input('discount');
        }else{
            $creditor = new creditor();
            $creditor = $creditor->getCreditor($creditorId);
            $downpayment = 0;
            $paydate = date("Y-m-d");
        
            $option = $request->input('opt');
            switch ($option) {
                case 1:
                    $plan = $creditor->Qt_Parcelas_Opc1;
                    $discount = $creditor->Al_Desconto_Opc1;
                    break;
                case 2:
                    $plan = $creditor->Qt_Parcelas_Opc2;
                    $discount = $creditor->Al_Desconto_Opc2;
                    break;
                case 3:
                    $plan = $creditor->Qt_Parcelas_Opc3;
                    $discount = $creditor->Al_Desconto_Opc3;
                    break;
                case 4:
                    $plan = $creditor->Qt_Parcelas_Opc4;
                    $discount = $creditor->Al_Desconto_Opc4;
                    break;
                default:
                    $plan = 0;
                    $discount = 0;
                    break;
            }
        }

        //$soap = new SoapCalcardController();
        //$response = $soap->calcularAcordo($debtorId, $contractRequest, $downpayment, $plan, $paydate, $discount);

        /*if ($response['success'] == "true"){           
            $xml_return = $response['return']->asXML();
            $xml_return = str_replace('<?xml version="1.0"?>', '', $xml_return);

            $debtorExternalId = str_pad($response['return']->IdCliente, 10, "0", STR_PAD_LEFT);

            //> Store simulation
            $simulation = new Simulation();
            $simulationId = $simulation->storeSimulation($debtorExternalId, $creditorId, $downpayment, $plan, $paydate, $discount, $xml_return);
            $response['simulationid'] = Crypt::encrypt($simulationId);

            //> Store simulation installment
            foreach ($response['return']->ParcelasAcordo->ParcelaAcordo as $item) {
                $simulationInstallment = new SimulationInstallment();
                $simulationInstallment->storeSimulationInstallment($simulationId, $item->Parcela, $item->DataParcela, $item->ValorParcela);
            }

            //> Store simulation originals
            //> Do loop for store originals
            for ($i = $firstRow; $i < sizeof($contractRequest); $i++) {
                $contractId = $contractRequest[$i]["Cd_Contrato"];
                $installmentId = $contractRequest[$i]["Nr_Parcela"];
                $dueDate = $contractRequest[$i]["Dt_Vencimento"];

                $simulationOriginal = new SimulationOriginal();
                $simulationOriginal->storeSimulationOriginal($simulationId, $contractId, $installmentId, $dueDate);
            }
        }*/
        
        return $response;
    }

    private function callSimulation($request)
    {
        $manual = $request->input('manual');
        $contractRequest = $request->input('contract');
        $creditorId = $contractRequest[0]['Cd_Credor'];

        //> Get params from creditor
        $creditor = new creditor();
        $creditor = $creditor->getCreditor($creditorId);

        //> Check qty max installments
        if ($request->input('plan') > $creditor->Nr_MaxParcelasAcordo){
            $return['success'] = false;
            $return['return'] = "O número máximo de parcelas neste credor é [{$creditor->Nr_MaxParcelasAcordo}].";

            return $return;
        }

        //> Check qty days to paydate
        $today = new \DateTime();
        $payDate = new \DateTime($request->input('paydate'));
        $dateDiff = ($today->diff( $payDate )->days) + 1;
        if ($dateDiff > $creditor->Nr_DiasEntrada){
            $return['success'] = false;
            $return['return'] = "A quantidade máxima de dias para a entrada neste credor é [{$creditor->Nr_DiasEntrada}].";

            return $return;
        }
       
        switch ($creditorId) {
            //> Calcard
            case '5291':
                $simulation = $this->callSimulationCalcard($request, $manual);
                break;
            case '3172':
                $simulation = $this->callSimulationTim($request, $manual);
                break;
            default:
                $error['success'] = false;
                $error['return'] = 'Credor não está implementado no sistema.';
                return $error;
                break;
        }

        if ($simulation['success']){
            //> Check min value of each installment
            if ($request->input('plan') > 1){
                foreach ($simulation['return']->ParcelasAcordo->ParcelaAcordo as $item) {
                    if ($item->ValorParcela < $creditor->Vl_MinParcelaAcordo){
                        $error['success'] = false;
                        $error['return'] = "O valor mínimo da parcela neste credor é [" . asCurrency($creditor->Vl_MinParcelaAcordo) . "].<br>Porém a parcela {$item->Parcela} ficou em " . asCurrency($item->ValorParcela) . ".";
                        return $error;        
                    }
                }
            }
        }

        return $simulation;
    }

    public function create(Request $request)
    {
        return $this->callSimulation($request, true);
    }

    public function get(Request $request)
    {
        $simulationId = $request->input('simulationId');
        $simulationId = Crypt::decrypt($simulationId);

        if ( ($simulationId == null) || ($simulationId == '') || ($simulationId == '0') ){
            return response('Parâmetros não informados corretamente.',400);
        }else{
            $simulation = new Simulation();
            return $simulation->getSimulation($simulationId);
        }
    }

}
