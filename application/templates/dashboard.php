<!doctype html>
<html lang="pt-BR">
<html class="fixed">
	<head>
		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Help Desk | Info Rio Sistema LTDA</title>
		<meta name="keywords" content="Admin Help Desk | Info Rio Sistema LTDA" />
		<meta name="description" content="Help Desk - Info Rio Sistema LTDA">
		<meta name="author" content="okler.net">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/stylesheets/dataTables.bootstrap.css') ?>" rel="stylesheet">		
		
		<link href="<?php echo base_url('assets/stylesheets/theme.css') ?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/stylesheets/skins/default.css') ?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/stylesheets/theme-custom.css') ?>" rel="stylesheet">
		<script src="<?php echo base_url('assets/vendor/modernizr/modernizr.js') ?>"></script>
		
		<link href="<?php echo base_url('assets/vendor/select2/select2.css') ?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/vendor/bootstrap-chosen/bootstrap-chosen.css') ?>" rel="stylesheet">
		
		<link href="<?php echo base_url('assets/stylesheets/jquery-upload/jquery.fileupload.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/stylesheets/jquery-upload/jquery.fileupload-ui.css') ?>" rel="stylesheet">
		
		<noscript>
			<link href="<?php echo base_url('assets/stylesheets/jquery-upload/jquery.fileupload-noscript.css') ?>" rel="stylesheet">
		</noscript>
		<noscript>
			<link href="<?php echo base_url('assets/stylesheets/jquery-upload/jquery.fileupload-ui-noscript.css') ?>" rel="stylesheet">
		</noscript>
	</head>
	<body>
		<section class="body">
			<header class="header">
				<div class="logo-container">
					<a href="<?php echo site_url('inicio')?>" class="logo">
						<img src="<?php echo base_url('assets/images/logo.png') ?>" height="35" alt="Porto Admin" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
<!-- 					<ul class="notifications"> -->
<!-- 						<li>	 -->
<!-- 							<a href="{ANIVERSARIANTES}" class=" btn btn-primary" title="Aniversariantes" > -->
<!-- 								<i class="fa fa-birthday-cake fa-lg"></i> -->
<!-- 								<span  class="badge"></span> -->
<!-- 							</a>						 -->
<!-- 						</li> -->
<!-- 					</ul> -->
			
					<span class="separator"></span>
			
					<ul class="notifications">
						
<!-- 						<li> -->
<!-- 							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown"> -->
<!-- 								<i class="fa fa-tasks"></i> -->
<!-- 								<span class="badge">3</span> -->
<!-- 							</a> -->
			
<!-- 							<div class="dropdown-menu notification-menu large"> -->
<!-- 								<div class="notification-title"> -->
<!-- 									<span class="pull-right label label-default">3</span> -->
<!-- 									Tasks -->
<!-- 								</div> -->
			
<!-- 								<div class="content"> -->
<!-- 									<ul> -->
<!-- 										<li> -->
<!-- 											<p class="clearfix mb-xs"> -->
<!-- 												<span class="message pull-left">Generating Sales Report</span> -->
<!-- 												<span class="message pull-right text-dark">60%</span> -->
<!-- 											</p> -->
<!-- 											<div class="progress progress-xs light"> -->
												<div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
<!-- 											</div> -->
<!-- 										</li> -->
			
<!-- 										<li> -->
<!-- 											<p class="clearfix mb-xs"> -->
<!-- 												<span class="message pull-left">Importing Contacts</span> -->
<!-- 												<span class="message pull-right text-dark">98%</span> -->
<!-- 											</p> -->
<!-- 											<div class="progress progress-xs light"> -->
												<div class="progress-bar" role="progressbar" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100" style="width: 98%;"></div>
<!-- 											</div> -->
<!-- 										</li> -->
			
<!-- 										<li> -->
<!-- 											<p class="clearfix mb-xs"> -->
<!-- 												<span class="message pull-left">Uploading something big</span> -->
<!-- 												<span class="message pull-right text-dark">33%</span> -->
<!-- 											</p> -->
<!-- 											<div class="progress progress-xs light mb-xs"> -->
												<div class="progress-bar" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%;"></div>
