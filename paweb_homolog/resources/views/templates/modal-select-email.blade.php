    <div id="modal-select-email" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Selecione o email</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="widget-box" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Emails</h4>
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
                                                                data-toggle="table" 
                                                                id ="select-emails"
                                                                data-height="325">
                                                            <thead>
                                                                <tr>
                                                                    <th class="col-md-1" scope="col" data-formatter="tableSendEmailFormat">&nbsp;</th>
                                                                    <th scope="col" data-field="Ds_Email">Endereço de Email</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group no-padding" data-toggle="tooltip" title="Informe um novo email">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                </span>

                                <input type="email" id="email-new-address" class="form-control search-query" placeholder="Novo email">
                                <span class="input-group-btn">
                                    <button type="button" id="email-add-send" class="btn btn-success btn-sm">
                                        <i class="ace-icon fa fa-paper-plane"></i>
                                        Enviar
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('functions')
        <script>
            $( "#email-add-send" ).click(function() {
                email = $("#email-new-address").val();
                if ($.trim(email) == ''){
                    showMessage('Informe um email válido');
                    return false;
                }

                bootbox.confirm({
                    message: "Confima o envio para o endereço <b>(" + $.trim(email) + ")</b>?",
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
                            sendBilletEmail(email);
                        }
                    }
                });
            });

            var $tableEmail = $('#select-emails');
            
            $(function () {
                $tableEmail.on('click-row.bs.table', function (e, row, $element) {
                    $('#select-emails').bootstrapTable('check', $element.attr("data-index"));
                    
                    $('#select-emails .selected').removeClass('selected');
                    $($element).addClass('selected');
                    email = $($element)[0].childNodes[1].innerHTML;

                    bootbox.confirm({
                        message: "Confima o envio para o endereço <b>(" + $.trim(email) + ")</b>?",
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
                                sendBilletEmail(email);
                            }
                        }
                    });
                });
            });

            function sendBilletEmail(email){
                showLoader("Enviado Email...");

                agreement = $('#table-agreements').bootstrapTable('getSelections');
                agreementInstallment = $('#agreement-intallments').bootstrapTable('getSelections');
                debtorExternalId = $('#agreement-originals').bootstrapTable('getData')[0].Cd_DevCre;

                var requestBilletEmail = $.ajax({
                    url: "{{url('api/billet/email')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                        debtorExternalId: debtorExternalId,
                        agreement: agreement,
                        agreementInstallment: agreementInstallment,
                        email: email
                    },
                    dataType: "json"
                });
            
                requestBilletEmail.done(function( ret ) {
                    if (ret.success == 1){
                        showConfirm("Email enviado com sucesso.");
                    }else{
                        showError("Erro ao enviar email", ret.return);
                    }
                });
            
                requestBilletEmail.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao enviar email. Tente novamente.");
                    return false;
                });

                requestBilletEmail.always(function( ) {
                    hideLoader();
                });
            }

            function getEmails(){
                requestOk = false;

                $('#select-emails').bootstrapTable('destroy');

                var requestEmails = $.ajax({
                    url: "{{url('api/email/get')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                    },
                    dataType: "json"
                });
            
                requestEmails.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }
                });
            
                requestEmails.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao buscar emails. Tente novamente.");
                    return false;
                });

                requestEmails.always(function() {
                    if (requestOk) {
                        $('#select-emails').bootstrapTable({
                            data: json
                        });
                    }
                });
            }
        </script>
    @endpush
