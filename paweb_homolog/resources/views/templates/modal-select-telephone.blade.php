    <div id="modal-select-telephone" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Selecione o telefone</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="widget-box" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Telefones</h4>
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
                                                               id="select-telephones"
                                                               data-toggle="table" 
                                                               data-height="325">
                                                            <thead>
                                                                <tr>
                                                                    <th class="col-md-1" scope="col" data-formatter="tableSendTelephoneFormat">&nbsp;</th>
                                                                    <th scope="col" data-field="Cd_DDD">DDD</th>
                                                                    <th scope="col" data-field="Cd_Telefone">Telefone</th>
                                                                    <th scope="col" data-field="Cd_Classificacao">Classif.</th>
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

                            <div class="input-group no-padding" data-toggle="tooltip" title="Informe um novo telefone<br>Digite DDD+telefone sem espaços">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-plus-circle"></i>
                                </span>
                                
                                <input type="hidden" id="typeSend">
                                <input type="number" id="telephone-new-number" min="11900000000" max="99999999999" class="form-control search-query" placeholder="Novo telefone">
                                <span class="input-group-btn">
                                    <button type="button" id="telephone-add-send" class="btn btn-success btn-sm">
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
            $( "#telephone-add-send" ).click(function() {
                number = $("#telephone-new-number").val();
                if ($.trim(number) == ''){
                    showMessage('Informe um número de telefone válido');
                    return false;
                }
                areaCode = number.substr(0, 2);
                number = number.substr(2, 9);

                bootbox.confirm({
                    message: "Confima o envio para o telefone <b>(" + $.trim(areaCode) + ")</b> <b>" + $.trim(number) + "</b>?",
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
                            sendBilletMessage(areaCode, number);
                        }
                    }
                });
            });

            $('#modal-select-telephone').on('show.bs.modal', function(e) {
                var typeSend = $(e.relatedTarget).data('type');
                $("#typeSend").val(typeSend);
            });

            var $tableSmsWhats = $('#select-telephones');
            
            $(function () {
                $tableSmsWhats.on('click-row.bs.table', function (e, row, $element) {
                    $('#select-telephones').bootstrapTable('check', $element.attr("data-index"));
                    
                    $('#select-telephones .selected').removeClass('selected');
                    $($element).addClass('selected');
                    areaCode = $($element)[0].childNodes[1].innerHTML;
                    number = $($element)[0].childNodes[2].innerHTML;

                    bootbox.confirm({
                        message: "Confima o envio para o telefone <b>(" + $.trim(areaCode) + ")</b> <b>" + $.trim(number) + "</b>?",
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
                                sendBilletMessage(areaCode, number);
                            }
                        }
                    });
                });
            });

            function sendBilletMessage(areaCode, number){
                showLoader("Enviado mensagem...");
                
                agreement = $('#table-agreements').bootstrapTable('getSelections');
                agreementInstallment = $('#agreement-intallments').bootstrapTable('getSelections');
                debtorExternalId = $('#agreement-originals').bootstrapTable('getData')[0].Cd_DevCre;

                var requestBilletMessage = $.ajax({
                    url: "{{url('api/billet/message')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                        debtorExternalId: debtorExternalId,
                        agreement: agreement,
                        agreementInstallment: agreementInstallment,
                        areaCode: areaCode, 
                        number: number,
                        type: $('#typeSend').val().toLowerCase()
                    },
                    dataType: "json"
                });
            
                requestBilletMessage.done(function( ret ) {
                    if (ret.success == 1){
                        showConfirm("Mensagem enviada com sucesso.");
                    }else{
                        showError("Erro ao enviar mensagem", ret.return);
                    }
                });
            
                requestBilletMessage.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao enviar mensagem. Tente novamente.");
                    return false;
                });

                requestBilletMessage.always(function( ) {
                    hideLoader();
                });

            }

            function getTelephones(){
                requestOk = false;

                $('#select-telephones').bootstrapTable('destroy');

                var requestTelephones = $.ajax({
                    url: "{{url('api/telephone/get')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                        type: 'M'
                    },
                    dataType: "json"
                });
            
                requestTelephones.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }
                });
            
                requestTelephones.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao buscar telefones. Tente novamente.");
                    return false;
                });

                requestTelephones.always(function() {
                    if (requestOk) {
                        $('#select-telephones').bootstrapTable({
                            data: json
                        });
                    }
                });
            }
        </script>
    @endpush
