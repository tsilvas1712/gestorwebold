    <br clear="all"/>

    <div class="widget-box" >
        <div class="widget-header">
            <h4 class="widget-title">Contratos</h4>
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
                            <div class="col-sm-12 table-responsive no-padding" style="max-height: 250px;">
                                <table id="table-contracts" class="table table-striped table-bordered table-condensed display nowrap" data-detail-view="true">
                                    <thead>
                                        <tr>
                                            <th scope="col">[]</th>
                                            <th scope="col">Credor</th>
                                            <th scope="col">Contrato</th>
                                            <th scope="col">PC</th>
                                            <th scope="col">ES</th>
                                            <th scope="col">Dias</th>
                                            <th scope="col">Vencimento</th>
                                            <th scope="col">Vl Capital</th>
                                            <th scope="col">Pago</th>
                                            <th scope="col">Ult. Pago</th>
                                            <th scope="col">Dt. Devolução</th>
                                            <th scope="col">Acordo</th>
                                            <!--<th width="150px" scope="col">Filial</th>-->
                                            <th scope="col">Observação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contracts as $contract)
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td>{{$contract->Cd_Credor}}</td>
                                            <td>{{trim($contract->Cd_Contrato)}}</td>
                                            <td>{{$contract->Nr_Parcela}}</td>
                                            <td>{{$contract->Cd_Especie}}</td>
                                            <td>{{$contract->Qt_Atraso}}</td>
                                            <td>{{$contract->Dt_Vencimento}}</td>
                                            <td>{{$contract->Vl_Capital}}</td>
                                            <td>{{$contract->Vl_Pagamento}}</td>
                                            <td>{{$contract->Dt_Pagamento}}</td>
                                            <td>{{$contract->Dt_Devolucao}}</td>
                                            <td>{{$contract->Nr_Acordo}}</td>
                                            <!--<td>{{$contract->Filial}}</td>-->
                                            <td>{{trim($contract->Ds_Observacao)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-offset-10 col-sm-2 no-padding">
                                <a href="#modal-estimate" class="btn btn-danger btn-xs btn-block" role="button" data-toggle="modal">
                                    <i class="ace-icon fa fa-calculator"></i>
                                    Calcular
                                </a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @push('functions')
        <script>
            $(document).ready(function() {
                $('#table-contracts00').dataTable( {
                    "scrollX": true,
                    paging: false,
                    searching: false,
                    ordering:  false,
                    info: false
                } );

                $('#table-contracts').bootstrapTable( {
                    detailView: true,
                    onExpandRow: function (index, row, $detail) {
                        alert('Hellooo people!!!');
                    }                
                } );
            } );
        </script>
    @endpush
