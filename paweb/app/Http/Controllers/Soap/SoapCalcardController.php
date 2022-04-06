<?php

namespace App\Http\Controllers\Soap;
use App\Models\Contract;
use Artisaninweb\SoapWrapper\SoapWrapper;

class SoapCalcardController
{
    /**
     * @var SoapWrapper
     */
    protected $soapWrapper;
    protected $creditorId = '5291';

    /**
     * SoapController constructor.
     *
     * @param SoapWrapper $soapWrapper
     */
    public function __construct()
    {
        $this->soapWrapper = new SoapWrapper();

        $this->soapWrapper->add('SoapCalcard', function ($service) {
            $service->wsdl(config('app.calcard.soap.wsdl'))
                    ->trace(true);
          });  
    }

    /**
     * Use the SoapWrapper
     */
    public function calcularAcordo($debtorId, $contractRequest, $downpayment, $plan, $paydate, $discount)
    {
        $firstRow = 0;
        $countRows = 0;

        //> If creditor row
        if ( ($contractRequest[$firstRow]["Cd_Especie"] == "") || ($contractRequest[$firstRow]["Cd_Especie"] == "&nbsp;") ){
            $firstRow = 1;
        }

        $contractId = $contractRequest[$firstRow]["Cd_Contrato"];
        $installmentId = $contractRequest[$firstRow]["Nr_Parcela"];
        $dueDate = $contractRequest[$firstRow]["Dt_Vencimento"];

        $contracts = new Contract();
        $contract = $contracts->getContract($debtorId, 5291, $contractId, $installmentId, $dueDate);

        $idCliente = trim($contract->Cd_DevCre);
        $DividaAtiva = [];

        //> Do loop for generate "DividaAtiva" Node
        for ($i = $firstRow; $i < sizeof($contractRequest); $i++) {
            $countRows++;
            $contractId = $contractRequest[$i]["Cd_Contrato"];
            $installmentId = $contractRequest[$i]["Nr_Parcela"];
            $dueDate = $contractRequest[$i]["Dt_Vencimento"];
    
            $contract = $contracts->getContract($debtorId, 5291, $contractId, $installmentId, $dueDate);

            $DividaAtiva[] = [
                    'Marcado' => 'true',
                    'TipoDivida' => 'Original',
                    'DataPagamento' => $paydate,
                    'IdCliente' => trim($contract->Cd_DevCre),
                    'IdContrato' => trim($contract->Nr_Documento),
                    'DividaCedente' => trim($contract->Ds_UsoCliente)
            ];
        }

        if ($countRows > 1){
            $return['success'] = false;
            $return['return'] = 'Este credor não permite simulação envolvendo mais de 1 contrato.';
            return $return;
        }
        $xml_divida_ativa = new \SimpleXMLElement('<?xml version="1.0"?><ArrayOfDividaAtiva></ArrayOfDividaAtiva>');
        array_to_xml($DividaAtiva, $xml_divida_ativa, 'DividaAtiva');
        
        $string_divida_ativa = $xml_divida_ativa->asXML();
        $string_divida_ativa = str_replace('<?xml version="1.0"?>', '', $string_divida_ativa);

        $params = [
            'CalcularAcordo' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $idCliente,
                    'plano' => $plan,
                    'dataEntrada' => $paydate . "T00:00:00.000Z",
                    'valorEntradaDiferenciada' => $downpayment,
                    'percentualDesconto' => $discount,
                    'taxaJuros' => 0,
                    'tipoCalculo' => 0,
                    'dividaXml' => $string_divida_ativa
            ]
        ];

        try {
            $response = $this->soapWrapper->call('SoapCalcard.CalcularAcordo', $params);
            $xml = new \SimpleXMLElement($response->CalcularAcordoResult);

            $error = $xml->Mensagem;

            if ( ($error) && ($error !== '') ) {
                $return['success'] = false;
                $return['return'] = "Plano [{$plan}] {$error}";
            }else{
                $return['success'] = true;
                $return['return'] = $xml;    
            }
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['return'] = "Exception Error: Plano [{$plan}]" . $e->getMessage();
        }

