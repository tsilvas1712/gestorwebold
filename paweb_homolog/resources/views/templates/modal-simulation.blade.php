    <div id="modal-simulation" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Acordo</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="widget-box" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Desdobramento de Parcelas</h4>
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
                                                                id="simulation-table" 
                                                                data-toggle="table"
                                                                data-height="250">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="Nr_Parcela" scope="col">Parc.</th>
                                                                    <th data-field="Dt_Vencimento" scope="col" data-formatter="tableDateFormat">Vencimento</th>
                                                                    <th data-field="Vl_Parcela" scope="col" data-formatter="tableFloatFormat">Valor</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <table class="table centered table-striped table-bordered">
                                                            <tfoot>
                                                                <tr>
                                                                    <th scope="col">
                                                                        Total 
                                                                        <span class="red">De</span> <span class="red" id="simulation-principal">R$ 0,00</span>
                                                                        <span class="green">Por</span> <span class="green" id="simulation-newbalance">R$ 0,00</span>
                                                                    </th>
                                                                </tr>
                                                            </tfoot>    
                                                        </table>

                                                        <form class="form-horizontal" method="POST" action="{{url('/agreement/confirm')}}" name="agreement-confirm" id="agreement-confirm">
                                                            {!! csrf_field() !!}
                                                            <input type="hidden" name="agreement-confirm-debtorId" value="{{$debtorId or 0}}">
                                                            <input type="hidden" name="agreement-confirm-simulationId" id="agreement-confirm-simulationId" value="">

                                                            <button class="btn btn-block btn-sm btn-primary" role="button">
                                                                <span>Fechar Acordo</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
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
            function loadSimulation(simulationId, principal){
                $('#modal-simulation').modal('show');                
                showLoader('Abrindo parcelas...');
                requestOk = false;

                $("#agreement-confirm-simulationId").val(simulationId);
                $("#simulation-principal").text(principal);
                $('#simulation-table').bootstrapTable('destroy');

                var requestSimulation = $.ajax({
                    url: "{{url('api/estimate/get')}}",
                    method: "POST",
                    data: {
                        simulationId: simulationId,
                    },
                    dataType: "json"
                });
            
                requestSimulation.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }else{
                        showMessage("Simulação não encontrada.");
                        return false;
                    }
                });
            
                requestSimulation.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao abrir simulação. Tente novamente.");
                    return false;
                });

                requestSimulation.always(function() {
                    console.log(json);

                    var newBalance = 0;
                    for (var i = 0; i < json.length; i++) {
                        newBalance += Number(json[i].Vl_Parcela);
                    }
                    $("#simulation-principal").text(principal);
                    $("#simulation-newbalance").text(newBalance);

                    if (requestOk) {
                        $('#simulation-table').bootstrapTable({
                            data: json
                        });
                    }

                    $("#simulation-principal").formatCurrency();
                    $("#simulation-newbalance").formatCurrency();
                    hideLoader();
                });
            }
        </script>
    @endpush
