    <div id="modal-address" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Endereços do devedor</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <div class="table-responsive table-limited no-padding">
                                <table class="table table-striped table-bordered" id="address-table" data-toggle="table" data-height="415">
                                    <thead>
                                        <tr>
                                            <th data-sortable="true" scope="col">Rua</th>
                                            <th data-sortable="true" scope="col">Nº</th>
                                            <th data-sortable="true" scope="col">Complemento</th>
                                            <th data-sortable="true" scope="col">Bairro</th>
                                            <th data-sortable="true" scope="col">Cidade</th>
                                            <th data-sortable="true" scope="col">UF</th>
                                            <th data-sortable="true" scope="col">CEP</th>
                                            <th data-sortable="true" scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($addresses))
                                        @foreach ($addresses as $address)
                                        <tr>
                                            <td>{{$address->Ds_Logradouro}}</td>
                                            <td>{{$address->Ds_NumeroEnd}}</td>
                                            <td>{{$address->Ds_Complemento}}</td>
                                            <td>{{$address->Ds_Bairro}}</td>
                                            <td>{{$address->Ds_Cidade}}</td>
                                            <td>{{$address->Sg_UF}}</td>
                                            <td>{{$address->Cd_Cep}}</td>
                                            <td>
                                                <select class="col-sm-12 no-padding select-address-level" id="address-level-{{trim($address->Cd_Endereco)}}" 
                                                        data-placeholder="Selecione..." 
                                                        data-address-id="{{trim($address->Cd_Endereco)}}"
                                                        data-altered="false"
                                                        onchange="markAlterAddress(this);">
                                                    @if (isset($addressLevels))
                                                        @foreach ($addressLevels as $addressLevel)
                                                            <option value="{{$addressLevel->cd_classificacao}}" @if($address->Cd_Classificacao == $addressLevel->cd_classificacao) {{"selected"}} @endif>
                                                                {{$addressLevel->ds_classificacao}}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="#modal-address-add" class="btn btn-sm btn-primary" role="button" data-toggle="modal">
                        <i class="ace-icon fa fa-plus-circle"></i>
                        Adicionar
                    </a>
            
                    <a href="#" id="address-save" class="btn btn-sm btn-success" role="button">
                        <i class="ace-icon fa fa-save"></i>
                        Gravar
                    </a>

                    <a href="#" class="btn btn-sm btn-danger" data-dismiss="modal">
                        <i class="ace-icon fa fa-times"></i>
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form method="POST" action="{{url('/address/update')}}" name="address-update" id="address-update">
        {!! csrf_field() !!}
        <input type="hidden" name="address-cdDevedor" value="{{$debtorId or 0}}">
        <input type="hidden" id="address-json" name="address-json" value="">
    </form>

    @push('functions')
        <script>
            function markAlterAddress(obj){
                $(obj).addClass( 'select-altered');
                $(obj).attr( 'data-altered', true);
            }

            $('#address-save').on('click', function(e){
                var addresses = [];
                $('.select-address-level.select-altered').each(function () {
                    addresses.push({
                                        id: $(this).attr('data-address-id'), 
                                        status: $(this).val(),
                                    }
                                );
                });

                if (addresses.length == 0){
                    showMessage('Nenhuma alteração foi detectada.');
                }else{
                    saveAddressChanges(addresses);
                }
            });
            
            function saveAddressChanges(addresses){
                $('#address-json').val(JSON.stringify(addresses));
                $('#address-update').submit();
            }

        </script>
    @endpush