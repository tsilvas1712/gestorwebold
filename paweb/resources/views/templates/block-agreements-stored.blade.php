<div class="widget-box" >
    <div class="widget-header">
        <h4 class="widget-title">Acordos Gravados</h4>

        <span class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="ace-icon fa fa-chevron-up"></i>
            </a>
        </span>
    </div>

    <div class="widget-body ">
        <div class="widget-main no-padding">
            <table>
                <tr>
                    <td>
                        <div class="col-sm-12 table-responsive no-padding">
                            <table class="table table-striped table-bordered table-selectable" 
                                   id="table-agreements"
                                   data-toggle="table"
                                   data-single-select="true"
                                   data-height="145">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="Nr_Acordo">Nro</th>
                                        <th scope="col" data-field="Ds_Acordo">Descrição</th>
                                        <th scope="col" data-field="Dt_Acordo">Data Acordo</th>
                                        <th scope="col" data-field="Dt_Limite">Data Limite</th>
                                        <th scope="col" data-field="Tp_Acordo">Tp</th>
                                        <th scope="col" data-field="Fl_Acordo">St</th>
                                        <th scope="col" data-field="Dt_Fechamento">Dt. Fechamento</th>
                                        <th scope="col" data-field="Cd_Contrato">Cd. Novação</th>
                                        <th scope="col" data-field="Cd_AcordoExterno">Parc. Ext.</th>
                                        <th scope="col" data-field="Vl_MultaSO">Multa</th>
                                        <th scope="col" data-field="Vl_JurosSO">Juros</th>
                                        <th scope="col" data-field="Vl_TaxaAdmSO">Tx. Adm.</th>
                                        <th scope="col" data-field="Cd_Negociador">Negociador</th>
                                        <th scope="col" data-field="Ds_Observacao">Obs</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($firstId = 0)

                                    @foreach ($agreements as $agreement)
                                        <tr class="{{ ($firstId == 0)?'selected':''}}">
                                            <td>{{$agreement->Nr_Acordo}}</td>
                                            <td>{{$agreement->Ds_Acordo}}</td>
                                            <td>{{asDateTime($agreement->Dt_Acordo)}}</td>
                                            <td>{{asDateTime($agreement->Dt_Limite)}}</td>
                                            <td>{{$agreement->Tp_Acordo}}</td>
                                            <td>{{$agreement->Fl_Acordo}}</td>
                                            <td>{{asDateTime($agreement->Dt_Fechamento)}}</td>
                                            <td>{{$agreement->Cd_Contrato}}</td>
                                            <td>{{$agreement->Cd_AcordoExterno}}</td>
                                            <td>{{asCurrency($agreement->Vl_MultaSO)}}</td>
                                            <td>{{asCurrency($agreement->Vl_JurosSO)}}</td>
                                            <td>{{asCurrency($agreement->Vl_TaxaAdmSO)}}</td>
                                            <td>{{$agreement->Cd_Negociador}}</td>
                                            <td>{{$agreement->Ds_Observacao}}</td>
                                            <td>
                                                @if ($agreement->Fl_Acordo == 'F')
                                                <button type='button' onclick="javascript:agreementCancel({{$agreement->Nr_Acordo}}, '{{$agreement->Cd_AcordoExterno}}');" class='btn btn-xs btn-danger agreement-cancel' data-toggle='tooltip' title='Cancelar acordo'>
                                                    <i class='ace-icon fa fa-ban icon-only'></i> 
                                                </button>                                                        
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            if ($firstId == 0){
                                                $firstId = $agreement->Nr_Acordo;
                                            }
                                        @endphp
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

