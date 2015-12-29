<header class="page-header">
	<h2>Item Ordem Serviço - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_ios" name="hel_pk_seq_ios" value="{hel_pk_seq_ios}"/>
			<input type="hidden" id="hel_seqose_ios" name="hel_seqose_ios" value="{hel_seqose_ios}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_SEQSER_IOS}">
					<label for="hel_seqser_ios" class="col-sm-1 control-label">Serviço</label>
					<div class="col-sm-5">
							<select class="form-control" id="hel_seqemp_ose" name="hel_seqser_ios" autofocus="autofocus" >
								<option value="">Selecione...</option>
									{BLC_SERVICO}
								    	<option value="{hel_pk_seq_ser}" {sel_hel_seqser_ios}>{hel_desc_ser}</option>
								    {/BLC_SERVICO}
							</select>   
					</div>
				</div>
				<label for="hel_seqsis_ios" class="col-sm-1 control-label">Sistema</label>
				<div class="col-sm-5">
						<select class="form-control" id="hel_seqsis_ios" name="hel_seqsis_ios" autofocus="autofocus" >
							<option value="">Selecione...</option>
								{BLC_SISTEMA}
							    	<option value="{hel_pk_seq_sis}" {sel_hel_seqsis_ios}>{hel_desc_sis}<small> ({hel_tipo_sis}) </small></option>
							    {/BLC_SISTEMA}
						</select>   
				</div>
			</div>
			<div class="form-group">
				<label for="hel_seqcha_ios" class="col-sm-1 control-label">Chamado</label>
					<div class="col-sm-7">
						<select class="form-control chosen-select" id="hel_seqcha_ios" name="hel_seqcha_ios" autofocus="autofocus">
							<option value="">Selecione...</option>
							{BLC_CHAMADO}
								<option value="{hel_pk_seq_cha}" {sel_hel_seqcha_ios}>{hel_desc_cha}</option>
							{/BLC_CHAMADO}
						</select>   
					</div>
			</div>
			<div class="form-group">
				<label for="hel_observacao_ose" class="col-sm-1 control-label">Complemento</label>
					<div class="col-sm-11">
						<textarea class="form-control" id="hel_complemento_ios" name="hel_complemento_ios" 
						      maxlength="499" autocomplete="off" autofocus>{hel_complemento_ios}</textarea>
					</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_ITEM_ORDEM_SERVICO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		