<header class="page-header">
	<h2>Replicar</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<div class="form-group">
				<div class="{ERRO_HEL_SEQSEG_EMP}">
					<label for="hel_seqseg_emp" class="col-sm-1 control-label">Segmento</label>
						<div class="col-sm-11">
							<select class="form-control" id="hel_seqseg_emp" name="hel_seqseg_emp" autofocus="autofocus">
								<option value="">Selecione...</option>
								{BLC_SEGMENTO}
									<option value="{hel_pk_seq_seg}" {sel_hel_seqseg_emp} >{hel_desc_seg}</option>
								{/BLC_SEGMENTO}
							</select>   
						</div>
				</div>
			</div>
		
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_EMPRESA}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		
