<header class="page-header">
	<h2>Meu Perfil - Alterar Senha </h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_con" name="hel_pk_seq_con" value="{hel_pk_seq_con}"/>			
			<div class="form-group">
				<label for="hel_login_con" class="col-sm-1 control-label">Login</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="hel_login_con" name="hel_login_con" {hel_dis_login_con} 
						        value="{hel_login_con}" maxlength="30" autocomplete="off" autofocus/>
					</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_SENHAATUAL_ALT}">
					<label for="hel_senhaatual_con" class="col-sm-1 control-label">Senha Atual</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="hel_senhaatual_con" name="hel_senhaatual_con"
						       value="" maxlength="40" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">	
				<div class="{ERRO_HEL_SENHA_ALT}">
					<label for="hel_novasenha_con" class="col-sm-1 control-label">Nova Senha</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="hel_novasenha_con" name="hel_novasenha_con"
						       value="" maxlength="40" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_CONFIRSENHA_ALT}">
					<label for="hel_confirmarsenha_con" class="col-sm-1 control-label">Confirmar Senha</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="hel_confirmarsenha_con" name="hel_confirmarsenha_con"
						       value="" maxlength="40" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
						
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		