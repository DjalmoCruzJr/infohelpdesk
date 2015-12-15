<header class="page-header">
	<h2>Sistema - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_sis" name="hel_pk_seq_sis" value="{hel_pk_seq_sis}"/>
			
			<div class="form-group">
				<div class="{ERRO_HEL_CODIGO_SIS}">
					<label for="hel_codigo_sis" class="col-sm-1 control-label">Código</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="hel_codigo_sis"
							   name="hel_codigo_sis" value="{hel_codigo_sis}" maxlength="3" autocomplete="off" autofocus/>
					</div>
				</div>

				<div class="{ERRO_HEL_DESC_SIS}">
					<label for="hel_desc_sis" class="col-sm-1 control-label">Descrição</label>
						<div class="col-sm-7">
							<input type="text" class="form-control" id="hel_desc_sis"
								   name="hel_desc_sis" value="{hel_desc_sis}" maxlength="45" autocomplete="off" autofocus/>
						</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="{ERRO_HEL_TIPO_SIS}">
					<label for="hel_tipo_sis" class="col-sm-1 control-label">Tipo</label>
					<div class="col-sm-7">
						<div class="col-sm-11">
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_sis" {hel_checkDesktop_sis}
										   name="hel_tipo_sis" value="0" />Desktop
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_sis" {hel_checkweb_sis}
										   name="hel_tipo_sis" value="1"/>Web
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_sis" {hel_checkMobile_sis}
										   name="hel_tipo_sis" value="2"/>Mobile
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_sistema" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_SISTEMA}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		


