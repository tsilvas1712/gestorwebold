@extends('templates.main')

@section('content')
    <form class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="col-sm-4 no-padding-left">
                    <div class="widget-box" >
                        <div class="widget-header">
                            <h4 class="widget-title">Parcelas do acordo</h4>
                            <div style="float:right">
                                <a class="btn btn-xs btn-success" disabled style="cursor: default; font-size:15px;">
                                    <i class="menu-icon fa fa-check-square-o"></i>
                                </a>
                            </div>

                            <span class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-up"></i>
                                </a>
                            </span>
                        </div>

                        <div class="widget-body ">
                            <div class="widget-main no-padding">
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <div class="col-sm-12 table-responsive no-padding">
                                                <table class="table centered table-striped table-bordered"
                                                        data-toggle="table"
                                                        data-height="145">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Parc.</th>
                                                            <th scope="col">Vencimento</th>
                                                            <th scope="col">Valor</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($simulationInstallments as $simulationInstallment)
                                                        <tr>
                                                            <td>{{$simulationInstallment->Nr_Parcela}}</td>
                                                            <td>{{asDate($simulationInstallment->Dt_Vencimento)}}</td>
                                                            <td>{{asCurrency($simulationInstallment->Vl_Parcela)}}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    @include('templates.block-telephones')
                </div>
                
                <div class="col-sm-4 no-padding-right">
                    @include('templates.block-emails')
                </div>
            </div>
            
            <div class="col-sm-12 space-4"></div>

            <div class="col-sm-12">
                <div class="widget-box" >
                    <div class="widget-header">
                        <h4 class="widget-title">Endereços</h4>
            
                        <div style="float:right">
                            <a href="#modal-address-add" class="btn btn-primary btn-xs" role="button" data-toggle="modal">
                                <i class="ace-icon fa fa-plus-circle"></i>
                                Add
                            </a>
                        </div>
                    
                        <span class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-up"></i>
                            </a>
                        </span>
                    </div>
            
                    <div class="widget-body">
                        <div class="widget-main no-padding">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <div class="col-sm-12 table-responsive no-padding">
                                            <table class="table table-striped table-bordered" 
                                                   id="table-agreement-address"
                                                   data-toggle="table" 
                                                   data-height="145">
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="true" scope="col">Rua</th>
                                                        <th data-sortable="true" scope="col">Nº</th>
                                                        <th data-sortable="true" scope="col">Complemento</th>
                                                        <th data-sortable="true" scope="col">Bairro</th>
                                                        <th data-sortable="true" scope="col">Cidade</th>
                                                        <th data-sortable="true" scope="col">UF</th>
                                                        <th data-sortable="true" scope="col">CEP</th>
                                                        <th data-sortable="true" scope="col">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($addresses as $address)
                                                    <tr>
                                                        <td>{{$address->Ds_Logradouro}}</td>
                                                        <td>{{$address->Ds_NumeroEnd}}</td>
                                                        <td>{{$address->Ds_Complemento}}</td>
                                                        <td>{{$address->Ds_Bairro}}</td>
                                                        <td>{{$address->Ds_Cidade}}</td>
                                                        <td>{{$address->Sg_UF}}</td>
                                                        <td>{{$address->Cd_Cep}}</td>
                                                        <td>
                                                            <select class="col-sm-12 no-padding select-address-level" id="address-level-{{trim($address->Cd_Endereco)}}" 
                                                                    data-placeholder="Selecione..." 
                                                                    data-address-id="{{trim($address->Cd_Endereco)}}"
                                                                    data-altered="false"
                                                                    onchange="markAlterAddress(this);">
                                                                @if (isset($addressLevels))
                                                                    @foreach ($addressLevels as $addressLevel)
                                                                        <option value="{{$addressLevel->cd_classificacao}}" @if($address->Cd_Classificacao == $addressLevel->cd_classificacao) {{"selected"}} @endif>
                                                                            {{$addressLevel->ds_classificacao}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix form-actions">
            <div class="col-md-6">
                <div class="col-md-offset-4 col-md-4">
                    <a href="#" id="agreement-save" class="btn btn-block btn-primary" type="button">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Gravar Acordo
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-offset-4 col-md-4">
                    <a href="{{url('/debtor')}}/{{$debtorId}}" class="btn btn-block btn-danger col-md-6">
                        <i class="ace-icon fa fa-times bigger-110"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>    
    </form>
@endsection

@push('functions')
    <script>
        var telephoneOK;
        var emailOK;
        var addressOK;

        function checkTelephones(){
            //> Check telephones
            $('.select-telephone-level').each(function () {
                if ( ($(this).val() == 'P') || ($(this).val() == 'N') || ($(this).val() == 'A') ){
                    telephoneOK = false;
                    showMessage('Antes de gravar o acordo é necessário validar todos os <b>telefones</b> com a classificação "PESQUISADO", "NÃO VALIDADO" ou "ATENDIMENTO ELETRÔNICO".')
                    return false;
                }
            });

            return true;
        }

        function checkEmails(){
            //> Check emails
            $('.select-email-level').each(function () {
                if ( $(this).val() == 'N'){
                    emailOK = false;
                    showMessage('Antes de gravar o acordo é necessário validar todos os <b>emails</b> com a classificação "NÃO CLASSIFICADO".')
                    return false;
                }
            });

            return true;
        }

        function checkAddresses(){
            //> Check address
            $('#table-agreement-address .select-address-level').each(function () {
                if ( $(this).val() == 'N'){
                    addressOK = false;
                    showMessage('Antes de gravar o acordo é necessário validar todos os <b>endereços</b> com a classificação "NÃO CLASSIFICADO".')
                    return false;
                }
            });
        }

        $("#agreement-save").click(function(){
            telephoneOK = true;
            emailOK = true;
            addressOK = true;

            $.when(
                checkTelephones(),
                checkEmails(),
                checkAddresses()
            ).then(
                agreementSave()
            );
        });

        function agreementSave(){
            if (telephoneOK && emailOK && addressOK){
                showLoader("Gravando acordo...");
                var telephones = [];
                var emails = [];
                var addresses = [];

                $('.select-telephone-level.select-altered').each(function () {
                    telephones.push({
                                        number: $(this).attr('data-telephone'), 
                                        areaCode: $(this).attr('data-areacode'), 
                                        status: $(this).val(),
                                    });
                });

                $('.select-email-level.select-altered').each(function () {
                    emails.push({
                                    email: $(this).attr('data-email'), 
                                    status: $(this).val(),
                                });
                });

                $('#table-agreement-address .select-address-level.select-altered').each(function () {
                    addresses.push({
                                        id: $(this).attr('data-address-id'), 
                                        status: $(this).val(),
                                    }
                                );
                });

                var requestAgreementConfirm = $.ajax({
                    url: "{{url('api/agreement/store')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                        telephones: telephones,
                        emails: emails,
                        addresses: addresses,
                    },
                    dataType: "json"
                });
            
                requestAgreementConfirm.done(function( ret ) {
                    console.log(ret);
                    if (ret.success == 1){
                        requestOk = true;
                        if (ret.sms == 1){
                            showConfirm('SMS', 'SMS enviado com sucesso.' );
                        }else{
                            showError('SMS', 'SMS não enviado.' );
                        }

                        if (ret.whatsapp == 1){
                            showConfirm('Whatsapp', 'Whatsapp enviado com sucesso.' );
                        }else{
                            showError('Whatsapp', 'Whatsapp não enviado.' );
                        }

                        if (ret.email == 1){
                            showConfirm('Email', 'Email enviada com sucesso.' );
                        }else{
                            showError('Email', 'Email não enviado.' );
                        }

                    }else{
                        if (typeof ret.return == 'object'){
                            showMessage(ret.return[0]);
                        }else{
                            showMessage(ret.return);
                        }
                        return false;
                    }
                });
            
                requestAgreementConfirm.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao gravar acordo. Tente novamente.");
                    return false;
                });

                requestAgreementConfirm.always(function() {
                    hideLoader();
                });

            }
        }
    </script>
@endpush