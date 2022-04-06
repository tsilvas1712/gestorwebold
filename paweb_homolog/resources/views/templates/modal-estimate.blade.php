    <div id="modal-estimate" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Cálculos</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 pricing-span-header">
                            <div class="widget-box transparent">
                                <div class="widget-header">
                                    <h5 class="widget-titledata-placement="top" bigger lighter">Distribuição</h5>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main no-padding">
                                        <ul class="list-unstyled list-striped pricing-table-header">
                                            <li>Valor Principal</li>
                                            <li>Juros</li>
                                            <li>Multa</li>
                                            <li>Honorários</li>
                                            <li class="strong">Valor Corrigido</li>
                                            <li>Desconto</li>
                                            <li>(%) <i class="ace-icon fa fa-arrow-down green"></i>Desconto / <i class="ace-icon fa fa-arrow-up red"></i> Juros </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-8 col-sm-9 pricing-span-body">
                            <div class="pricing-span">
                                <div class="widget-box pricing-box-small widget-color-green">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">à Vista</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <ul class="list-unstyled list-striped pricing-table">
                                                <li><span id="estimate-principal-opt1"> R$ 0,00 </span></li>
                                                <li><span id="estimate-interest-opt1"> R$ 0,00 </span></li>
                                                <li><span id="estimate-penalty-opt1"> R$ 0,00 </span></li>
                                                <li><span id="estimate-fees-opt1"> R$ 0,00 </span></li>
                                                <li><span class="strong" id="estimate-updated-opt1"> R$ 0,00 </span></li>
                                                <li><span id="estimate-discount-opt1"> R$ 0,00 </span></li>
                                                <li>
                                                    <i id="estimate-signal-opt1" class="ace-icon fa fa-arrow-down red"></i>
                                                    <span id="estimate-percent-opt1"> 0 </span>%
                                                </li>
                                            </ul>

                                            <div class="price">
                                                <span class="label label-lg label-inverse">
                                                    <span id="estimate-installmentValue-opt1"> R$ 0,00 </span>
                                                    <small>/ à Vista</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="#" id="estimate-select-opt1" option-id="1" simulation-id="0" class="btn btn-block btn-sm btn-success estimate-select" role="button" data-toggle="modal">
                                                <span>Selecionar</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pricing-span">
                                <div class="widget-box pricing-box-small widget-color-blue">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Entr. + 2</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <ul class="list-unstyled list-striped pricing-table">
                                                <li><span id="estimate-principal-opt2"> R$ 0,00 </span></li>
                                                <li><span id="estimate-interest-opt2"> R$ 0,00 </span></li>
                                                <li><span id="estimate-penalty-opt2"> R$ 0,00 </span></li>
                                                <li><span id="estimate-fees-opt2"> R$ 0,00 </span></li>
                                                <li><span class="strong" id="estimate-updated-opt2"> R$ 0,00 </span></li>
                                                <li><span id="estimate-discount-opt2"> R$ 0,00 </span></li>
                                                <li>
                                                    <i id="estimate-signal-opt2" class="ace-icon fa fa-arrow-down red"></i>
                                                    <span id="estimate-percent-opt2"> 0 </span>%
                                                </li>
                                            </ul>

                                            <div class="price">
                                                <span class="label label-lg label-inverse">
                                                    <span id="estimate-installmentValue-opt2"> R$ 0,00 </span>
                                                    <small>/ mensais</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="#" id="estimate-select-opt2" option-id="2" simulation-id="0" class="btn btn-block btn-sm btn-primary estimate-select" role="button" data-toggle="modal">
                                                <span>Selecionar</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pricing-span">
                                <div class="widget-box pricing-box-small widget-color-orange">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Entr. + 4</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <ul class="list-unstyled list-striped pricing-table">
                                                <li><span id="estimate-principal-opt3"> R$ 0,00 </span></li>
                                                <li><span id="estimate-interest-opt3"> R$ 0,00 </span></li>
                                                <li><span id="estimate-penalty-opt3"> R$ 0,00 </span></li>
                                                <li><span id="estimate-fees-opt3"> R$ 0,00 </span></li>
                                                <li><span class="strong" id="estimate-updated-opt3"> R$ 0,00 </span></li>
                                                <li><span id="estimate-discount-opt3"> R$ 0,00 </span></li>
                                                <li>
                                                    <i id="estimate-signal-opt3" class="ace-icon fa fa-arrow-down red"></i>
                                                    <span id="estimate-percent-opt3"> 0 </span>%
                                                </li>
                                            </ul>

                                            <div class="price">
                                                <span class="label label-lg label-inverse">
                                                    <span id="estimate-installmentValue-opt3"> R$ 0,00 </span>
                                                    <small>/ mensais</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="#" id="estimate-select-opt3" option-id="3" simulation-id="0" class="btn btn-block btn-sm btn-warning estimate-select" role="button" data-toggle="modal">
                                                <span>Selecionar</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pricing-span">
                                <div class="widget-box pricing-box-small widget-color-grey">
                                    <div class="widget-header">
                                        <h5 class="widget-title bigger lighter">Entr. + 9</h5>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <ul class="list-unstyled list-striped pricing-table">
                                                <li><span id="estimate-principal-opt4"> R$ 0,00 </span></li>
                                                <li><span id="estimate-interest-opt4"> R$ 0,00 </span></li>
                                                <li><span id="estimate-penalty-opt4"> R$ 0,00 </span></li>
                                                <li><span id="estimate-fees-opt4"> R$ 0,00 </span></li>
                                                <li><span class="strong" id="estimate-updated-opt4"> R$ 0,00 </span></li>
                                                <li><span id="estimate-discount-opt4"> R$ 0,00 </span></li>
                                                <li>
                                                    <i id="estimate-signal-opt4" class="ace-icon fa fa-arrow-down red"></i>
                                                    <span id="estimate-percent-opt4"> 0 </span>%
                                                </li>
                                            </ul>

                                            <div class="price">
                                                <span class="label label-lg label-inverse">
                                                    <span id="estimate-installmentValue-opt4"> R$ 0,00 </span>
                                                    <small>/ mensais</small>
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="#" id="estimate-select-opt4" option-id="4" simulation-id="0" class="btn btn-block btn-sm btn-grey estimate-select" role="button" data-toggle="modal">
                                                <span>Selecionar</span>
                                            </a>
                                        </div>
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

    <div id="modal-estimate-manual" class="modal" data-placement="bottom" data-background="false" data-backdrop="false" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <form class="form form-horizontal">
                            <div class="col-sm-12">
                                <label for="simulation-downpayment">Valor de Entrada</label>
                                <input class="form-control" type="number" id="simulation-downpayment" />
                            </div>

                            <div class="col-sm-12">
                                <label for="simulation-plan">Quantidade de Parcelas</label>
                                <input class="form-control" type="number" id="simulation-plan" min="1" max="18" />
                            </div>

                            <div class="col-sm-12">
                                <label for="simulation-paydate">Dt. Entrada</label>
                                @php
                                    $nday = time() + ( 86400 * 10 );
                                @endphp

                                <input class="form-control" type="date" id="simulation-paydate" min="<?=(date('Y-m-d'))?>" max="<?=(date('Y-m-d', $nday))?>" />
                            </div>

                            <div class="col-sm-12">
                                <label for="simulation-discount">Desconto (%)</label>
                                <input class="form-control" type="number" id="simulation-discount" min="0" max="200" />
                            </div>

                            <div class="col-sm-12 space-4"></div>

                            <div class="col-sm-12">
                                <a href="#" id="doSimulation" class="btn btn-block btn-sm btn-primary" role="button" data-toggle="modal">
                                    Fazer simulação
                                </a>
                            </div>
    
                        </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->

            <a href="#modal-estimate-manual" class="btn btn-default btn-app btn-xs ace-settings-btn aside-trigger" data-toggle="modal" >
                <i data-icon2="fa-arrow-down" data-icon1="fa-arrow-up" class="ace-icon fa fa-arrow-up bigger-110 icon-only"></i>
                Simulação livre
            </a>
        </div><!-- /.modal-dialog -->
    </div>


    @push('functions')
        <script>
            $(".estimate-select").click(function(){
                var simulationid = $(this).attr('simulation-id');
                var option = $(this).attr('option-id');
                var principal = $("#estimate-principal-opt" + option).text();

                loadSimulation(simulationid, principal);
            });
            
            $("#doSimulation").click(function(){
                contracts = $('#table-contracts').bootstrapTable('getSelections');
                showLoader('Calculando simulação...');
                requestOk = false;
                
                var requestSimulation = $.ajax({
                    url: "{{url('api/estimate/create')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId or 0}},
                        contract: contracts,
                        manual: 1,
                        downpayment: $('#simulation-downpayment').val(),
                        plan: $('#simulation-plan').val(),
                        paydate: $('#simulation-paydate').val(),
                        discount: $('#simulation-discount').val(),
                    },
                    dataType: "json"
                });
            
                requestSimulation.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }else{
                        return false;
                    }
                });
            
                requestSimulation.fail(function( jqXHR, textStatus ) {
                    hideLoader();
                    showError("Erro", "Erro ao buscar dados da simulação. Tente novamente.");
                    return false;
                });
                
                requestSimulation.always(function() {
                    console.log(json);
                    if (! json.success){
                        hideLoader();

                        if (typeof json.return == 'object'){
                            $i = 0;
                            while (json.return.hasOwnProperty($i)){
                                showError("Erro", json.return[$i]);
                                $i++;
                            }
                        }else{
                            showError("Erro", json.return);
                        }
                    }else if ( requestOk ){
                        hideLoader();
                        loadSimulation(json.simulationid, json.return.OriginaisAcordo.OriginalAcordo.ValorDividaCalculo);
                    }
                });
            });
            
            function loadEstimate(opt){
                clearEstimate(opt);
                contracts = $('#table-contracts').bootstrapTable('getSelections');

                showLoader('Calculando simulações...');

                requestOk = false;
                
                var requestEstimate = $.ajax({
                    url: "{{url('api/estimate/create')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId or 0}},
                        contract: contracts,
                        manual: 0,
                        opt: opt
                    },
                    dataType: "json"
                });
            
                requestEstimate.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }else{
                        return false;
                    }
                });
            
                requestEstimate.fail(function( jqXHR, textStatus ) {
                    hideLoader();
                    showError("Erro", "Erro ao buscar dados da simulação. Tente novamente.");
                    return false;
                });
                
                requestEstimate.always(function() {
                    console.log(json);
                    if (! json.success){
                        hideLoader();

                        if (typeof json.return == 'object'){
                            $i = 0;
                            while (json.return.hasOwnProperty($i)){
                                showError("Erro", json.return[$i]);
                                $i++;
                            }
                        }else{
                            showError("Erro", json.return);
                        }
                    }else if ( requestOk ){
                        //Fill fields with return
                        if (json.return.OriginaisAcordo.hasOwnProperty('OriginalAcordo')){
                            $("#estimate-principal-opt" + opt).text(json.return.OriginaisAcordo.OriginalAcordo.ValorDividaCalculo);
                            $("#estimate-interest-opt" + opt).text(json.return.OriginaisAcordo.OriginalAcordo.ValorJuros);
                            $("#estimate-penalty-opt" + opt).text(json.return.OriginaisAcordo.OriginalAcordo.ValorMulta);
                            $("#estimate-discount-opt" + opt).text(Number(json.return.OriginaisAcordo.OriginalAcordo.ValorDescontoJuros) + Number(json.return.OriginaisAcordo.OriginalAcordo.ValorDescontoPrincipal));
                            $("#estimate-fees-opt" + opt).text(json.return.OriginaisAcordo.OriginalAcordo.ValorTaxaAdministrativa);

                            $("#estimate-updated-opt" + opt).text(parseFloat(json.return.OriginaisAcordo.OriginalAcordo.ValorDividaCalculo) +
                                                                  parseFloat(json.return.OriginaisAcordo.OriginalAcordo.ValorJuros) +
                                                                  parseFloat(json.return.OriginaisAcordo.OriginalAcordo.ValorMulta) +
                                                                  parseFloat(json.return.OriginaisAcordo.OriginalAcordo.ValorTaxaAdministrativa)
                                                                );

                            //if (Array.isArray(json.return.ParcelasAcordo.ParcelaAcordo)){
                            if (json.return.Plano == 1){
                                $("#estimate-installmentValue-opt" + opt).text(json.return.ParcelasAcordo.ParcelaAcordo.ValorParcela);
                                amount = json.return.ParcelasAcordo.ParcelaAcordo.ValorParcela;
                            }else{
                                $("#estimate-installmentValue-opt" + opt).text(json.return.ParcelasAcordo.ParcelaAcordo[0].ValorParcela);
                                amount = json.return.ParcelasAcordo.ParcelaAcordo[0].ValorParcela * json.return.Plano;
                            }
                            diff = amount - json.return.OriginaisAcordo.OriginalAcordo.ValorDividaCalculo;
                            perc = (diff * 100 / json.return.OriginaisAcordo.OriginalAcordo.ValorDividaCalculo);
                            
                            if (perc < 0){
                                perc = perc * (-1);
                                $("#estimate-signal-opt" + opt).addClass('fa-arrow-down');
                                $("#estimate-signal-opt" + opt).addClass('green');
                            }else{
                                $("#estimate-signal-opt" + opt).addClass('fa-arrow-up');
                                $("#estimate-signal-opt" + opt).addClass('red');
                            }
                            $("#estimate-percent-opt" + opt).text(perc.toFixed(2));

                            /*********************** FORMAT CURRENCY ***********************/
                            $("#estimate-principal-opt" + opt).formatCurrency();
                            $("#estimate-interest-opt" + opt).formatCurrency();
                            $("#estimate-penalty-opt" + opt).formatCurrency();
                            $("#estimate-discount-opt" + opt).formatCurrency();
                            $("#estimate-fees-opt" + opt).formatCurrency();
                            $("#estimate-updated-opt" + opt).formatCurrency();
                            $("#estimate-installmentValue-opt" + opt).formatCurrency();                            
                            
                            $("#estimate-select-opt" + opt).removeClass('disabled');
                            $("#estimate-select-opt" + opt).attr('simulation-id', json.simulationid);
                        }else{
                            showMessage("Cliente não disponível para negociação.");
                        }
                    }
                    hideLoader();
                });
            }

            function clearEstimate(opt){
                $("#estimate-principal-opt" + opt).text('0');
                $("#estimate-interest-opt" + opt).text('0');
                $("#estimate-penalty-opt" + opt).text('0');
                $("#estimate-discount-opt" + opt).text('0');
                $("#estimate-fees-opt" + opt).text('0');
                $("#estimate-percent-opt" + opt).text('0');
                $("#estimate-installmentValue-opt" + opt).text('0');

                $("#estimate-signal-opt" + opt).removeClass('fa-arrow-down');
                $("#estimate-signal-opt" + opt).removeClass('fa-arrow-up');
                $("#estimate-signal-opt" + opt).removeClass('red');
                $("#estimate-signal-opt" + opt).removeClass('green');

                $("#estimate-select-opt" + opt).addClass('disabled');
                $("#estimate-select-opt" + opt).attr('simulation-id', '0');
            }

            /*
            var size = Object.keys(json.return.ParcelasAcordo.ParcelaAcordo).length;
            Object.size = function(obj) {
                var size = 0, key;
                for (key in obj) {
                    if (obj.hasOwnProperty(key)) size++;
                }
                return size;
            };
            */
        </script>
    @endpush