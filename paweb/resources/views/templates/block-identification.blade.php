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
            <div class="widget-main">
                <table>
                    <tr>
                        <td style="width:14%">
                            <div class="col-sm-6 no-padding">
                                <div class="col-sm-3 no-padding">
                                    <div class="col-sm-11 no-padding">
                                        <label for="debtorId">Código</label>
                                        <input class="form-control" type="number" id="debtorId" max="999999999" value="{{$debtor->Cd_Devedor or $debtorId}}" />
                                    </div>
                                </div>
                                <div class="col-sm-9 no-padding">
                                    <div class="col-sm-11 no-padding">
                                        <label for="nameDebtor">Nome</label>
                                    <input class="form-control" type="text" id="nameDebtor" value="{{$debtor->Ds_Nome or ''}}" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 no-padding">
                                <div class="col-sm-3 no-padding">
                                    <div class="col-sm-11 no-padding">
                                        <label for="cpfDebtor">CPF</label>
                                        <input class="form-control" type="text" id="cpfDebtor" value="{{$debtor->Cd_CICCGC or ''}}" readonly />
                                    </div>
                                </div>
        
                                <div class="col-sm-3 no-padding">
                                    <div class="col-sm-11 no-padding">
                                        <label for="dtbirthDebtor">Data Nasc.</label>
                                        <input class="form-control" type="date" id="dtbirthDebtor" value="{{$debtor->Dt_Nascimento or ''}}" readonly  />
                                    </div>
                                </div>

                                <div class="col-sm-3 no-padding">
                                    <div class="col-sm-11 no-padding">
                                        <label for="genderDebtor">Sexo</label>
                                        <div class="input-group col-sm-12">
                                            <label>
                                            <input name="genderDebtor" type="radio" class="ace" @if ( (isset($debtor) && (isset($debtor->Cd_Sexo) ) ) && ($debtor->Cd_Sexo == 'M')) {{'checked'}} @endif />
                                                <span class="lbl">Masc.</span>
                                            </label>
                                            <label>
                                                <input name="genderDebtor" type="radio" class="ace" @if ( (isset($debtor) && (isset($debtor->Cd_Sexo) ) ) && ($debtor->Cd_Sexo == 'F')) {{'checked'}} @endif />
                                                <span class="lbl">Fem.</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3 no-padding">
                                    <a href="#modal-search" role="button" data-toggle="modal" class="btn btn-block btn-success btn-xs">
                                        <i class="ace-icon fa fa-search"></i>
                                        Pesquisar
                                    </a><br>
                                    <a href="#modal-details" role="button" data-toggle="modal" class="btn btn-block btn-yellow btn-xs">
                                        <i class="ace-icon fa fa-info-circle"></i>
                                        Mais informações
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @push('functions')
        <script>
            @if(!$debtor && $debtorId > 0)
                showMessage("Devedor não localizado.");
            @endif

            debtorId = "{{$debtor->Cd_Devedor or $debtorId}}";

            function newDebtor(newId = '', phone = '', debtorName = ''){
                console.clear();
                msg = 'Abrindo nova ficha...';
                if (debtorName != ''){
                    msg += '<br>' + debtorName;
                }
                if (debtorName != ''){
                    msg += '<br>Nro. ' + phone;
                }
                showLoader(msg);
                if (newId != ''){
                    $( "#debtorId" ).val(newId);
                }
                window.location.href = "{{url('/')}}/debtor/"+$( "#debtorId" ).val();
            }

            $("#debtorId").keypress(function(e) {
                if(e.which == 13) {
                    newDebtor();
                }
            });

            $( "#debtorId" ).blur(function() {
                if ( ( $( "#debtorId" ).val() != debtorId ) && ( $( "#debtorId" ).val() != "" )) {
                    newDebtor();
                }
            });
        </script>
    @endpush
