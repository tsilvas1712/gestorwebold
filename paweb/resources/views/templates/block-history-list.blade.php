    <div class="col-sm-12 table-responsive table-limited no-padding">
        <table id="histories-table" class="table table-bordered" data-toggle="table" data-height="380">
            <thead>
                <tr>
                    <th data-sortable="true" scope="col">Credor</th>
                    <th data-sortable="true" scope="col">Data</th>
                    <th data-sortable="true" scope="col">Negociador</th>
                    <th data-sortable="true" scope="col">DDD</th>
                    <th data-sortable="true" scope="col">Telefone</th>
                    <th data-sortable="true" scope="col">Descrição</th>
                    <th data-sortable="true" scope="col">Texto</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($histories))
                    @foreach ($histories as $history)
                    <tr class="positive-{{$history->FL_Positivo}} type-{{$history->Fl_TipoHistorico}}">
                        <td>{{$history->Ds_Credor}}</td>
                        <td>{{asDateTime($history->Dt_Ocorrencia)}}</td>
                        <td>{{$history->Ds_Comissionado}}</td>
                        <td>{{$history->Cd_DDD}}</td>
                        <td>{{$history->Cd_Telefone}}</td>
                        <td>{{$history->Ds_Historico}}</td>
                        <td>{{$history->MM_Texto}}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @push('functions')
        <script>
            //$('#histories-table').bootstrapTable({});
        </script>
    @endpush