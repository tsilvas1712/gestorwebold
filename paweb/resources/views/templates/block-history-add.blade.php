    <div class="col-sm-12 no-padding">
        <form class="form-horizontal" method="POST" action="{{url('/history/store')}}" name="history-add" id="history-add">
            {!! csrf_field() !!}
            <input type="hidden" name="history-cdDevedor" value="{{$debtorId or 0}}">
            <input type="hidden" name="history-cdCredor" id="history-cdCredor" value="">

            <div class="col-sm-5 no-padding">
                <div class="col-sm-12 no-padding">
                    <div class="block block-gray col-sm-3 no-padding">
                        <div class="block-label">
                            Ocorrência
                        </div>
                    </div>
                    <div class="col-sm-9 no-padding">
                        <select class="chosen-select form-control" name="history-cdHistorico" id="history-cdHistorico" data-placeholder="Selecione um histórico...">
                            <option value=""></option>
                            @if (isset($historyTypes))
                                @foreach ($historyTypes as $historyType)
                                    <option value="{{$historyType->Cd_Historico}}">{{$historyType->Cd_Historico}} - {{$historyType->Ds_Historico}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 no-padding">
                    <div class="block block-gray col-sm-3 no-padding">
                        <div class="block-label">
                            Status da Ficha
                        </div>
                    </div>
                    <div class="block col-sm-9 no-padding">
                        <div class="block-label">
                            {{$statusDebtor[0]->ds_GrupoStatus or "NÃO TRABALHADO"}}
                        </div>
                    </div>
                </div>        
            </div>

            <div class="col-sm-4 no-padding">
                <div class="col-sm-12 no-padding">
                    <div class="block block-double block-gray col-sm-2 no-padding">
                        <div class="block-label">
                            Texto
                        </div>
                    </div>
                    <div class="col-sm-10 no-padding">
                        <textarea class="form-control limited" name="history-dsHistorico" id="history-dsHistorico" maxlength="255" required></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 no-padding">
                <div class="col-sm-6 no-padding">
                    <div class="block block-gray col-sm-12 no-padding">
                        <div class="block-label">
                            Data Agenda
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 no-padding">
                    <div class="block-label col-sm-12 no-padding">
                        <input class="form-control" type="date" name="history-dtAgenda" id="history-dtAgenda" value="<?=(date('Y-m-d'))?>" min="<?=(date('Y-m-d'))?>" required/>
                    </div>
                </div>
                <div class="col-sm-12 no-padding">
                    <button class="btn btn-primary btn-xs btn-block" type="submit" form="history-add" style="height: 34px;">
                        <i class="ace-icon fa fa-save"></i>
                        Gravar Ocorrência
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('functions')
        <script>
            $(function() {
                $('#history-add').on('submit', function(e) {
                    contracts = $('#table-contracts').bootstrapTable('getSelections');
                    if (contracts.length == 0){
                        $(".close").click();
                        showMessage("É preciso selecionar um contrato primeiro.");
                        return false;
                    }else if (contracts.length > 1){
                        $(".close").click();
                        showMessage("Você deve selecionar apenas 1 registro.");
                        return false;
                    }else if ( (contracts[0].Cd_Especie == "") || (contracts[0].Cd_Especie == "&nbsp;") ){
                        $(".close").click();
                        showMessage("É preciso selecionar um contrato primeiro.");
                        return false;
                    }

                    if ((contracts[0].Cd_Credor == '') || (contracts[0].Cd_Credor == '0')){
                        showMessage("É preciso selecionar um contrato primeiro.");
                        return false;
                    }

                    $('#history-cdCredor').val(contracts[0].Cd_Credor);

                    if ($('#history-cdHistorico').val() == ""){
                        showMessage('É obrigatório informar o tipo de ocorrência.');
                        return false;
                    }
                });
            });
        </script>
    @endpush

