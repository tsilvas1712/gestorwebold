@extends('templates.main')

@section('content')
    <div class="col-sm-12 no-padding">
        @include('templates.block-identification')

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12">
       
            <div class="col-sm-offset-9 col-sm-3 no-padding">
                @include('templates.block-controls')
            </div>
        </div>
    
        <div class="col-sm-12 no-padding">
            @include('templates.block-agreements-stored')
        </div>

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12 no-padding">
            @include('templates.block-agreements-installment')
        </div>

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12 no-padding">
            @include('templates.block-agreements-original')
        </div>

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12 no-padding">
            @include('templates.block-agreements-billet')
        </div>
    </div>
@endsection

