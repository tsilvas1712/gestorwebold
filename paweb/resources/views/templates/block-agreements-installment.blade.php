<div class="widget-box" >
    <div class="widget-header">
        <h4 class="widget-title">Parcelas do Acordo</h4>

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
                        <div class="col-sm-12 table-responsive table-limited no-padding">
                            <table class="table table-striped table-bordered header-fixed" 
                                   id="agreement-intallments"
                                   data-toggle="table"
                                   data-height="145">
                                <thead>
                                    <tr>
                                        <th scope="col" data-field="Nr_Parcela">Nro</th>
                                        <th scope="col" data-field="Dt_Vencimento" data-formatter="tableDateFormat">Vencimento</th>
                                        <th scope="col" data-field="Vl_Parcela" data-formatter="tableFloatFormat">Valor</th>
                                        <th scope="col" data-field="Tp_EnvioBloqueto">Tp. Envio</th>
                                        <th scope="col" data-field="Cd_Cedente">Cedente</th>
                                        <th scope="col" data-field="Nr_NossoNumero">Nr. Nossonumero</th>
                                        <th scope="col" data-field="Dt_Pagamento" data-formatter="tableDateFormat">Dt. Pagamento</th>
                                        <th scope="col" data-field="Vl_Pagamento" data-formatter="tableFloatFormat">Valor Pago</th>
                                        <th scope="col" data-field="Nr_Recibo">Nr. Recibo</th>
                                        <th scope="col" data-formatter="tableAgreementsInstallmentFormat">&nbsp;</th>
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

@push('functions')
    <script>
        var $tableAgreementInstallments = $('#agreement-intallments');
           
        $(function () {
            $tableAgreementInstallments.on('click-row.bs.table', function (e, row, $element) {
                
                //uncheckAll not is working ????????
                //$tableAgreementInstallments.bootstrapTable('uncheckAll');
                rows = $tableAgreementInstallments.bootstrapTable('getOptions').data.length;
                for (var i = 0; i < rows; i++) {
                    $tableAgreementInstallments.bootstrapTable('uncheck', i);
                }

                $tableAgreementInstallments.bootstrapTable('check', $element.attr("data-index"));
            });
        });

    </script>
@endpush