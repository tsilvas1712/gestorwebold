@extends('templates.admin')

@section('content')
    <div class="page-header">
        <h1>
            Alteração de senha
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
            @if (session('error'))
                <div class="alert alert-danger" style="margin-right: 20px;">
                    <button class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
        
                    <i class="ace-icon fa fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-info">
                    <button class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
        
                    <i class="ace-icon fa fa-hand-o-right"></i>
                    {{ session('success') }}
                </div>
            @endif
    
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/users/change_password/store') }}">
                {{ csrf_field() }}
              
                <div class="form-group{{ $errors->has('passwordold') ? ' has-error' : '' }}">
                    <label for="password" class="col-sm-3 control-label no-padding-right">Senha Atual</label>

                    <div class="col-sm-9">
                        <input id="password" type="password" class="col-xs-10 col-sm-5" name="passwordold" required>

                        @if ($errors->has('passwordold'))
                            <span class="help-block">
                                <strong>{{ $errors->first('passwordold') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-sm-3 control-label no-padding-right">Nova Senha</label>

                    <div class="col-sm-9">
                        <input id="password" type="password" class="col-xs-10 col-sm-5" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-sm-3 control-label no-padding-right">Confirmar Senha</label>

                    <div class="col-sm-9">
                        <input id="password-confirm" type="password" class="col-xs-10 col-sm-5" name="password_confirmation" required>
                    </div>
                </div>

                <div class="clearfix form-actions">
                    <div class="col-md-offset-2 col-md-8">
                        <button type="submit" class="btn btn-success">
                            Alterar Senha
                        </button>
                    </div>
                </div>	

            </form>
    </div>

@endsection
