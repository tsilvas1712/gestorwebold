    <div class="widget-box" >
        <div class="widget-header">
            <h4 class="widget-title">Telefones</h4>

            <div style="float:right">
                <a href="#modal-telephone-add" class="btn btn-primary btn-xs" role="button" data-toggle="modal">
                    <i class="ace-icon fa fa-plus-circle"></i>
                    Add
                </a>
            </div>

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
                            <div class="col-sm-12 table-responsive no-padding">
                                <table class="table table-striped table-bordered" data-toggle="table" data-height="145">
                                    <thead>
                                        <tr>
                                            <th scope="col">&nbsp;</th>
                                            <th scope="col">DDD</th>
                                            <th scope="col">Telefone</th>
                                            <th scope="col">Classif.
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($telephones))
                                            @foreach ($telephones as $telephone)
                                            <tr @if( (trim($telephone->Cd_DDD) == trim($current_areaCode)) && (trim($telephone->Cd_Telefone) == trim($current_phone)) ) {{" class=active_phone "}} @endif>
                                                <td width="10px">
                                                    <a href="#" onclick="makeCall(this)" id="telephone-call" data-number="{{trim($telephone->Cd_DDD)}}{{trim($telephone->Cd_Telefone)}}" data-toggle="tooltip" title="Discagem manual">
                                                        <i class="ace-icon green fa fa-phone icon-only"></i>
                                                    </a>                                            
                                                </td>
                                                <td>{{$telephone->Cd_DDD}}</td>
                                                <td>{{$telephone->Cd_Telefone}}</td>
                                                <td class="no-padding">
                                                    <select class="col-sm-12 no-padding select-telephone-level" id="telephone-level-{{trim($telephone->Cd_DDD)}}-{{trim($telephone->Cd_Telefone)}}" 
                                                            data-placeholder="Selecione..." 
                                                            data-telephone="{{trim($telephone->Cd_Telefone)}}"
                                                            data-areacode="{{trim($telephone->Cd_DDD)}}"
                                                            data-altered="false"
                                                            onchange="markAlterTelephone(this);">
                                                        @if (isset($telephoneLevels))
                                                            @foreach ($telephoneLevels as $telephoneLevel)
                                                                <option value="{{$telephoneLevel->cd_classificacao}}" @if($telephone->Cd_Classificacao == $telephoneLevel->cd_classificacao) {{"selected"}} @endif>
                                                                    {{$telephoneLevel->ds_classificacao}}
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
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @push('functions')
        <script>
            function markAlterTelephone(obj){
                $(obj).addClass( 'select-altered');
                $(obj).attr( 'data-altered', true);
            }

            function makeCall(obj){
                phoneNumber = $(obj).attr("data-number");
                dialerExtension = '{{User::getDialerExtension()}}';
                bootbox.confirm({
                    message: "Confima a discagem para o telefone " + phoneNumber + "?",
                    buttons: {
                        confirm: {
                            label: 'Discar',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Cancelar',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result){
                            $.post('https://172.20.10.39/gestor/makeCall',{ramal: dialerExtension, phone: phoneNumber},function(val){
                                console.log(val);
                            });
                        }
                    }
                });
            }

        </script>
    @endpush