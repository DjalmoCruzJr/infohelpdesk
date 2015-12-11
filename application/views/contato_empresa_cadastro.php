<header class="page-header">
	<h2>Contato Empresa - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_exc" name="hel_pk_seq_exc" value="{hel_pk_seq_exc}"/>				
			<input type="hidden" id="hel_seqcon_exc" name="hel_seqcon_exc" value="{hel_seqcon_exc}"/>	
			<div class="form-group">
				<div class="{ERRO_HEL_SEQEMP_EXC}">
					<label for="hel_seqemp_exc" class="col-sm-1 control-label">Empresa</label>
					<div class="col-sm-10">
							<select class="form-control chosen-select" id="hel_seqemp_exc" name="hel_seqemp_exc" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_EMPRESA}
								    	<option value="{hel_pk_seq_emp}" {sel_hel_seqemp_exc} >{hel_nomefantasia_emp}</option>
								    {/BLC_EMPRESA}
							</select>   
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_EMPRESA_CONTATO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		