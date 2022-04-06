@extends('templates.login')

@section('content')
    <div class="col-xs-12 col-sm-4 card card-container">
        <h3>Bem-vindo</h3>
            <img id="profile-img" class="profile-img-card" src="{{url('assets/images/logo_bl.jpg')}}" />
            <p id="profile-name" class="profile-name-card">Faça login com seu<br>usuário de rede</p>

            <form autocomplete="off" class="form-horizontal form-signin" role="form" method="POST" action="{{ url('/loginldap') }}">
                {{ csrf_field() }}

                <span id="reauth-email" class="reauth-email"></span>
                <div>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Usuario" required autofocus>
                </div>
                
                <div>
                    <input type="password" style="float: left;" name="password" id="password" class="form-control" placeholder="Senha" required>
                    <span id="eye" style="cursor: pointer;float: right;position: absolute; z-index: 1;right: 45px;margin-top: 10px; color: #555555">
                        <i id="i-eye" class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                    @if (isset($error))
                        <span class="help-block">
                            <strong>{{ $error }}</strong>
                        </span>
                    @endif
                </div>
    
                <button class="btn btn-primary btn-block" type="submit">Iniciar Sessão</button>
        </form>
    </div>    
@endsection
