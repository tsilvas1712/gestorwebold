<div class="widget-box" >
    <div class="widget-header">
        <h4 class="widget-title">Boletos</h4>

        <span class="widget-toolbar">
            <a href="#" data-action="collapse">
                <i class="ace-icon fa fa-chevron-up"></i>
            </a>
        </span>
    </div>

    <div class="widget-body ">
        <div class="widget-main no-padding">
            <table>
                <tr>
                    <td>
                        <div class="col-sm-12 table-responsive table-limited no-padding">
                            <table class="table table-striped table-bordered header-fixed">
                                <thead>
                                    <tr>
                                        <th scope="col">Cedente</th>
                                        <th scope="col">Nosso Número</th>
                                        <th scope="col">Dt. Processamento</th>
                                        <th scope="col">Dt. Vencimento</th>
                                        <th scope="col">Vl. Documento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($billets as $billet)
                                    <tr>
                                        <td>{{$billet->Cd_Cedente}}</td>
                                        <td>{{$billet->Nr_NossoNumero}}</td>
                                        <td>{{asDateTime($billet->Dt_Processamento)}}</td>
                                        <td>{{asDate($billet->Dt_Vencimento)}}</td>
                                        <td>{{asCurrency($billet->Vl_Documento)}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
