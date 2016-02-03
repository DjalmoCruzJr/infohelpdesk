<header class="page-header">
	<h2>Serviço - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_ser" name="hel_pk_seq_ser" value="{hel_pk_seq_ser}" />
			<div class="form-group">
				<div class="{ERRO_HEL_DESC_SER}">
					<label for="hel_desc_ser" class="col-sm-1 control-label">Descrição</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_desc_ser" name="hel_desc_ser" 
						       value="{hel_desc_ser}" maxlength="30"autocomplete="off" autofocus />
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-10">
					<div class="checkbox-inline">
						<label >
							<input type="checkbox"  id="hel_sistema_ser"name="hel_sistema_ser" value="1"
								   {hel_checkecsistema_ser} autocomplete="off" autofocus/>Sistema
						</label>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_servico" class="btn btn-primary"><i class="glyphicon glyphicon-ok"> </i> Salvar </button>
					<a type="button" href="{CONSULTA_SERVICO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>

		</form>
	</div>
</div>


