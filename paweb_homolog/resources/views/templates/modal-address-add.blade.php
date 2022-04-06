    <div id="modal-address-add" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Adicionar Endereço</h4>
                </div>
                <form class="form-horizontal" method="POST" action="{{url('/address/store')}}" name="address-add" id="address-add">
                    {!! csrf_field() !!}
                    <input type="hidden" name="address-cdDevedor" value="{{$debtorId or 0}}">
                    
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="widget-box" >
                                    <div class="widget-header">
                                        <h4 class="widget-title">Endereço</h4>
                                        <span class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="ace-icon fa fa-chevron-up"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="widget-body ">
                                        <div class="widget-main">
                                            <table width="100%">
                                                <tr>
                                                    <td>
                                                        <div class="col-sm-12 no-padding">
                                                            <div class="col-sm-12 no-padding">
                                                                <div class="col-sm-3 no-padding">
                                                                    <label for="address-cdCep">CEP</label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="address-cdCep" name="address-cdCep" class="form-control search-query cep" placeholder="90.000-000" style="min-width: 90px;" maxlength="10" required>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" id="search-zipcode" class="btn btn-success btn-sm">
                                                                                <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                                                                Buscar CEP
                                                                            </button>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="address-dsRua">Rua</label>
                                                                    <input class="form-control" type="text" id="address-dsRua" name="address-dsRua" maxlength="80" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-2 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="address-dsNumero">Nº</label>
                                                                    <input class="form-control" type="text" id="address-dsNumero" name="address-dsNumero" maxlength="10" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4 no-padding">
                                                                <div class="col-sm-12 no-padding">
                                                                    <label for="address-dsCompl">Complemento</label>
                                                                    <input class="form-control" type="text" id="address-dsCompl" name="address-dsCompl" maxlength="30" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 no-padding">
                                                            <div class="col-sm-4 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="address-dsBairro">Bairro</label>
                                                                    <input class="form-control" type="text" id="address-dsBairro" name="address-dsBairro" maxlength="40" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="address-dsCidade">Cidade</label>
                                                                    <input class="form-control" type="text" id="address-dsCidade" name="address-dsCidade" maxlength="50" required />
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-2 no-padding">
                                                                <div class="col-sm-12 no-padding">
                                                                    <label for="address-sgUF">Estado</label><br>
                                                                    <select class="form-control chosen-select" id="address-sgUF" name="address-sgUF" required>
                                                                        @if(isset($states))
                                                                            @foreach ($states as $state)
                                                                            <option value="{{$state->Cd_UF}}">
                                                                                {{$state->Cd_UF}}
                                                                            </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-12 no-padding">
                                                            <div class="col-sm-3 no-padding">
                                                                <div class="col-sm-11 no-padding">
                                                                    <label for="address-cdStatus">Status</label><br>
                                                                    <select class="form-control chosen-select" id="address-cdStatus" name="address-cdStatus" data-placeholder="Selecione um status" required>
                                                                        <option value=""></option>
                                                                        @if(isset($addressLevels))
                                                                            @foreach ($addressLevels as $addressLevel)
                                                                            <option value="{{$addressLevel->cd_classificacao}}">
                                                                                {{$addressLevel->ds_classificacao}}
                                                                            </option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>
                                                            </div>
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
                        <button class="btn btn-sm btn-primary" type="submit" name="submit-address" form="address-add" >
                            <i class="ace-icon fa fa-save"></i>
                            Gravar
                        </button>
                
                        <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="ace-icon fa fa-times"></i>
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >

    $(document).ready(function() {
        function clearFormAddress() {
            $("#address-dsRua").val("");
            $("#address-dsBairro").val("");
            $("#address-dsCidade").val("");
            $("#address-sgUF").val("");
        }

        function searchZipcode(){
            var cep = $("#address-cdCep").val().replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {
                    $("#address-dsRua").val("...");
                    $("#address-dsBairro").val("...");
                    $("#address-dsCidade").val("...");
                    $("#address-sgUF").val("...");
                    $('#address-sgUF').trigger("chosen:updated");
                    $('#address-sgUF').trigger("liszt:updated");

                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#address-dsRua").val(dados.logradouro);
                            $("#address-dsBairro").val(dados.bairro);
                            $("#address-dsCidade").val(dados.localidade);
                            $("#address-sgUF").val([dados.uf]).trigger("chosen:updated.chosen");;
                        }else{
                            clearFormAddress();
                        }
                    });
                }else{
                    clearFormAddress();
                }
            }else{
                clearFormAddress();
            }
        }

        $("#search-zipcode").click(function() {
            searchZipcode();
        });
            
        //Quando o campo cep perde o foco.
        $("#address-cdCep").blur(function() {
            searchZipcode();
        });
    });

</script>

