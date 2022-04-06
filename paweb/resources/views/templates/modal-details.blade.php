    <div id="modal-details" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Dados</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <!-- Begin Content Modal -->

                            <!-- Begin [Identificacao]-->
                            <div class="widget-box" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Identificação</h4>
                                    <span class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="widget-body ">
                                    <form class="form form-horizontal">
                                        <div class="widget-main">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <div class="col-sm-12 no-padding">
                                                            <div class="col-sm-6 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="detail-Ds_Nome">Nome</label>
                                                                    <input class="form-control" type="text" id="detail-Ds_Nome" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="detail-Cd_CICCGC">CPF / CNPJ</label>
                                                                    <input class="form-control" type="text" id="detail-Cd_CICCGC" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="detail-Dt_Nascimento">Data Nasc</label>
                                                                    <input class="form-control" type="date" id="detail-Dt_Nascimento" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 no-padding">
                                                            <div class="col-sm-2 no-padding">
                                                                <div class="col-sm-12 no-padding">
                                                                    <label for="detail-Cd_EstadoCivil">Estado Civil</label><br>
                                                                    <select class="form-control chosen-select" id="detail-Cd_EstadoCivil" data-placeholder="Selecione...">
                                                                        <option value=""></option>
                                                                        <option value="S">Solteiro</option>
                                                                        <option value="C">Casado</option>
                                                                        <option value="D">Divorciado</option>
                                                                        <option value="J">Separ. Jud.</option>
                                                                        <option value="Q">Desquitado</option>
                                                                        <option value="V">Viúvo</option>
                                                                        <option value="O">Outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-7 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="detail-Ds_Conjuge">Cônjuge</label>
                                                                    <input class="form-control" type="text" id="detail-Ds_Conjuge" />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-3 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="detail-Cd_Sexo">Sexo</label>
                                                                    <div class="input-group col-sm-12">
                                                                        <label>
                                                                        <input name="genderDebtor" type="radio" class="ace" @if ( (isset($debtor)) && (isset($debtor->Cd_Sexo)) && ($debtor->Cd_Sexo == 'M')) {{'checked'}} @endif />
                                                                            <span class="lbl">Masc.</span>
                                                                        </label>
                                                                        <label>
                                                                            <input name="genderDebtor" type="radio" class="ace" @if ( (isset($debtor)) && (isset($debtor->Cd_Sexo)) && ($debtor->Cd_Sexo == 'F')) {{'checked'}} @endif />
                                                                            <span class="lbl">Fem.</span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- End [Identificacao]-->

                            <!-- Begin [Filiação]-->
                            <div class="col-sm-6 no-padding-left" >
                                <div class="widget-box" >
                                    <div class="widget-header">
                                        <h4 class="widget-title">Filiação</h4>
                                        <span class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="ace-icon fa fa-chevron-up"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="widget-body ">
                                        <form class="form form-horizontal">
                                            <div class="widget-main">
                                                <table width="100%">
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-12 no-padding">
                                                                <label for="detail-Ds_Pai">Pai</label>
                                                                <input class="form-control" type="text" id="detail-Ds_Pai" />
                                                            </div>

                                                            <div class="col-sm-12 no-padding">
                                                                <label for="detail-Ds_Mae">Mãe</label>
                                                                <input class="form-control" type="text" id="detail-Ds_Mae" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- End [Filiação] -->
                            
                            <!-- Begin [Profissão] -->
                            <div class="col-sm-6 no-padding-right" >
                                <div class="widget-box" >
                                    <div class="widget-header">
                                        <h4 class="widget-title">Profissão</h4>
                                        <span class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="ace-icon fa fa-chevron-up"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="widget-body ">
                                        <form class="form form-horizontal">
                                            <div class="widget-main">
                                                <table width="100%">
                                                    <tr>
                                                        <td>
                                                            <div class="col-sm-12 no-padding">
                                                                <div class="col-sm-6 no-padding-left">
                                                                    <label for="detail-Ds_Cargo">Cargo</label>
                                                                    <input class="form-control" type="text" id="detail-Ds_Cargo" />
                                                                </div>
                                                                <div class="col-sm-6 no-padding-right">
                                                                    <label for="detail-Ds_Renda">Renda</label>
                                                                    <input class="form-control" type="text" id="detail-Ds_Renda" />
                                                                </div>        
                                                            </div>
    
                                                            <div class="col-sm-12 no-padding">    
                                                                <label for="detail-Ds_Trabalho">Empresa</label>
                                                                <input class="form-control" type="text" id="detail-Ds_Trabalho" />
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div> <!-- End [Profissão] -->

                            <br clear="all"/>
                        
                            <!-- Begin [Observações] -->
                            <div class="widget-box" id="details-obs" >
                                <div class="widget-header">
                                    <h4 class="widget-title">Observações</h4>
                                    <span class="widget-toolbar">
                                        <a href="#" data-action="collapse">
                                            <i class="ace-icon fa fa-chevron-up"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main" style="padding: 0 10px 0 10px;">

                                        <!-- Begin [Contato] -->
                                        <div class="widget-box" >
                                            <div class="widget-header">
                                                <h4 class="widget-title">Contato</h4>
                                                <span class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="ace-icon fa fa-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <label>Data: <span id="detail-Dt_Contato">dd/mm/yyyy</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Cobrador: <span id="detail-Cd_Cobrador">0</span></label>
                                                            </td>

                                                            <td>
                                                                <label>Credor: <span id="detail-Cd_CredorDebtor">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Grupo Trab: <span id="detail-Cd_GrupoTrabalho">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Ramo Ativ: <span id="detail-Cd_RamoAtividade">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- End [Contato] -->

                                        <!-- Begin [Comissionado] -->
                                        <div class="widget-box" >
                                            <div class="widget-header">
                                                <h4 class="widget-title">Comissionado</h4>
                                                <span class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="ace-icon fa fa-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <table class="centered">
                                                        <tr>
                                                            <td>
                                                                <label>Interno: <span id="detail-Cd_CobradorInt">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Externo: <span id="detail-Cd_CobradorExt">0</span></label>
                                                            </td>

                                                            <td>
                                                                <label>Redirecionado: <span id="detail-Cd_CobradorRec">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Campanha: <span id="detail-Cd_CobradorCam">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- End [Comissionado] -->

                                        <!-- Begin [Ocorrências] -->
                                        <div class="widget-box" >
                                            <div class="widget-header">
                                                <h4 class="widget-title">Ocorrências</h4>
                                                <span class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="ace-icon fa fa-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <table class="centered">
                                                        <tr>
                                                            <td>
                                                                <label>Classe: <span id="detail-Cd_Classe">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Observação: <span id="detail-Ds_ObsOco">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Anistia: <span id="detail-Cd_Anistia">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Últ. Histórico: <span id="detail-Cd_UltHistMan">dd/mm/yyyy hh:mm</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Ciclo: <span id="detail-Cd_GrupoOcorrencia">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Zona: <span id="detail-Cd_ZonaCob">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- End [Ocorrências] -->

                                        <!-- Begin [Outros] -->
                                        <div class="widget-box" >
                                            <div class="widget-header">
                                                <h4 class="widget-title">Outros</h4>
                                                <span class="widget-toolbar">
                                                    <a href="#" data-action="collapse">
                                                        <i class="ace-icon fa fa-chevron-up"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <table class="centered">
                                                        <tr>
                                                            <td>
                                                                <label>Credor: <span id="detail-Cd_Credor">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>DevCre: <span id="detail-Cd_DevCre">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Dt Compra: <span id="detail-Dt_Compra">dd/mm/yyyy</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Observação: <span id="detail-Ds_Observacao">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="centered">
                                                        <tr>
                                                            <td>
                                                                <label>Entrada [Nr. Data]: <span id="detail-Dt_Entrada">dd/mm/yyyy</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Devolução [Nr. Data]: <span id="detail-Dt_Devolucao">dd/mm/yyyy</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Aviso: <span id="detail-Cd_Aviso">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Uso Cliente: <span id="detail-Ds_UsoCliente">XXX</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Nr Conta: <span id="detail-Nr_Conta">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table class="centered" style="width:50%">
                                                        <tr>
                                                            <td>
                                                                <label>Score Ext: <span id="detail-Cd_Score_Ext">0</span></label>
                                                            </td>
                                                            <td>
                                                                <label>Scote Int: <span id="detail-Cd_Score_Int">0</span></label>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> <!-- End [Outros] -->
    
                                    </div>
                                </div>
                            </div> <!-- End [Observações] -->
                            
                        
                            <!-- End Content Modal -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-sm btn-primary" data-dismiss="modal">
                        <i class="ace-icon fa fa-save"></i>
                        Alterar Dados
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancelar
                    </button>
    
                </div>
            </div>
        </div>
    </div>

    @push('functions')
        <script>
            function loadDetails(){
                contracts = $('#table-contracts').bootstrapTable('getSelections');
                if (contracts.length == 0){
                    $(".close").click();
                    showMessage("É preciso selecionar um contrato primeiro.");
                    return false;
                }else if (contracts.length > 1){
                    $(".close").click();
                    showMessage("Você deve selecionar apenas 1 registro.");
                    return false;
                //> If creditor row
                }else if ( (contracts[0].Cd_Especie == "") || (contracts[0].Cd_Especie == "&nbsp;") ){
                    $(".close").click();
                    showMessage("É preciso selecionar um contrato primeiro.");
                    return false;
                }

                showLoader('Carregando...');

                requestOk = false;
                
                var requestDetails = $.ajax({
                    url: "{{url('api/debtor/get')}}",
                    method: "POST",
                    data: {
                        debtorId: {{$debtorId or 0}},
                        contract: contracts,
                    },
                    dataType: "json"
                });
            
                requestDetails.done(function( ret ) {
                    json = ret;
                    if (json != ""){
                        requestOk = true;
                    }else{
                        return false;
                    }
                });
            
                requestDetails.fail(function( jqXHR, textStatus ) {
                    $(".close").click();
                    showMessage("Erro ao buscar dados do devedor. Tente novamente.");
                    return false;
                });
                
                requestDetails.always(function() {
                    if (requestOk){
                    //> Begin [Identificação]
                        $('#detail-Ds_Nome').val(json.debtor.Ds_Nome);
                        $('#detail-Cd_CICCGC').val(json.debtor.Cd_CICCGC);
                        $('#detail-Dt_Nascimento').val(json.debtor.Dt_Nascimento);
                        $('#detail-Cd_EstadoCivil').val(json.debtor.Cd_EstadoCivil);
                        $('#detail-Ds_Conjuge').val(json.debtor.Ds_Conjuge);
                        //$('#detail-Cd_Sexo').val(json.debtor.Cd_Sexo); Gender is set directly on load 

                        $('#detail-Cd_EstadoCivil').trigger("chosen:updated");
                    //> End [Identificação]

                    //> Begin [Filiação]
                        $('#detail-Ds_Pai').val(json.debtor.Ds_Pai);
                        $('#detail-Ds_Mae').val(json.debtor.Ds_Mae);
                    //> End [Filiação]

                    //> Begin [Profissão]
                        $('#detail-Ds_Cargo').val(json.debtor.Ds_Cargo);
                        $('#detail-Ds_Trabalho').val(json.debtor.Ds_Trabalho);
                    //> End [Profissão]

                    //> Begin [Contato]
                        $('#detail-Dt_Contato').text(jQuery.format.date(json.debtor.Dt_Contato, longDateFormat));
                        $('#detail-Cd_Cobrador').text(json.debtor.Cd_Cobrador);
                        $('#detail-Cd_CredorDebtor').text(json.debtor.Cd_Credor);
                        $('#detail-Cd_GrupoTrabalho').text(json.debtor.Cd_GrupoTrabalho);
                        $('#detail-Cd_RamoAtividade').text(json.debtor.Cd_RamoAtividade);
                    //> End [Contato]
                    
                    //> Begin [Comissionado]
                        $('#detail-Cd_CobradorInt').text(json.debtor.Cd_CobradorInt);
                        $('#detail-Cd_CobradorExt').text(json.debtor.Cd_CobradorExt);
                        $('#detail-Cd_CobradorRec').text(json.debtor.Cd_CobradorRec);
                        $('#detail-Cd_CobradorCam').text(json.debtor.Cd_CobradorCam);
                    //> End [Comissionado]
                    
                    //> Begin [Ocorrências]
                        $('#detail-Cd_Classe').text(json.debtor.Cd_Classe);
                        $('#detail-Ds_ObsOco').text(json.debtor.Ds_ObsOco);
                        $('#detail-Cd_Anistia').text(json.debtor.Cd_Anistia);
                        $('#detail-Cd_UltHistMan').text(json.debtor.Cd_UltHistMan);
                        $('#detail-Cd_GrupoOcorrencia').text(json.debtor.Cd_GrupoOcorrencia);
                        $('#detail-Cd_ZonaCob').text(json.debtor.Cd_ZonaCob);
                    //> End [Ocorrências]

                    //> Begin [Outros]
                        $('#detail-Cd_Credor').text(json.contract.Cd_Credor);
                        $('#detail-Cd_DevCre').text(json.contract.Cd_DevCre);
                        $('#detail-Dt_Compra').text(jQuery.format.date(json.contract.Dt_Compra, shortDateFormat));
                        $('#detail-Ds_Observacao').text(json.contract.Ds_Observacao);

                        $('#detail-Dt_Entrada').text(jQuery.format.date(json.contract.Dt_Entrada, longDateFormat));
                        $('#detail-Dt_Devolucao').text(jQuery.format.date(json.contract.Dt_Devolucao, longDateFormat));
                        $('#detail-Cd_Aviso').text(json.contract.Cd_Aviso);
                        $('#detail-Ds_UsoCliente').text(json.contract.Ds_UsoCliente);
                        $('#detail-Nr_Conta').text(json.contract.Nr_Conta);

                        $('#detail-Cd_Score_Int').text(json.debtor.Cd_Score_Int);
                        $('#detail-Cd_Score_Ext').text(json.debtor.Cd_Score_Ext);
                    //> End [Outros]
                    }

                    hideLoader();
                });
            }
        </script>
    @endpush