        return $return;
    }

    public function emitirBoleto($debtorExternalId, $agreementExternalId, $installmentId)
    {
        $params = [
            'EmitirBoleto' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $debtorExternalId,
                    'idAcordo' => $agreementExternalId,
                    'parcela'=>  $installmentId,
                    'TipoArquivoRetorno' => 'PDF',
            ]
        ];

        try {
            $response = $this->soapWrapper->call('SoapCalcard.EmitirBoleto', $params);
            $xml = new \SimpleXMLElement($response->EmitirBoletoResult);

            $error = $xml->Mensagem;

            if ( ($error) && ($error !== '') ) {
                $return['success'] = false;
                $return['return'] = $error;
            }else{
                $return['success'] = true;
                $return['return'] = $xml;    
            }
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['return'] = "Exception Error: " . $e->getMessage();
        }

        return $return;
    }

    public function cancelarAcordo($debtorExternalId, $agreementExternalId)
    {
        $params = [
            'CancelarAcordo' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $debtorExternalId,
                    'idAcordo' => $agreementExternalId
            ]
        ];

        try {
            $response = $this->soapWrapper->call('SoapCalcard.CancelarAcordo', $params);
            
            if (strpos($response->CancelarAcordoResult, 'RetornoErro') === false){
                $return = 1;

                return $return;
            }

            $xml = new \SimpleXMLElement($response->CancelarAcordoResult);

            $error = $xml->Mensagem;

            if ( ($error) && ($error !== '') ) {
                $return = $error;
            }else{
                $return = $xml;
            }
        } catch (\Exception $e) {
            $return = "Exception Error: " . $e->getMessage();
        }

        return $return;
    }

    public function confirmarAcordo($debtorExternalId, $simulationReturn)
    {
        $simulationReturn = str_replace("\n", '', $simulationReturn);
        //dd($simulationReturn);
        $params = [
            'ConfirmarAcordo' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $debtorExternalId,
                    //'acordoXml' => '<![CDATA['.$simulationReturn.']]>',
                    'acordoXml' => $simulationReturn,
            ]
        ];

        //dd($params);

        try {
            $response = $this->soapWrapper->call('SoapCalcard.ConfirmarAcordo', $params);

            if (strpos($response->ConfirmarAcordoResult, 'RetornoErro') === false){
                $return['success'] = true;
                $return['return'] = $response->ConfirmarAcordoResult;

                return $return;
            }
            $xml = new \SimpleXMLElement($response->ConfirmarAcordoResult);

            $error = $xml->Mensagem;

            if ( ($error) && ($error !== '') ) {
                $return['success'] = false;
                $return['return'] = $error;
            }else{
                $return['success'] = true;
                $return['return'] = $xml;    
            }
        } catch (\Exception $e) {
            $return['success'] = false;
            $return['return'] = "Exception Error: " . $e->getMessage();
        }

        return $return;
    }

    public function inserirAcao($debtorExternalId, $historyExternalId, $historyText, $areaCode, $phoneNumber)
    {
        $areaCode = '51';
        $phoneNumber = '30249600';

        $params = [
            'InserirAcao' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $debtorExternalId,
                    'idAcao' => $historyExternalId,
                    'descricaoAcao' => $historyText,
                    'ddd' => $areaCode,
                    'telefone' => $phoneNumber
            ]
        ];

        try {
            $response = $this->soapWrapper->call('SoapCalcard.InserirAcao', $params);
            
            if (strpos($response->InserirAcaoResult, 'RetornoErro') === false){
                return 1;
            }else{
                return 0;
            }
        } catch (\Exception $e) {
            $return = "Exception Error: " . $e->getMessage();
        }

        return $return;
    }

    public function inserirAcaoComDetalhe($debtorExternalId, $historyExternalId, $historyText, $areaCode, $phoneNumber, $payDate)
    {
        $areaCode = '51';
        $phoneNumber = '30249600';

        $AcaoDetalheWebService = [];

        $AcaoDetalheWebService[] = [
            'NomeDetalhe' => 'ASS-DATA PAGAMENTO',
            'ValorDetalhe' => formatDateYYYYMMDD_DDMMYYYY($payDate)
        ];

        $xml_acao_detalhe = new \SimpleXMLElement('<?xml version="1.0"?><ArrayOfAcaoDetalheWebService></ArrayOfAcaoDetalheWebService>');
        array_to_xml($AcaoDetalheWebService, $xml_acao_detalhe, 'AcaoDetalheWebService');

        $string_acao_detalhe = $xml_acao_detalhe->asXML();
        $string_acao_detalhe = str_replace('<?xml version="1.0"?>', '', $string_acao_detalhe);

        $params = [
            'InserirAcaoComDetalhe' =>[ 
                    'logonUsuario' => config('app.calcard.soap.user'), 
                    'senhaUsuario' => config('app.calcard.soap.password'), 
                    'idCliente' => $debtorExternalId,
                    'idAcao' => $historyExternalId,
                    'descricaoAcao' => $historyText,
                    'ddd' => $areaCode,
                    'telefone' => $phoneNumber,
                    'detalhesXml' => $string_acao_detalhe
            ]
        ];

        try {
            $response = $this->soapWrapper->call('SoapCalcard.InserirAcaoComDetalhe', $params);

            if (strpos($response->InserirAcaoComDetalheResult, 'RetornoErro') === false){
                return 1;
            }else{
                return 0;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            $return = "Exception Error: " . $e->getMessage();
        }

        return $return;
    }
}