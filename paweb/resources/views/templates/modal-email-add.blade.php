    <div id="modal-email-add" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Adicionar Email</h4>
                </div>

                <form class="form-horizontal" method="POST" action="{{url('/email/store')}}" name="email-add" id="email-add">
                    {!! csrf_field() !!}
                    <input type="hidden" name="email-cdDevedor" value="{{$debtorId or 0}}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="widget-box" >
                                    <div class="widget-header">
                                        <h4 class="widget-title">Email</h4>
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
                                                                <div class="col-sm-9 no-padding">
                                                                    <div class="col-sm-11 no-padding">
                                                                        <label for="email-dsEmail">Email</label>
                                                                        <input class="form-control" type="email" id="email-dsEmail" name="email-dsEmail" maxlength="60" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-3 no-padding">
                                                                    <div class="col-sm-12 no-padding">
                                                                        <label for="email-cdClassificacao">Classificação</label>
                                                                    </div>
                                                                    <div class="col-sm-12 no-padding">
                                                                        <select class="form-control chosen-select col-sm-12" id="email-cdClassificacao" name="email-cdClassificacao" data-placeholder="Selecione um status">
                                                                            <option value=""></option>
                                                                            @if(isset($emailLevels))
                                                                                @foreach ($emailLevels as $emailLevel)
                                                                                    <option value="{{$emailLevel->cd_classificacao}}">{{$emailLevel->ds_classificacao}}</option>
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" type="submit" name="submit-email" form="email-add" >
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


    @push('functions')
        <script>
            $(function() {
                $('#email-add').on('submit', function(e) {
                    if ($('#email-cdClassificacao').val() == ""){
                        showMessage('É obrigatório informar a classificação do email.');
                        return false;
                    }
                });
            });
        </script>
    @endpush