<header class="page-header">
	<h2>Contato - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_con" name="hel_pk_seq_con" value="{hel_pk_seq_con}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_NOME_CON}">
					<label for="hel_nome_con" class="col-sm-1 control-label">Nome</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="hel_nome_con" name="hel_nome_con" 
						       value="{hel_nome_con}" maxlength="60" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_SEQTCO_CON}">
					<label for="hel_seqtco_con" class="col-sm-1 control-label">Tipo Contato</label>
					<div class="col-sm-4">
							<select class="form-control" id="hel_seqtco_con" name="hel_seqtco_con" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_TIPO_CONTATO}
								    	<option value="{hel_pk_seq_tco}" {sel_hel_seqtco_con}>{hel_desc_tco}</option>
								    {/BLC_TIPO_CONTATO}
							</select>   
					</div>
				</div>
				<div class="{ERRO_HEL_EMAIL_CON}">
					<label for="hel_email_con" class="col-sm-1 control-label">E-mail</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="hel_email_con" name="hel_email_con"
							   value="{hel_email_con}" maxlength="60" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_LOGIN_CON}">
					<label for="hel_login_con" class="col-sm-1 control-label">Login</label>
					<div class="col-sm-5">
						<input type="text" class="form-control" id="hel_login_con" name="hel_login_con" 
						       value="{hel_login_con}" maxlength="30" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_SENHA_CON}">
					<label for="hel_senha_con" class="col-sm-1 control-label">Senha</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="hel_senha_con" name="hel_senha_con" {hel_dis_senha_con}
						       value="{hel_senha_con}" maxlength="40" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_CONFIRSENHA_CON}">
					<label for="hel_confirsenha_con" class="col-sm-1 control-label">Confirmar Senha</label>
					<div class="col-sm-5">
						<input type="password" class="form-control" id="hel_confirsenha_con" name="hel_confirsenha_con" {hel_dis_confirsenha_con}
						       value="{hel_confirsenha_con}" maxlength="40" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>			
			<div class="form-group">
				<div class="{ERRO_HEL_ATIVO_EMP}">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="checkbox">
							<label >
								<input type="checkbox"  id="hel_ativo_con"name="hel_ativo_con" value="1" 
								{hel_checkedativo_con} autocomplete="off" autofocus/>Ativo
							</label>										
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_CONTATO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		