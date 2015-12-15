<header class="page-header">
	<h2>Tipo Contato - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_tco" name="hel_pk_seq_tco" value="{hel_pk_seq_tco}"/>
			<div class="form-group">
				<div class="{ERRO_HEL_DESC_TCO}">
					<label for="hel_desc_tco" class="col-sm-1 control-label">Descricão</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_desc_tco"
							   name="hel_desc_tco" value="{hel_desc_tco}" maxlength="60" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_TIPO_TCO}">
					<label for="hel_tipo_tco" class="col-sm-1 control-label">Tipo de Contato</label>
					<div class="col-sm-7">
						<div class="col-sm-11">
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_tco" {hel_checktecnico_tco}
										   name="hel_tipo_tco" value="0" />Técnico
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_tco" {hel_checkresponsavel_tco}
										   name="hel_tipo_tco" value="1"/>Responsável
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" id="hel_tipo_tco" {hel_checkoutro_tco}
										   name="hel_tipo_tco" value="2"/>Outros
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_tipo_contato" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_TIPO_CONTATO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		