@push('functions')
    <script>
        var $tableAgreements = $('#table-agreements');
           
        $(function () {
            $tableAgreements.on('click-row.bs.table', function (e, row, $element) {
                //uncheckAll not is working ????????
                //$tableAgreements.bootstrapTable('uncheckAll');
                rows = $tableAgreements.bootstrapTable('getOptions').data.length;
                for (var i = 0; i < rows; i++) {
                    $tableAgreements.bootstrapTable('uncheck', i);
                }
                $tableAgreements.bootstrapTable('check', $element.attr("data-index"));

                $('#table-agreements .selected').removeClass('selected');
                $($element).addClass('selected');
                idAgreement = $($element)[0].firstChild.innerHTML;
                getAgreementInstallment(idAgreement);
                getAgreementOriginal(idAgreement);
            });
        });

        function getAgreementInstallment(idAgreement){
            requestOk = false;

            $('#agreement-intallments').bootstrapTable('destroy');

            var requestInstallment = $.ajax({
                url: "{{url('api/agreement/installment')}}",
                method: "POST",
                data: {
                    debtorId: {{$debtorId}},
                    idAgreement: idAgreement
                },
                dataType: "json"
            });
        
            requestInstallment.done(function( ret ) {
                json = ret;
                if (json != ""){
                    requestOk = true;
                }else{
                    showMessage("Nenhuma parcela encontrado.");
                    return false;
                }
            });
        
            requestInstallment.fail(function( jqXHR, textStatus ) {
                showMessage("Erro ao abrir parcelas. Tente novamente.");
                return false;
            });

            requestInstallment.always(function() {
                if (requestOk) {
                    $('#agreement-intallments').bootstrapTable({
                        data: json
                    });
                }
            });
        }

        function getAgreementOriginal(idAgreement){
            requestOk = false;

            $('#agreement-originals').bootstrapTable('destroy');

            var requestInstallment = $.ajax({
                url: "{{url('api/agreement/original')}}",
                method: "POST",
                data: {
                    debtorId: {{$debtorId}},
                    idAgreement: idAgreement
                },
                dataType: "json"
            });
        
            requestInstallment.done(function( ret ) {
                json = ret;
                if (json != ""){
                    requestOk = true;
                }else{
                    showMessage("Nenhuma contrato encontrado.");
                    return false;
                }
            });
        
            requestInstallment.fail(function( jqXHR, textStatus ) {
                showMessage("Erro ao abrir originais. Tente novamente.");
                return false;
            });

            requestInstallment.always(function() {
                if (requestOk) {
                    $('#agreement-originals').bootstrapTable({
                        data: json
                    });
                }
            });
        }

        function agreementCancel(agreementId, agreementExternalId){
            bootbox.confirm({
                message: "Confima o cancelamento deste acordo?",
                buttons: {
                    confirm: {
                        label: 'Sim',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'Não',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if (result){
                        agreementCancelConfirm(agreementId, agreementExternalId);
                    }
                }
            });
        }

        function agreementCancelConfirm(agreementId, agreementExternalId){
            showLoader("Cancelando acordo...");
            debtorExternalId = $('#agreement-originals').bootstrapTable('getData')[0].Cd_DevCre;
            creditorId = $('#agreement-originals').bootstrapTable('getData')[0].Cd_Credor;

            if (creditorId == 'undefined'){
                showMessage("Selecione qual acordo deseja cancelar.");
                return false;
            }

            var requestAgreementCancel = $.ajax({
                url: "{{url('api/agreement/cancel')}}",
                method: "POST",
                data: {
                    debtorId: {{$debtorId}},
                    debtorExternalId: debtorExternalId,
                    agreementId: agreementId,
                    agreementExternalId: agreementExternalId,
                    creditorId: creditorId
                },
                dataType: "text"
            });
        
            requestAgreementCancel.done(function( ret ) {
                if (ret == '1'){
                    showConfirm("Cancelamento efetuado com sucesso.");
                    location.reload();
                }else{
                    showError("Erro ao solicitar cancelamento.", ret);
                }
            });
        
            requestAgreementCancel.fail(function( jqXHR, textStatus ) {
                showMessage("Erro ao solicitar cancelamento.. Tente novamente.<br>"+textStatus);
                return false;
            });

            requestAgreementCancel.always(function( ) {
                hideLoader();
            });
        }

        @if ($firstId > 0)
            $(window).on('load', function() {
                $('#table-agreements').bootstrapTable('check', 0);
   
                getAgreementInstallment({{$firstId}});
                getAgreementOriginal({{$firstId}});
            });
        @endif

    </script>
@endpush