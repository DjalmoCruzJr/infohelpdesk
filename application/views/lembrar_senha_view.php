<!doctype html>
<html class="fixed">
	<head>
		<meta charset="UTF-8">
		
		<title>Esqueci minha senha - Help Desk | Info Rio Sistema LTDA</title>
		<meta name="description" content="Info Rio Sistemas LTDA">
		<meta name="author" content="Luiz Mário">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href=<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css') ?> />

		<link rel="stylesheet" href=<?php echo base_url('assets/vendor/font-awesome/css/font-awesome.css') ?> />
		<link rel="stylesheet" href=<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.css') ?> />
		<link rel="stylesheet" href=<?php echo base_url('assets/vendor/bootstrap-datepicker/css/datepicker3.css') ?> />

		<link rel="stylesheet" href=<?php echo base_url('assets/stylesheets/theme.css') ?> />

		<link rel="stylesheet" href=<?php echo base_url('assets/stylesheets/skins/default.css') ?> />

		<link rel="stylesheet" href=<?php echo base_url('assets/stylesheets/theme-custom.css') ?>>

		<script src=<?php echo base_url('assets/vendor/modernizr/modernizr.js') ?>></script>
		
	</head>
	<body class="bodyLogin">
		<!-- start: page -->
		<section class="body-sign">
			<div class="center-sign">
				{MENSAGEM_LEMBRARSENHA_ERRO}
				<a href="/" class="logo pull-left">
					<img src=<?php echo base_url('assets/images/logo.png') ?> height="54" alt="Info Rio Sistema LTDA" />
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Lembrar Senha</h2>
					</div>
					<div class="panel-body">
						<div class="alert alert-info">
							<p class="m-none text-weight-semibold h6">Insira o seu e-mail abaixo e nós iremos enviar-lhe uma nova senha!</p>
						</div>

						<form action="{ACAO_FORM}" method="post">
							<div class="form-group mb-none">
								<div class="input-group {ERRO_HEL_EMAIL_CON}">
									<input name="hel_email_con" id="hel_email_con" value="{hel_email_con}" placeholder="e-mail" class="form-control input-lg" />
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary btn-block btn-lg">Enviar</button>
									</span>
								</div>
							</div>

							<p class="text-center text-muted mt-md mb-md labellogin">Lembrou? <a href="{LOGIN_FORM}">Clique aqui!</a>
						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md labellogin">&copy; Copyright © 2015 | Desenvolvido pela Info Rio Sistemas Ltda. Todos os direitos reservados.</p>
			</div>
		</section>
		
		<script src=<?php echo base_url('assets/vendor/jquery/jquery.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/nanoscroller/nanoscroller.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/magnific-popup/magnific-popup.js') ?>></script>
		<script src=<?php echo base_url('assets/vendor/jquery-placeholder/jquery.placeholder.js') ?>></script>
		
		<script src=<?php echo base_url('assets/javascripts/theme.js') ?>></script>
	
		<script src=<?php echo base_url('assets/javascripts/theme.custom.js') ?>></script>
		
		<script src=<?php echo base_url('assets/javascripts/theme.init.js') ?>></script>
	</body>
</html>