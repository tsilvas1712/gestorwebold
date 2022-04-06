    <div id="modal-print-billet" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Imprimir Boleto</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            Confirma a impressão do boleto?
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="confirm-print-billet" class="btn btn-sm btn-primary" >
                        <i class="ace-icon fa fa-save"></i>
                        Imprimir
                    </button>
            
                    <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancelar
                    </a>
                </div>

                <form id="form-print-billet" action="" target="_blank">
                </form>

            </div>
        </div>
    </div>


    @push('functions')
        <script>
            $( "#confirm-print-billet" ).click(function() {
                printBillet();
            });

            function printBillet(){
                showLoader("Abrindo boleto...");
                
                agreement = $('#table-agreements').bootstrapTable('getSelections');
                agreementInstallment = $('#agreement-intallments').bootstrapTable('getSelections');
                debtorExternalId = $('#agreement-originals').bootstrapTable('getData')[0].Cd_DevCre;

                var requestPrintBillet = $.ajax({
                    url: "{{url('api/billet/print')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId}},
                        debtorExternalId: debtorExternalId,
                        agreement: agreement,
                        agreementInstallment: agreementInstallment,
                    },
                    dataType: "json"
                });
            
                requestPrintBillet.done(function( ret ) {
                    if (ret.success == 1){
                        $("#form-print-billet").attr('action', '{{url('storage')}}/' + ret.file);
                        $("#form-print-billet").submit();
                        showConfirm("Impressão OK.");
                        $('#modal-print-billet').modal('hide');
                    }else{
                        showError("Erro ao gerar boleto.", ret.return);
                    }
                });
            
                requestPrintBillet.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao gerar boleto. Tente novamente.");
                    return false;
                });

                requestPrintBillet.always(function() {
                    hideLoader();
                });
            }
        </script>
    @endpush