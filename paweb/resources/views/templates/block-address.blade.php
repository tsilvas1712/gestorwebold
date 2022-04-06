    <div class="widget-box" >
        <div class="widget-header">
            <h4 class="widget-title">Endereços</h4>

            <div style="float:right">
                <a href="#modal-address" class="btn btn-yellow btn-xs" role="button" data-toggle="modal">
                    <i class="ace-icon fa fa-info-circle"></i>
                    Ver +
                </a>
            </div>

            <span class="widget-toolbar">
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>
            </span>
        </div>

        <div class="widget-body">
            <div class="widget-main no-padding">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="col-sm-12 table-responsive no-padding">
                                <table class="table table-striped table-bordered" data-toggle="table" data-height="110">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rua</th>
                                            <th scope="col">Nº</th>
                                            <th scope="col">Complemento</th>
                                            <th scope="col">Bairro</th>
                                            <th scope="col">Cidade</th>
                                            <th scope="col">UF</th>
                                            <th scope="col">CEP</th>
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
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
