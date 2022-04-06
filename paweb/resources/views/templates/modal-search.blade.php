    <div id="modal-search" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Pesquisar devedores</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="widget">
                                <fieldset>
                                    <label for="searchBy-dsNome">Nome</label>
                                    <input type="radio" name="radio-search" id="searchBy-dsNome" value="Ds_Nome" checked>

                                    <label for="searchBy-cdDevedor">Código</label>
                                    <input type="radio" name="radio-search" id="searchBy-cdDevedor" value="Cd_Devedor">

                                    <label for="searchBy-cdCicCgc">CPF/CNPJ</label>
                                    <input type="radio" name="radio-search" id="searchBy-cdCicCgc" value="Cd_CICCGC">

                                    <label for="searchBy-cdContrato">Contrato</label>
                                    <input type="radio" name="radio-search" id="searchBy-cdContrato" value="Cd_Contrato">

                                    <label for="searchBy-cdDevCre">DevCre</label>
                                    <input type="radio" name="radio-search" id="searchBy-cdDevCre" value="Cd_DevCre">

                                    <label for="searchBy-cdTelefone">Telefone</label>
                                    <input type="radio" name="radio-search" id="searchBy-cdTelefone" value="Cd_Telefone">

                                    <label for="searchBy-dsEmail">E-mail</label>
                                    <input type="radio" name="radio-search" id="searchBy-dsEmail" value="Ds_Email">
                                </fieldset>
                            </div>                            

                            <hr class="no-padding">
                            <div class="input-group">
                                <input type="text" id="text-search" class="form-control search-query" placeholder="Digite a sua pesquisa">
                                <span class="input-group-btn">
                                    <button type="button" id="button-search" class="btn btn-success btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                        Buscar
                                    </button>
                                </span>
                            </div>

                            <div class="widget-box" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Resultado da busca</h4>
                                </div>
                                <div class="widget-body ">
                                    <div class="widget-main no-padding">
                                        <div class="table-responsive no-padding">
                                            <table class="table table-striped table-bordered table-selectable" id="debtors-table" data-toggle="table" data-height="285">
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="true" data-field="Cd_Devedor" scope="col">Código</th>
                                                        <th data-sortable="true" data-field="Ds_Nome" scope="col">Nome</th>
                                                        <th data-sortable="true" data-field="Cd_CICCGC" scope="col">CPF</th>
                                                        <th data-sortable="true" data-field="Ds_Credor" scope="col">Credor</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('functions')
        <script type="text/javascript">
        jQuery(function($) {
            $("#debtors-table").on("click", "tbody tr", function (row, $el, field) {
                showLoader('Abrindo ficha...');
                var id = $(this)[0].firstChild.innerHTML;
                window.location.href = "{{url('/debtor')}}/"+id;
            });

            $("#text-search").keypress(function(e) {
                if(e.which == 13) {
                    $( "#button-search" ).click();       
                }
            });

            $( "#button-search" ).click(function() {
                text = $( "#text-search" ).val();
                field = $( "[name=radio-search]:checked" ).val();

                searchDebtors();
            });

            function searchDebtors(){
                showLoader('Procurando devedores...');
                requestOk = false;
                $('#debtors-table').bootstrapTable('destroy');

                var requestSearch = $.ajax({
                    url: "{{url('api/debtor/search')}}",
                    method: "POST",
                    data: {
                        text: text,
                        field: field,
                    },
                    dataType: "json"
                });
            
                requestSearch.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }else{
                        showMessage("Nenhum devedor encontrado.");
                        return false;
                    }
                });
            
                requestSearch.fail(function( jqXHR, textStatus ) {
                    showMessage("Erro ao pesquisar devedor. Tente novamente.");
                    return false;
                });

                requestSearch.always(function() {
                    hideLoader();
                    if (requestOk) {
                        $('#debtors-table').bootstrapTable({
                            data: json
                        });
                    }
                });
            }
        })
        </script>
    @endpush