<!-- 											</div> -->
<!-- 										</li> -->
<!-- 									</ul> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 						</li> -->
<!-- 						<li> -->
<!-- 							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown"> -->
<!-- 								<i class="fa fa-envelope"></i> -->
<!-- 								<span class="badge">4</span> -->
<!-- 							</a> -->
			
<!-- 							<div class="dropdown-menu notification-menu"> -->
<!-- 								<div class="notification-title"> -->
<!-- 									<span class="pull-right label label-default">230</span> -->
<!-- 									Messages -->
<!-- 								</div> -->
			
<!-- 								<div class="content"> -->
<!-- 									<ul> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<figure class="image"> -->
<!-- 													<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior" class="img-circle" /> -->
<!-- 												</figure> -->
<!-- 												<span class="title">Joseph Doe</span> -->
<!-- 												<span class="message">Lorem ipsum dolor sit.</span> -->
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<figure class="image"> -->
<!-- 													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" /> -->
<!-- 												</figure> -->
<!-- 												<span class="title">Joseph Junior</span> -->
												
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<figure class="image"> -->
<!-- 													<img src="assets/images/!sample-user.jpg" alt="Joe Junior" class="img-circle" /> -->
<!-- 												</figure> -->
<!-- 												<span class="title">Joe Junior</span> -->
<!-- 												<span class="message">Lorem ipsum dolor sit.</span> -->
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<figure class="image"> -->
<!-- 													<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle" /> -->
<!-- 												</figure> -->
<!-- 												<span class="title">Joseph Junior</span> -->
												
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 									</ul> -->
			
<!-- 									<hr /> -->
			
<!-- 									<div class="text-right"> -->
<!-- 										<a href="#" class="view-more">View All</a> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 						</li> -->
<!-- 						<li> -->
<!-- 							<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown"> -->
<!-- 								<i class="fa fa-bell"></i> -->
<!-- 								<span class="badge">3</span> -->
<!-- 							</a> -->
			
<!-- 							<div class="dropdown-menu notification-menu"> -->
<!-- 								<div class="notification-title"> -->
<!-- 									<span class="pull-right label label-default">3</span> -->
<!-- 									Alerts -->
<!-- 								</div> -->
			
<!-- 								<div class="content"> -->
<!-- 									<ul> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<div class="image"> -->
<!-- 													<i class="fa fa-thumbs-down bg-danger"></i> -->
<!-- 												</div> -->
<!-- 												<span class="title">Server is Down!</span> -->
<!-- 												<span class="message">Just now</span> -->
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<div class="image"> -->
<!-- 													<i class="fa fa-lock bg-warning"></i> -->
<!-- 												</div> -->
<!-- 												<span class="title">User Locked</span> -->
<!-- 												<span class="message">15 minutes ago</span> -->
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 										<li> -->
<!-- 											<a href="#" class="clearfix"> -->
<!-- 												<div class="image"> -->
<!-- 													<i class="fa fa-signal bg-success"></i> -->
<!-- 												</div> -->
<!-- 												<span class="title">Connection Restaured</span> -->
<!-- 												<span class="message">10/10/2014</span> -->
<!-- 											</a> -->
<!-- 										</li> -->
<!-- 									</ul> -->
			
<!-- 									<hr /> -->
			
<!-- 									<div class="text-right"> -->
<!-- 										<a href="#" class="view-more">View All</a> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 						</li> -->
					</ul>
			
