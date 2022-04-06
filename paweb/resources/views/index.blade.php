@extends('templates.main')

@section('content')
    <div class="col-sm-12 no-padding">
        @include('templates.block-identification')

        <div class="col-sm-12 space-4"></div>

        <div class="col-sm-12 no-padding">
            <div class="col-sm-9 no-padding block-address-contracts">
                @include('templates.block-address')

                <div class="col-sm-12 space-4"></div>

                @include('templates.block-contracts')
            </div>
    
            <div class="col-sm-3 block-phone-email">
                @include('templates.block-controls')

                <div class="col-sm-12 space-4"></div>
                <br clear="all"/>
            
                @include('templates.block-telephones')
    
                <div class="col-sm-12 space-4"></div>
                <br clear="all"/>

                @include('templates.block-emails')
            </div>
        </div>
    </div>

    <div class="col-sm-12 no-padding">
        <div class="col-sm-12 space-8"></div>

        @include('templates.block-history-add')
        @include('templates.block-history-list')
    </div>

@endsection