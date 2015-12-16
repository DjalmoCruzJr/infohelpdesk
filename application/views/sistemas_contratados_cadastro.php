<header class="page-header">
	<h2>Sistemas Contratados - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_sco" name="hel_pk_seq_sco" value="{hel_pk_seq_sco}"/>
			<input type="hidden" id="hel_seqemp_sco" name="hel_seqemp_sco" value="{hel_seqemp_sco}"/>

			<div class="form-group">
				<div class="{ERRO_HEL_SEQSIS_SCO}">
					<label for="hel_seqemp_exc" class="col-sm-1 control-label">Sistemas Contratados</label>
					<div class="col-sm-8">
						<select class="form-control chosen-select-deselect" id="hel_seqemp_sis" name="hel_seqsis_sco" autofocus="autofocus">
							<option value="">Selecione...</option>
							{BLC_SISTEMA}
								<option value="{hel_pk_seq_sis}" {sel_hel_seqsis_sco} >{hel_desc_sis} <small>({hel_tipo_sis})<small></option>
							{/BLC_SISTEMA}
						</select>
				    </div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1	 col-sm-11">
					<button type="submit" name="salvar_sistema_cadastrado" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_SISTEMAS_CONTRATADOS}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		