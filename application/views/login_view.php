<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link href="assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="assets/vendor/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="assets/stylesheets/dataTables.bootstrap.css" rel="stylesheet">
		
		<link href="assets/stylesheets/theme.css" rel="stylesheet">
		<link href="assets/stylesheets/theme-custom.css" rel="stylesheet">
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body class="bodyLogin">
	  		
		<!-- start: page -->
		<section class="body-sign">			
			<div class="center-sign">
				{MENSAGEM_LOGIN_ERRO}
				<a href="/" class="logo pull-left">
					<img src="assets/images/logo.png" height="54" alt="Porto Admin" />
				</a>					
				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Autenticação</h2>
					</div>
					<div class="panel-body">
						<form action="{ACAO_FORM}" method="post">
							<div class="form-group mb-lg {ERRO_GAB_LOGIN_USU}">
								<label class="labellogin"><strong>Usuário</strong></label>
								<div class="input-group input-group-icon">
									<input name="gab_login_usu" type="text" id="ibl_login_usu" class="form-control input-lg" value="{gab_login_usu}" maxlength="60" />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg {ERRO_GAB_SENHA_USU}">
								<div class="clearfix">
									<label class="pull-left labellogin"><strong>Senha</strong></label>									
								</div>
								<div class="input-group input-group-icon">
									<input type="password" name="gab_senha_usu" maxlength="32" class="form-control input-lg" value=""/>
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								
								<div class="col-sm-12 text-right">
									<button type="submit" class="btn btn-primary btn-block btn-lg">Entrar</button>									
								</div>
							</div>
						</form>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md labellogin">&copy; Copyright © 2015 | Desenvolvido pela Info Rio Sistemas Ltda. Todos os direitos reservados.</p>
			</div>
		</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		<script src="assets/javascripts/dataTables/jquery.dataTables.js"></script>
		<script src="assets/javascripts/dataTables/dataTables.bootstrap.js"></script>
		<script src="assets/javascripts/theme.js"></script>
		<script src="assets/javascripts/theme.custom.js"></script>
		<script src="assets/javascripts/theme.init.js"></script>

	</body>
</html>