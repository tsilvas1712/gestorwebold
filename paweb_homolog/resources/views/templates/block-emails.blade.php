    <div class="widget-box" >
        <div class="widget-header">
            <h4 class="widget-title">Emails</h4>

            <div style="float:right">
                <a href="#modal-email-add" class="btn btn-primary btn-xs" role="button" data-toggle="modal">
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
                                            <th scope="col">Email</th>
                                            <th scope="col">Classif.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($emails))
                                            @foreach ($emails as $email)
                                            <tr>
                                                <td>{{$email->Ds_Email}}</td>
                                                <td class="no-padding">
                                                    <select class="col-sm-12 no-padding select-email-level" id="email-level-{{trim($email->Ds_Email)}}" 
                                                            data-placeholder="Selecione..." 
                                                            data-email="{{trim($email->Ds_Email)}}"
                                                            data-altered="false"
                                                            onchange="markAlterEmail(this);">
                                                        @if (isset($emailLevels))
                                                            @foreach ($emailLevels as $emailLevel)
                                                                <option value="{{$emailLevel->cd_classificacao}}" @if($email->Cd_Classificacao == $emailLevel->cd_classificacao) {{"selected"}} @endif>
                                                                    {{$emailLevel->ds_classificacao}}
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
            function markAlterEmail(obj){
                $(obj).addClass( 'select-altered');
                $(obj).attr( 'data-altered', true);
            }
        </script>
    @endpush