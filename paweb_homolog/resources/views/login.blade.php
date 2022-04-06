<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}" />

		<link href="{{url('css/login.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="{{url('assets/font-awesome/4.7.0/css/font-awesome.min.css')}}" />

		<title>Gestor - PA web</title>
	</head>
	<body>
		<div class="container">
			<div class="col-xs-12 col-sm-4 card card-container">
				<h3>Bem-vindo</h3>
					<img id="profile-img" class="profile-img-card" src="{{url('assets/images/logo_bl.jpg')}}" />
					<p id="profile-name" class="profile-name-card">Faça login com seu<br>usuário de rede</p>
		
					<form autocomplete="off" class="form-horizontal form-signin" role="form" method="POST" action="{{ url('/login') }}">
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

                            @if($errors->any())
								<span class="help-block">
									<strong>{{$errors->first()}}</strong>
								</span>
                            @endif
						</div>
			
						<button class="btn btn-primary btn-block" type="submit">Iniciar Sessão</button>
				</form>
			</div>    					
	  	</div>  
		
		<script type="text/javascript" src="{{url('assets/login/html.js')}}"></script>
        <script type="text/javascript" src="{{url('assets/login/app.js')}}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="{{url('assets/js/jquery-ui.custom.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/jquery.ui.touch-punch.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/init.js')}}"></script>
		<script src="{{url('assets/js/jquery.sparkline.index.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/jquery.flot.min.js')}}" charset="utf-8"></script>
        <script src="{{url('assets/js/jquery.flot.pie.min.js')}}" charset="utf-8"></script>
        <script src="{{url('assets/js/chosen.jquery.min.js')}}"></script>
		<script src="{{url('assets/js/jquery.inputlimiter.min.js')}}"></script>
		<script src="{{url('assets/js/jquery.gritter.min.js')}}"></script>
		<script type="text/javascript" src="{{url('assets/js/maskedinput.min.js')}} "></script>

		<!-- ace scripts -->
		<script src="{{url('assets/js/ace-elements.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/ace.min.js')}}" charset="utf-8"></script>

		<!-- jquery-dateFormat -->
		<script src="{{url('assets/js/jquery-dateformat.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/jquery.formatCurrency.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/jquery.formatCurrency.i18n.js')}}" charset="utf-8"></script>


  		<script type="text/javascript">
			var senha = $('#password');
			var eye = $("#eye");
			var icon = $("#i-eye");
  
			eye.click(function() {
				if (senha.attr("type") == "text"){
					senha.attr("type", "password");
					icon.attr("class", "fa fa-eye")
				}else{
					senha.attr("type", "text");
					icon.attr("class", "fa fa-eye-slash")
				}
			});
		</script>
	</body>
</html>
  