<!-- 					<span class="separator"></span> -->
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<i class="fa fa-user fa-2x"></i>
							</figure>
							<div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
								<span class="name">{hel_login_con}</span>
								<span class="role">{hel_desc_tco}</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1"  href="<?php echo site_url('meuPerfil')?>"><i class="fa fa-user"></i> Meu Perfil</a>
								</li>								
								<li>
									<a role="menuitem" tabindex="-1" href="<?php echo site_url('login')?>"><i class="fa fa-power-off"></i> Sair</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="<?php echo site_url('inicio')?>">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Início</span>
										</a>
									</li>								
									<li class="nav-parent">
										<a>
											<i class="fa fa-file-o" aria-hidden="true"></i>
											<span>Cadastros</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="<?php echo site_url('cidade')?>">
													 Cidades
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('empresa')?>">
													 Empresa
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('tipo_contato');?>">
													Tipo contato
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('contato');?>">
													Contato
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('servico');?>">
													Serviço
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('sistema');?>">
													Sistema
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('menu');?>">
													Menu
												</a>
											</li>
										</ul>
									</li>
									<li class="nav-parent">
										<a>
											<i class="fa fa-tasks" aria-hidden="true"></i>
											<span>Movimentos</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="<?php echo site_url('chamado');?>">
													Chamado 
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('ordem_servico');?>">
													Ordem de Serviço 
												</a>
											</li>
										</ul>
									</li>
									
									<li class="nav-parent">
										<a>
											<i class="fa fa-list-alt" aria-hidden="true"></i>
											<span>Relatórios</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="<?php echo site_url('relatorio_contato_empresa');?>">
													Contatos da Empresa
												</a>
											</li>
											<li>
												<a href="<?php echo site_url('relatorio_menu_contratado');?>">
													Menu Contratado
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</ul>
						</nav>	
					</div>
				</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<div class="row">
						<div class="col-md-12 col-lg-12 col-xl-12">							
										{MENSAGEM_SISTEMA_ERRO}
										{MENSAGEM_SISTEMA_SUCESSO}
										{CONTEUDO}   							
						</div>
					</div>
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="2014-04-19T00:00+00:00">04/19/2014</time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
			
							<div class="sidebar-widget widget-friends">
								<h6>Friends</h6>
								<ul>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-online">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
									<li class="status-offline">
										<figure class="profile-picture">
											<img src="assets/images/!sample-user.jpg" alt="Joseph Doe" class="img-circle">
										</figure>
										<div class="profile-info">
											<span class="name">Joseph Doe Junior</span>
											<span class="title">Hey, how are you?</span>
										</div>
									</li>
								</ul>
							</div>
			
						</div>
					</div>
				</div>
			</aside>
		</section>
		
		<input type="hidden" id="siteURL" value="<?php echo site_url();?>">
		
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.ui.widget.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/tmpl.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/load-image.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/canvas-to-blob.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/bootstrap.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.blueimp-gallery.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.iframe-transport.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.fileupload.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.fileupload-image.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-validate.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-ui.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-process.js') ?>"></script>
		
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.fileupload-angular.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-audio.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-jquery-ui.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.fileupload-video.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/jquery.jquery.iframe-transport.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery-upload/tmpl.min.js') ?>"></script>
		
		<script src="<?php echo base_url('assets/vendor/jquery/jquery.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/nanoscroller/nanoscroller.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/jquery-placeholder/jquery.placeholder.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/dataTables/jquery.dataTables.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/dataTables/dataTables.bootstrap.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/theme.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/theme.custom.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/theme.init.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/jquery.maskedinput.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/javascripts/mask.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/select2/select2.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/select2/select2_locale_pt-BR.js') ?>"></script>
		<script src="<?php echo base_url('assets/vendor/bootstrap-chosen/chosen.jquery.js') ?>"></script>
		
		<script>
		    $(".js-example-basic-multiple").select2();

		    $('.chosen-select').chosen();
			$('.chosen-select-deselect').chosen({ allow_single_deselect: true });

// 		    $.extend($.fn.select2.defaults, $.fn.select2.locales['pt-BR']);

// 		    $(".js-example-language").select2({
// 		    	  language: "pt-BR"
// 		    	});
		    
	    
		    $(document).ready(function() {
		        $('#tb_cidade').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_tipo_contato').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_contato').dataTable({"order": [[ 1, "asc" ]]});
		        $('#tb_empresa').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_menu').dataTable({"order": [[ 1, "asc" ]]});
		        $('#tb_servico').dataTable({"order": [[ 1, "asc" ]]});
		        $('#tb_contato_empresa').dataTable({"order": [[ 1, "asc" ]]});
		        $('#tb_empresa_contato').dataTable({"order": [[ 1, "asc" ]]});
		        $('#tb_sistema').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_sistema_contratado').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_menu_sistema_contratado').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_ordem_servico').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_item_ordem_servico').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_chamado').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_assunto').dataTable({"order": [[ 1, "asc" ]]});
				$('#tb_item_chamado').dataTable({"order": [[ 1, "asc" ]]});
				
			});
		</script>


</html>