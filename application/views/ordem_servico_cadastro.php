<header class="page-header">
	<h2>Ordem Serviço - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_ose" name="hel_pk_seq_ose" value="{hel_pk_seq_ose}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_SEQEMP_OSE}">
					<label for="hel_seqemp_ose" class="col-sm-1 control-label">Empresa</label>
					<div class="col-sm-10">
							<select class="form-control chosen-select-deselect" id="hel_seqemp_ose" name="hel_seqemp_ose" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_EMPRESA}
								    	<option value="{hel_pk_seq_emp}" {sel_hel_seqemp_ose}>{hel_nomefantasia_emp}</option>
								    {/BLC_EMPRESA}
							</select>   
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_SEQCON_OSE}">
						<label for="hel_seqcon_ose" class="col-sm-1 control-label">Contato</label>
						<div class="col-sm-7">
								<select class="form-control" id="hel_seqcon_ose" name="hel_seqcon_ose" autofocus="autofocus">
									<option value="">Selecione...</option>
								</select>   
						</div>
					</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_EMPRESA_EMP}">
					<label for="hel_horarioinicial_ose" class="col-sm-1 control-label">Horário Inicial</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="hel_horarioinicial_ose" name="hel_horarioinicial_ose" 
						       value="{hel_horarioinicial_ose}" autocomplete="off" autofocus/>
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