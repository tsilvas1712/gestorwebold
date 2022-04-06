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
                                <table id="table-contracts" 
                                       class="table table-striped table-bordered table-condensed display nowrap" 
                                       data-toggle="table"
                                       data-click-to-select="true"
                                       data-checkbox-header="false"
                                       style="cursor: pointer;">
                                    <thead>
                                        <tr>
                                            <th scope="col" data-checkbox="true"></th>
                                            <th scope="col" data-field="Cd_Credor">Credor</th>
                                            <th scope="col" data-field="Cd_Contrato">Contrato</th>
                                            <th scope="col" data-field="Nr_Parcela">PC</th>
                                            <th scope="col" data-field="Cd_Especie">ES</th>
                                            <th scope="col" data-field="Qt_Atraso">Dias</th>
                                            <th scope="col" data-field="Dt_Vencimento">Dt Vcto</th>
                                            <th scope="col" data-field="Vl_Capital">Vl Capital</th>
                                            <th scope="col" data-field="Vl_Pagamento">Pago</th>
                                            <th scope="col" data-field="Dt_Pagamento">Ult. Pago</th>
                                            <th scope="col" data-field="Dt_Devolucao">Dt. Devol</th>
                                            <th scope="col" data-field="Nr_Acordo">Acordo</th>
                                            <!--<th scope="col" data-field="Ds_Filial">Filial</th>-->
                                            <th scope="col" data-field="Ds_Observacao">Obs</th>
                                            <th scope="col" data-field="Fl_Active" data-visible="false">Ativo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php($lastCreditor = -1)

                                        @foreach ($contracts as $contract)
                                            @php($creditorsSummary = Contract::getcreditorSummary($debtorId, $contract->Cd_Credor))

                                            @if ($lastCreditor != $contract->Cd_Credor)
                                                <tr class="creditor-summary">
                                                    <td>&nbsp;</td>
                                                    <td>{{$contract->Cd_Credor}}</td>
                                                    <td>{{$creditorsSummary->Qty_Contracts}}</td>
                                                    <td>{{$creditorsSummary->Qty_Due}}</td>
                                                    <td>&nbsp;</td>
                                                    <td>{{$creditorsSummary->Max_Delay}}</td>
                                                    <td>{{formatDateYYYYMMDD_DDMMYYYY($creditorsSummary->Min_Due)}}</td>
                                                    <td>{{asCurrency($creditorsSummary->Sum_Amount,'')}}</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <!--<td>&nbsp;</td>-->
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            @endif

                                            <tr class="{{ ($contract->Fl_Active == 1)?'active':'inactive'}}">
                                                <td >&nbsp;</td>
                                                <td>{{$contract->Cd_Credor}}</td>
                                                <td>{{trim($contract->Cd_Contrato)}}</td>
                                                <td>{{$contract->Nr_Parcela}}</td>
                                                <td>{{$contract->Cd_Especie}}</td>
                                                <td>{{$contract->Qt_Atraso}}</td>
                                                <td>{{formatDateYYYYMMDD_DDMMYYYY($contract->Dt_Vencimento)}}</td>
                                                <td>{{asCurrency($contract->Vl_Capital,'')}}</td>
                                                <td>{{asCurrency($contract->Vl_Pagamento,'')}}</td>
                                                <td>{{$contract->Dt_Pagamento ? formatDateYYYYMMDD_DDMMYYYY($contract->Dt_Pagamento) : ''}}</td>
                                                <td>{{$contract->Dt_Devolucao ? formatDateYYYYMMDD_DDMMYYYY($contract->Dt_Devolucao) : ''}}</td>
                                                <td>{{$contract->Nr_Acordo}}</td>
                                                <!--<td>{{$contract->Ds_Filial}}</td>-->
                                                
                                                @if ($contract->Cd_Credor != 10054)
                                                <td>
                                                    <a href="#" class="" data-toggle="tooltip" title="{{trim($contract->Ds_Observacao)}}">
                                                        <i class="ace-icon fa fa-info bigger-140 icon-only"></i>
                                                        Ver Obs
                                                    </a>
                                                </td>
                                                @endif

                                                @if ($contract->Cd_Credor == 10054)
                                                <td>
                                                    0{{$contract->Cd_DevCre * 1}}
                                                </td>
                                                @endif

                                                <td>{{$contract->Fl_Active}}</td>
                                            </tr>
                                            @php($lastCreditor = $contract->Cd_Credor)
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-offset-10 col-sm-2 no-padding">
                                <a href="#modal-estimate" id="btn-estimate" class="btn btn-danger btn-xs btn-block" role="button" data-toggle="modal">
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
            $('#table-contracts').bootstrapTable({
                onCheck: function (row, $element) {
                    //> if check the creditor, then check all contracts of the same creditor
                    if ($element.closest("tr").hasClass("creditor-summary")){
                        creditorId_oncheck = $element.closest("tr").children('td')[1].innerHTML;
                        $('input[name=btSelectItem]').each(function () {
                            if (creditorId_oncheck == $(this).closest("tr").children('td')[1].innerHTML){
                                //> Only contract active
                                if ($(this).closest("tr").hasClass("active")){
                                    if (!$(this).closest("tr").hasClass("creditor-summary")){
                                        $('#table-contracts').bootstrapTable('check', $(this).closest("tr").attr("data-index"));
                                    }
                                }
                            }else{
                                $('#table-contracts').bootstrapTable('uncheck', $(this).closest("tr").attr("data-index"));
                            }
                        });
                    }
                    //> if check a inactive contract, then uncheck them
                    else if (row["Fl_Active"] == 0){
                        $('#table-contracts').bootstrapTable('uncheck', $element.attr("data-index"));
                    }
                },

                onUncheck: function (row, $element) {
                    //> if check the creditor, then uncheck all contracts of the same creditor
                    if ($element.closest("tr").hasClass("creditor-summary")){
                        creditorId_onuncheck = $element.closest("tr").children('td')[1].innerHTML;
                        $('input[name=btSelectItem]').each(function () {
                            if (!$(this).closest("tr").hasClass("creditor-summary")){
                                if (creditorId_onuncheck == $(this).closest("tr").children('td')[1].innerHTML){
                                    $('#table-contracts').bootstrapTable('uncheck', $(this).closest("tr").attr("data-index"));
                                }
                            }
                        });

                    }
                },

                //> On double click, then check all rows of the same creditor and contract
                onDblClickCell: function (field, value, row, $element) {
                    //> Only for rows different of creditor summary
                    if (!$element.closest("tr").hasClass("creditor-summary")){
                        creditorId = $element.closest("tr").children('td')[1].innerHTML;
                        contractId = $element.closest("tr").children('td')[2].innerHTML;

                        $('input[name=btSelectItem]').each(function () {
                            if ( (creditorId == $(this).closest("tr").children('td')[1].innerHTML) &&
                                 (contractId == $(this).closest("tr").children('td')[2].innerHTML) ){
                                //> Only contract active
                                if ($(this).closest("tr").hasClass("active")){
                                    if (!$(this).closest("tr").hasClass("creditor-summary")){                                    
                                        $('#table-contracts').bootstrapTable('check', $(this).closest("tr").attr("data-index"));
                                    }
                                }
                            }else{
                                $('#table-contracts').bootstrapTable('uncheck', $(this).closest("tr").attr("data-index"));
                            }
                        });
                    }
                },
            });


            $("#btn-estimate").click(function(){
                contracts = $('#table-contracts').bootstrapTable('getSelections');
                if (contracts.length == 0){
                    showMessage("É preciso selecionar pelo menos 1 contrato primeiro.");
                    return false;
                }

                var creditor = 0;
                var qtyContracts = 0;
                for (var i = 0; i < contracts.length; i++) {
                    if (creditor == 0){
                        creditor = contracts[i].Cd_Credor;
                    }

                    //> If creditor row
                    if ( (contracts[i].Cd_Especie == "") || (contracts[i].Cd_Especie == "&nbsp;") ){
                        continue;
                    }

                    if (contracts[i].Nr_Acordo > 0) {
                        showMessage("Não é permitido selecionar contratos que já possuem acordo.");
                        return false;
                    }

                    if (creditor != contracts[i].Cd_Credor){
                        showMessage("Você não pode selecionar contratos de mais de 1 credor.");
                        return false;
                    }

                    qtyContracts++;
                }

                if (qtyContracts == 0){
                    showMessage("É preciso selecionar pelo menos 1 contrato primeiro.");
                    return false;
                }

                //> This implemention you can find in "modal_estimate.blade.php"
                loadEstimate(1);
                loadEstimate(2);
                loadEstimate(3);
                loadEstimate(4);
			});

        </script>
    @endpush
