    <div id="modal-telephone-add" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="bigger">Adicionar Telefone</h4>
                </div>

                <form class="form-horizontal" method="POST" action="{{url('/telephone/store')}}" name="telephone-add" id="telephone-add">
                    {!! csrf_field() !!}
                    <input type="hidden" name="telephone-cdDevedor" value="{{$debtorId or 0}}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="widget-box" >
                                    <div class="widget-header">
                                        <h4 class="widget-title">Telefone</h4>
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
                                                                <div class="col-sm-2 no-padding">
                                                                    <div class="col-sm-11 no-padding">
                                                                        <label for="telephone-cdDdd">DDD</label>
                                                                        <input class="form-control" type="number" id="telephone-cdDdd" name="telephone-cdDdd" min="11" max="99" maxlength="2" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 no-padding">
                                                                    <div class="col-sm-11 no-padding">
                                                                        <label for="telephone-cdTelefone">Telefone</label>
                                                                        <input class="form-control" type="number" id="telephone-cdTelefone" name="telephone-cdTelefone" min="10000000" max="999999999" maxlength="9" required />
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 no-padding">
                                                                    <div class="col-sm-12 no-padding">
                                                                        <label for="telephone-cdClassificacao">Classificação</label><br>
                                                                        <select class="form-control chosen-select col-sm-12" id="telephone-cdClassificacao" name="telephone-cdClassificacao" data-placeholder="Selecione um status">
                                                                            <option value=""></option>
                                                                            @if (isset($telephoneLevels))
                                                                                @foreach ($telephoneLevels as $telephoneLevel)
                                                                                    <option value="{{$telephoneLevel->cd_classificacao}}">
                                                                                        {{$telephoneLevel->ds_classificacao}}
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" type="submit" name="submit-telephone" form="telephone-add" >
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
                $('#telephone-add').on('submit', function(e) {
                    if ($('#telephone-cdClassificacao').val() == ""){
                        showMessage('É obrigatório informar a classificação do telefone.');
                        return false;
                    }
                });
            });
        </script>
    @endpush
