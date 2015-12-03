<header class="page-header">
	<h2>Usuário - {ACAO} </h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="gab_pk_seq_usu" name="gab_pk_seq_usu" value="{gab_pk_seq_usu}"/>
			<div class="form-group">	
				<div class="{ERRO_GAB_LOGIN_USU}">
					<label for="gab_login_usu" class="col-sm-1 control-label">Login</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="gab_login_usu"  
								   name="gab_login_usu" value="{gab_login_usu}" maxlength="60" autocomplete="off" {gab_readonly_usu}="readonly" />
						</div>
				</div>
			</div>  
			<div class="form-group">
				<div class="{ERRO_GAB_SENHAATUAL_USU}">
						<label for="gab_senha_usu" class="col-sm-1 control-label">Senha Atual</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="gab_senha_usu"  
									   name="gab_senha_usu" autocomplete="off" autofocus/>
							</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_GAB_NOVASENHA_USU}">
						<label for="gab_novaSenha_usu" class="col-sm-1 control-label">Nova Senha</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="gab_novaSenha_usu"  
									   name="gab_novaSenha_usu" autocomplete="off" autofocus/>
							</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_GAB_CONFIRMARNOVASENHA_USU}">
						<label for="gab_confirmarNovaSenha_usu" class="col-sm-1 control-label">Confirmar nova senha</label>
							<div class="col-sm-7">
								<input type="password" class="form-control" id="gab_confirmarNovaSenha_usu"  
									   name="gab_confirmarNovaSenha_usu" autocomplete="off" autofocus/>
							</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_AlterarSenha" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_USUARIO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
	</div>
</div>		


