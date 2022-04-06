@extends('templates.main')

@section('content')
    <div class="col-sm-12 no-padding">
        @include('templates.block-identification')

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12">
            <div class="col-sm-9 row no-padding">
                <div class="widget">
                    <fieldset>
                        <label class="check-custom check-white" for="history-manual" show-history="true" history-type="M">Históricos Manuais</label>
                        <input type="checkbox" name="check-history" id="history-manual" checked>

                        <label class="check-custom check-pink" for="history-automatic" show-history="true" history-type="A">Históricos Automáticos</label>
                        <input type="checkbox" name="check-history" id="history-automatic" checked>

                        <label class="check-custom check-blue" for="history-system" show-history="true" history-type="S">Históricos Sistema</label>
                        <input type="checkbox" name="check-history" id="history-system" checked>

                        <label class="check-custom check-yellow" for="history-dialer" show-history="true" history-type="D">Históricos Discador</label>
                        <input type="checkbox" name="check-history" id="history-dialer" checked>

                        <label class="check-custom check-green" for="history-positive" show-history="true" history-type="" history-positive="true">Históricos Positivos</label>
                        <input type="checkbox" name="check-history" id="history-positive" checked>

                        <label class="check-custom check-red" for="history-negative" show-history="true" history-type="" history-positive="false">Históricos Negativos</label>
                        <input type="checkbox" name="check-history" id="history-negative" checked>
                    </fieldset>
                </div>  
            </div>
        
            <div class="col-sm-3 no-padding">
                @include('templates.block-controls')
            </div>
        </div>
    
        <div class="col-sm-12 no-padding history-colored">
            @include('templates.block-history-list')
        </div>
    </div>
@endsection

@push('functions')
    <script>
            $( ".check-custom" ).click(function() {
                positive = $(this).attr("history-positive");
                type = $(this).attr("history-type");

                if ($(this).attr("show-history") == "true"){
                    $(this).attr("show-history", false);
                    //> if type is empty, so hide positive or negative
                    if (type == ""){
                        if (positive == "true"){
                            //> hide positives
                            $( ".history-colored #histories-table tr.type-M.positive-1" ).addClass( "tr-hidden" );
                        }else{
                            //> hide negatives
                            $( ".history-colored #histories-table tr.type-M.positive-0" ).addClass( "tr-hidden" );
                        }
                    }else{
                        // else hide history types
                        $( ".history-colored #histories-table tr.type-"+type ).addClass( "tr-hidden" );
                    }
                }else{
                    $(this).attr("show-history", true);

                    //> if type is empty, so show positive or negative
                    if (type == ""){
                        if (positive == "true"){
                            //> show positives
                            $( ".history-colored #histories-table tr.type-M.positive-1" ).removeClass( "tr-hidden" );
                        }else{
                            //> show negatives
                            $( ".history-colored #histories-table tr.type-M.positive-0" ).removeClass( "tr-hidden" );
                        }
                    }else{
                        // else show history types
                        $( ".history-colored #histories-table tr.type-"+type ).removeClass( "tr-hidden" );
                    }
                }
            });
    </script>
@endpush