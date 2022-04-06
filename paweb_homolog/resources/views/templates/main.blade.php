<!DOCTYPE html>
    <html lang="pt-br">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta charset="ISO-8859-1" />
		<title>{{$title or "Gestor - PA web"}}</title>

		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{url('assets/font-awesome/4.7.0/css/font-awesome.min.css')}}" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css">

		<!-- jQuery UI -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
		<!-- text fonts -->
		<link rel="stylesheet" href="{{url('assets/css/fonts.googleapis.com.css')}}" />

		<!-- ace styles -->
        <link rel="stylesheet" href="{{url('assets/css/chosen.min.css')}}" />
		<link rel="stylesheet" href="{{url('assets/css/jquery.gritter.min.css')}}" />
        <link rel="stylesheet" href="{{url('assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="{{url('assets/css/ace-part2.min.css')}}" class="ace-main-stylesheet" />
		<![endif]-->
		<link rel="stylesheet" href="{{url('assets/css/ace-skins.min.css')}}" />
		<link rel="stylesheet" href="{{url('assets/css/ace-rtl.min.css')}}" />
		<link rel="stylesheet" href="{{url('css/style.css')}}" />

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="{{url('assets/css/ace-ie.min.css')}}" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="{{url('assets/js/ace-extra.min.js')}}" charset="utf-8"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="{{url('assets/js/html5shiv.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/respond.min.js')}}" charset="utf-8"></script>
		<![endif]-->

		@stack('plugins')
	</head>

	<body class="no-skin">
		<div id="jqgrid-loading-wrapper" class="jqgrid-loading-wrapper">
			<div class="jqgrid-loading ui-state-default ui-state-active">
				<div id="message">Aguarde...</div>
				<svg width="75%" height="75%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-bricks">
					<rect ng-attr-fill="#020f76" ng-attr-x="50.173" ng-attr-y="50.173" ng-attr-width="40" ng-attr-height="40" ng-attr-rx="5" ng-attr-ry="5" fill="#020f76" x="50.173" y="52.5" width="40" height="40" rx="5" ry="5">
						<animate attributeName="x" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="-1.375s" repeatCount="indefinite"></animate>
						<animate attributeName="y" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="-1s" repeatCount="indefinite"></animate>
					</rect>
					<rect ng-attr-fill="#20639c" ng-attr-x="52.5" ng-attr-y="52.5" ng-attr-width="40" ng-attr-height="40" ng-attr-rx="5" ng-attr-ry="5" fill="#20639c" x="52.5" y="7.5" width="40" height="40" rx="5" ry="5">
						<animate attributeName="x" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="-0.875s" repeatCount="indefinite"></animate>
						<animate attributeName="y" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="-0.5s" repeatCount="indefinite"></animate>
					</rect>
					<rect ng-attr-fill="#5da633" ng-attr-x="7.5" ng-attr-y="7.5" ng-attr-width="40" ng-attr-height="40" ng-attr-rx="5" ng-attr-ry="5" fill="#5da633" x="7.5" y="7.5" width="40" height="40" rx="5" ry="5">
						<animate attributeName="x" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="-0.375s" repeatCount="indefinite"></animate>
						<animate attributeName="y" calcMode="linear" values="7.5;52.5;52.5;52.5;52.5;7.5;7.5;7.5;7.5" keyTimes="0;0.083;0.25;0.333;0.5;0.583;0.75;0.833;1" dur="1.5" begin="0s" repeatCount="indefinite"></animate>
					</rect>
				</svg>
			</div>
		</div>
		
		<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
			<div class="navbar-container ace-save-state no-padding" id="navbar-container">
				<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
					<span class="sr-only">Toggle sidebar</span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>

					<span class="icon-bar"></span>
				</button>

				<div class="navbar-header pull-left no-padding">
					<small>
						<img src="{{url('assets/images/logo_gestor.png')}}" >
					</small>
				</div>

				<div class="navbar-buttons navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="dropdown-modal">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<span class="user-info">
									<small>Olá,</small>
									{{User::getUserName()}}
								</span>

								<i class="ace-icon fa fa-caret-down"></i>
							</a>

							<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
										<i class="ace-icon fa fa-sign-out"></i>
                                    	Sair
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- /.navbar-container -->
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive menu-min sidebar-fixed">

				<ul class="nav nav-list">
					<li class="li-blue">
						<a href="{{url('/debtor')}}/{{$debtor->Cd_Devedor or $debtorId}}">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text">Início</span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="li-green">
                        <a href="#modal-search" role="button" data-toggle="modal">
                            <i class="menu-icon fa fa-search"></i>
                            <span class="menu-text">Pesquisar</span>
                        </a>

						<b class="arrow"></b>
                    </li>    
					<li class="li-yellow">
                        <a href="#modal-details" role="button" data-toggle="modal">
                            <i class="menu-icon fa fa-plus"></i>
                            <span class="menu-text">Mais Informações</span>
                        </a>

						<b class="arrow"></b>
                    </li>        
					<li class="li-orange">
						<a href="#modal-address-add" role="button" data-toggle="modal">
                            <i class="menu-icon fa fa-map-marker"></i>
                            <span class="menu-text">Novo Endereço</span>
                        </a>

						<b class="arrow"></b>
                    </li>    
                    <li class="li-brown">
						<a href="#modal-telephone-add" role="button" data-toggle="modal">
                            <i class="menu-icon fa fa-phone"></i>
                            <span class="menu-text">Novo Telefone</span>
                        </a>    

						<b class="arrow"></b>
                    </li>
                    <li class="li-red">
						<a href="#modal-email-add" role="button" data-toggle="modal">
                            <i class="menu-icon fa fa-envelope"></i>
                            <span class="menu-text">Novo Email</span>
                        </a>    

						<b class="arrow"></b>
                    </li>
					<li class="li-pink">
						<a href="{{url('/history')}}/{{$debtor->Cd_Devedor or $debtorId}}">
							<i class="menu-icon fa fa-history"></i>
							<span class="menu-text">Ver Ocorrências</span>
						</a>    

						<b class="arrow"></b>
                    </li>
					<li class="li-purple">
						<a href="{{url('/agreement/show')}}/{{$debtor->Cd_Devedor or $debtorId}}">
                            <i class="menu-icon fa fa-check-square-o"></i>
                            <span class="menu-text">Ver Acordos</span>
                        </a>    

						<b class="arrow"></b>
                    </li>
    
                </ul><!-- /.nav-list -->

			</div>

			<div class="main-content">
				<div class="main-content-inner">
					<div class="page-content">
						<div class="ace-settings-container" id="ace-settings-container" style="position: fixed;">

							<div class="btn btn-app btn-xs ace-settings-btn" id="ace-settings-btn">
								<i class="ace-icon fa fa-volume-control-phone bigger-130"></i>
							</div>

							<div class="ace-settings-box clearfix" id="ace-settings-box">
								<div class="center width-100">
									<div class="ace-settings-item">
											<label id="dialer-led" class="led-offline" class="lbl"></label>
											<label class="lbl"><b>Ramal: {{User::getDialerExtension()}} | </b></label>
											<label id="dialer-status" class="lbl"><b>Offline</b></label>
										</b>
									</div>
									<div class="ace-settings-item" id="dialer-off" style="max-height: unset;">
										<a href="#" id="dialer-connect" role="button">
											<img src="{{url('assets/images/headset.png')}}"><br/>
											<span class="menu-text"><b>CONECTAR IZZY CALL</b></span>
										</a>
									</div>

									<div class="ace-settings-item" id="dialer-on" style="max-height: unset; display: none;">
										<div class="ace-settings-item" style="max-height: unset;">
											<div id="dialer-pause-type" class="dropdown dropdown-pause" style="display: none;">
												<ul class="dropdown-menu dropdown-caret dropdown-pause-type">
													<li><a class="pausepick-btn pause-close" data-pause="0">
															<i class="ace-icon fa fa-times-circle white"></i>
															Cancelar Pausa
														</a>
													</li>
													<li><a class="pausepick-btn" data-pause="1">Almoço</a></li>
													<li><a class="pausepick-btn" data-pause="2">Reunião</a></li>
													<li><a class="pausepick-btn" data-pause="3">Intervalo</a></li>
													<li><a class="pausepick-btn" data-pause="4">Deslocamento Interno</a></li>
													<li><a class="pausepick-btn" data-pause="5">Monitoria</a></li>
													<li><a class="pausepick-btn" data-pause="6">Registro</a></li>
													<li><a class="pausepick-btn" data-pause="7">Sem Sistema</a></li>
													<li><a class="pausepick-btn" data-pause="8">Ligação Manual</a></li>
													<li><a class="pausepick-btn" data-pause="9">Pausa01 10min</a></li>
													<li><a class="pausepick-btn" data-pause="10">Pausa02 20min</a></li>
													<li><a class="pausepick-btn" data-pause="11">Pausa03 10min</a></li>
													<li><a class="pausepick-btn" data-pause="12">Tratativa Email</a></li>
													<li><a class="pausepick-btn" data-pause="9999">Tabulando</a></li>
												</ul>
											</div>
											<a href="#" role="button" id="dialer-pause">
												<i class="ace-icon fa fa-pause-circle red"></i>
												<span class="menu-text" id="display-pause">Colocar em pausa</span>
											</a>
											<a href="#" role="button" id="dialer-unpause">
												<i class="ace-icon fa fa-play-circle green"></i>
												<span class="menu-text" id="display-unpause">Retornar da pausa</span>
											</a>	
										</div>

										<div class="ace-settings-item">
											<a href="#" role="button" id="dialer-hangup">
												<i class="ace-icon fa fa-stop-circle red"></i>
												<span class="menu-text">Desligar chamada</span>
											</a>
										</div>

										<div class="ace-settings-item">
											<a href="#" role="button" id="dialer-reconect">
												<i class="ace-icon fa fa-retweet orange"></i>
												<span class="menu-text">Conectar novamente</span>
											</a>
										</div>

									</div>
	
								</div><!-- /.pull-left -->

							</div><!-- /.ace-settings-box -->
						</div><!-- /.ace-settings-container -->
		
						<div class="row">
							<div class="col-xs-12">
								@yield('content')

								@include('templates.modal-search')
								@include('templates.modal-details')
								@include('templates.modal-address')
								@include('templates.modal-address-add')
								@include('templates.modal-telephone-add')
								@include('templates.modal-email-add')
								@include('templates.modal-estimate')
								@include('templates.modal-simulation')
								@include('templates.modal-select-telephone')
								@include('templates.modal-select-email')
								@include('templates.modal-about')
								@include('templates.modal-print-billet')
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

		</div><!-- /.main-container -->

		<!-- Custom menu on right click -->
		<ul class='custom-menu'>
			<div class="space-8"></div>
			<div class="col-sm-12">
				<b>Sistema Gestor de Cobrança - PA Web</b>
			</div>
			<hr class="col-sm-12 no-padding">
			<div class="col-sm-12 no-padding">
				<li data-action="about">
					<i class="ace-icon fa fa-question-circle"></i>
					Sobre...
				</li>
			</div>
		</ul>
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="{{url('assets/js/jquery-2.1.4.min.js')}}" charset="utf-8"></script>

		<!-- <![endif]-->

		<!--[if IE]>
			<script src="{{url('assets/js/jquery-1.11.3.min.js')}}" charset="utf-8"></script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='{{url('assets/js/jquery.mobile.custom.min.js')}}' charset='utf-8'>"+"<"+"/script>");
		</script>
		<script src="{{url('assets/js/bootstrap.min.js')}}" charset="utf-8"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="{{url('assets/js/excanvas.min.js')}}" charset="utf-8"></script>
		<![endif]-->
		<script src="{{url('assets/js/jquery-ui.custom.min.js')}}" charset="utf-8"></script>
		<script src="{{url('assets/js/jquery.ui.touch-punch.min.js')}}" charset="utf-8"></script>
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

		<!-- inline scripts related to this page -->
		<script type="text/javascript">		
		    var shortDateFormat = 'dd/MM/yyyy';
			var longDateFormat  = 'dd/MM/yyyy HH:mm:ss';

			$(function(){
				dialerExtension = '{{User::getDialerExtension()}}';
				dialerPassword = '{{User::getDialerPassword()}}';
				dialerUserId = '{{User::getDialerUserId()}}';

				console.log('Ramal: ' + dialerExtension);
				console.log('Senha: ' + dialerPassword);
				console.log('User_id: ' + dialerUserId);

				var update = true;
				window.setInterval(function(){ 

					if(update){
						update = false;	
						//> get extension state
						//$.post('http://172.20.10.39/gestor/getstate',{user_id: dialerUserId},function(val){
						$.post('/getExtenState',{user_id: dialerUserId},function(val){
							paused = false;

							if (val.success == true){
								$('#dialer-off').hide();
								$('#dialer-on').show();
								$('#dialer-led').attr("class","led-online");
								$('#dialer-status').html("<b>Conectado</b>");

								if (val.response.pause >= 1){
									paused = true;
								}

								if (paused){
									$('#dialer-pause').hide();
									$('#dialer-unpause').show();
									$('#ace-settings-btn').removeClass('btn-primary');
									$('#ace-settings-btn').removeClass('btn-danger');
									$('#ace-settings-btn').addClass('btn-warning');
								}else{
									$('#dialer-pause').show();
									$('#dialer-unpause').hide();
									$('#ace-settings-btn').removeClass('btn-warning');
								}
							}else{
								$('#dialer-on').hide();
								$('#dialer-off').show();
								$('#dialer-led').attr("class","led-offline");
								$('#dialer-status').html("<b>Offline</b>");
							}
						}).always(function(){
							update = true;
						});
					}
				},6000);

				var checkMonitor = true;
				window.setInterval(function(){ 
					//> check incoming call
					if (checkMonitor){
						checkMonitor = false;
						$.post("{{url('api/callMonitor')}}",{},function(val){
							if (val.success){
								if (val.receptive){
									showReceptive(val.phone)
								}else{
									newDebtor(val.debtorId, val.phone, val.debtorName);
								}
							}
						}).always(function(){
							checkMonitor = true;
						});
					}
				},10000);

				var checkCallInProgress = true;
				window.setInterval(function(){ 
					//> check incoming call
					if (checkCallInProgress){
						checkCallInProgress = false;
						$.post("{{url('api/callInProgress')}}",{},function(val){
							if (val.success){
								$('#ace-settings-btn').addClass('btn-danger');
								$('#ace-settings-btn').removeClass('btn-primary');
							}else{
								$('#ace-settings-btn').addClass('btn-primary');
								$('#ace-settings-btn').removeClass('btn-danger');
							}
						}).always(function(){
							checkCallInProgress = true;
						});
					}
				},3000);
			});
		
            jQuery(function($) {
				$('#dialer-pause').on('click', function(e){
					$('#dialer-pause-type').show();
					$('#dialer-pause').hide();
				});

				$('#dialer-unpause').on('click', function(e){
					$.post('https://172.20.10.39/gestor/unpause',{user_id: dialerUserId},function(val){
						console.log(val);

						$('#dialer-pause').show();
						$('#dialer-unpause').hide();
					});
				});

				$('.pausepick-btn').on('click', function(e){
					pause_type = $(this).attr("data-pause");

					if (pause_type == 0){
						$('#dialer-pause').show();
						$('#dialer-pause-type').hide();
					}else{
						$.post('https://172.20.10.39/gestor/pause',{user_id: dialerUserId, pause_id: pause_type},function(val){
							console.log(val);

							$('#dialer-pause-type').hide();
							$('#dialer-pause').hide();
							$('#dialer-unpause').show();
						});
					}
				});

				$('#dialer-connect, #dialer-reconect').on('click', function(e){
					$.post('https://172.20.10.39/gestor/relogin',{user_id: dialerUserId},function(val){
						//console.log(val);

						$('#dialer-off').hide();
						$('#dialer-on').show();
						$('#dialer-led').attr("class","led-online");
						$('#dialer-status').html("<b>Conectado</b>");
					});
				});

				$('#dialer-hangup').on('click', function(e){
					$.post('https://172.20.10.39/gestor/hangup',{ramal: dialerExtension},function(val){
						//console.log(val);

						$('#dialer-off').hide();
						$('#dialer-on').show();
						$('#dialer-led').attr("class","led-online");
						$('#dialer-status').html("<b>Conectado</b>");
					});
				});

                if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
                }
                
                //chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-search, #modal-telephone-add, #modal-email-add').on('shown.bs.modal', function () {
					if(!ace.vars['touch']) {
						$(this).find('.chosen-container').each(function(){
							$(this).find('a:first-child').css('width' , '210px');
							$(this).find('.chosen-drop').css('width' , '210px');
							$(this).find('.chosen-search input').css('width' , '200px');
						});
					}
                })

				$('textarea.limited').inputlimiter({
					remText: '%n caracteres%s restantes...',
					limitText: 'Máx permitido: %n.'
				});

                $(document).one('ajaxloadstart.page', function(e) {
					autosize.destroy('textarea[class*=autosize]')
					
					$('.limiterBox,.autosizejs').remove();
					$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
				});
            });

			/////////////////////////////////////
			$(document).one('ajaxloadstart.page', function(e) {
				$tooltip.remove();
			});
		
			var d1 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.5) {
				d1.push([i, Math.sin(i)]);
			}
		
			var d2 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.5) {
				d2.push([i, Math.cos(i)]);
			}
		
			var d3 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.2) {
				d3.push([i, Math.tan(i)]);
			}
			
			//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
			//so disable dragging when clicking on label
			var agent = navigator.userAgent.toLowerCase();
			if(ace.vars['touch'] && ace.vars['android']) {
				$('#tasks').on('touchstart', function(e){
				var li = $(e.target).closest('#tasks li');
				if(li.length == 0)return;
				var label = li.find('label.inline').get(0);
				if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			}
		
			$('#tasks').sortable({
				opacity:0.8,
				revert:true,
				forceHelperSize:true,
				placeholder: 'draggable-placeholder',
				forcePlaceholderSize:true,
				tolerance:'pointer',
				stop: function( event, ui ) {
					//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
					$(ui.item).css('z-index', 'auto');
				}
				}
			);
			$('#tasks').disableSelection();
			$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
				if(this.checked) $(this).closest('li').addClass('selected');
				else $(this).closest('li').removeClass('selected');
			});

			//show the dropdowns on top or bottom depending on window height and menu position
			$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
				var offset = $(this).offset();
		
				var $w = $(window)
				if (offset.top > $w.scrollTop() + $w.innerHeight() - 100) 
					$(this).addClass('dropup');
				else $(this).removeClass('dropup');
			});

			$('.cep').mask('99999-999');
		</script>

		
		<script src="{{url('assets/js/bootbox.min.js')}}"></script>
		<script>
			//toggle tooltips buttons
			$( function() {
				$(document).tooltip({
					content: function () {
              			return $(this).prop('title');
          			},
					position: {
						my: "center bottom-20",
						at: "center top",
						using: function( position, feedback ) {
							$( this ).css( position );
							$( "<div>" ).addClass( "arrow" )
										.addClass( feedback.vertical )
										.addClass( feedback.horizontal )
										.appendTo( this );
						}
					}
				});
			} );

			$('#modal-search').on('shown.bs.modal', function () {
				$( function() {
					$( '[name="radio-search"]' ).checkboxradio({
						icon: false
					});
				} );
			})
			$( function() {
				$( '[name="check-history"]' ).checkboxradio({
					icon: false
				});
			} );

			$('.modal-dialog').draggable({
			    handle: ".modal-header"
  			});
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('.modal.aside').ace_aside();
				
				$('#modal-estimate-manual').addClass('aside').ace_aside({container: '#modal-estimate > .modal-dialog'});

				$(document).one('ajaxloadstart.page', function(e) {
					//in ajax mode, remove before leaving page
					$('.modal.aside').remove();
					$(window).off('.aside')
				});
			})
		</script>

		<script type="text/javascript" src="{{url('assets/js/jquery-ui.min.js')}}"></script>
		<!-- Trigger action when the contexmenu is about to be shown -->
		<script type="text/javascript">

			/*BLOQUEIO CLIQUE COM BOTAO DIREITO*/
			/*$(document).bind("contextmenu", function (event) {
				
				// Avoid the real one
				event.preventDefault();
				
				// Show contextmenu
				$(".custom-menu").finish().toggle(250).
				
				// In the right position (the mouse)
				css({
					top: event.pageY + "px",
					left: event.pageX + "px"
				});
			});*/

			// If the document is clicked somewhere
			$(document).bind("mousedown", function (e) {
				// If the clicked element is not the menu
				if (!$(e.target).parents(".custom-menu").length > 0) {
					// Hide it
					$(".custom-menu").hide( "explode", {pieces: 4 }, 1000);
				}
			});

			// If the menu element is clicked
			$(".custom-menu li").click(function(){
				// This is the triggered action name
				switch($(this).attr("data-action")) {
					// A case for each action. Your actions here
					case "about": 
						$('#modal-about').velocity('stop').velocity({rotateZ:'0deg'}, {duration:1});
						$('#modal-about').show();
						$("#modal-about").velocity("callout.twirl");
						break;
				}

				// Hide it AFTER the action was triggered
				$(".custom-menu").hide( "explode", {pieces: 4 }, 1000);
			});

		</script>

		<script src="{{url('assets/css/velocity.min.js')}}"></script>
		<script src="{{url('assets/css/velocity.ui.min.js')}}"></script>
		<script>
			/* jquery.js */
			/* jquery.velocity.js */

			// Register a custom UI pack effect.
			$.Velocity.RegisterUI("callout.twirl", {
				defaultDuration: 3000,
				calls: [
					[{ rotateZ: 1080 }, 0.50],
					[{ scaleX: 0.5 }, 0.25, { easing: "spring" }],
					[{ scaleX: 1 }, 0.25, { easing: "spring" }]
				],
				reset: { rotateZ: 0 }
			});
		</script>
	
		<script>
            function showMessage(message){
                bootbox.alert(message);
            }

            function showLoader(message){
                $(".jqgrid-loading-wrapper").show();
                $(".jqgrid-loading-wrapper #message").html(message);
            }

            function hideLoader(){
                $(".jqgrid-loading-wrapper #message").html('Aguarde...');
                $(".jqgrid-loading-wrapper").hide();
			}
			
			function showConfirm(title, message){
				var unique_id = $.gritter.add({
						title: title,
						text: message,
						image: '{{url('assets/images/confirm.png')}}',
						sticky: true,
						time: '',
						class_name: 'gritter-info'
					});
			
					return false;

		
				return false;
			}
			
			function showReceptive(phone){
				var unique_id = $.gritter.add({
						title: 'LIGAÇÃO RECEPTIVA',
						text: 'Telefone: ' + phone,
						image: '{{url('assets/images/headset.png')}}',
						sticky: true,
						time: '',
						class_name: 'gritter-light'
					});
			
					return false;

		
				return false;
			}

			function showError(title, message){
				var unique_id = $.gritter.add({
						title: title,
						text: message,
						image: '{{url('assets/images/error.png')}}',
						sticky: true,
						time: '',
						class_name: 'gritter-error'
					});
			
					return false;

		
				return false;
			}
        </script>

	<script src="{{url('assets/js/bootstrap-table.min.js')}}"></script>
	<script src="{{url('assets/js/bootstrap-table-pt-BR.min.js')}}"></script>
	<script src="{{url('assets/js/moment.min.js')}}"></script>
	<link rel="stylesheet" href="{{url('assets/css/bootstrap-table.css')}}">

	<script type="text/javascript">
		jQuery(function($) {
			$('#modal-address').on('shown.bs.modal', function () {
				$('#address-table').bootstrapTable('resetView');
			})
			$('#modal-address-add').on('shown.bs.modal', function () {
				$('#address-cdStatus').trigger("resize.chosen");
			})
			$('#modal-details').on('shown.bs.modal', function (e) {
				e.preventDefault();
				loadDetails();
			})
			$('#modal-select-telephone').on('shown.bs.modal', function (e) {
				getTelephones();
			})
			$('#modal-select-email').on('shown.bs.modal', function (e) {
				getEmails();
			})

		})

		function tableDateFormat(value, row, index) {
			if (value == null){
				return "";
			}else{
				return moment(value).format('DD/MM/YYYY');
			}
		}

		function tableFloatFormat(value, row, index) {
			if (value == null){
				return "";
			}else{
				return parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL'});
			}
		}
		
        function tableAgreementsInstallmentFormat(value, row, index) {
            return "@include('templates.block-send-billet')";
		}

		function tableSendTelephoneFormat(value, row, index) {
            return "@include('templates.block-telephone-message')";
		}

		function tableSendEmailFormat(value, row, index) {
            return "@include('templates.block-email-send')";
		}
	</script>

	<!--
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
	-->
	@stack('functions')

	<script>
		@if(session()->has('alert'))
			showConfirm('Confirmação', '{{ session()->get('alert') }}')
		@endif

		@if ( isset($errors) && count($errors) > 0 ) 
			@foreach ($errors->all() as $error)
				showError('Ocorreu o seguinte erro:', '{{$error}}')
			@endforeach
		@endif
	</script>

	</body>
</html>
