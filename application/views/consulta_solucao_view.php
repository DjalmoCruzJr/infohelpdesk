<header class="page-header">
	<h2>Consulta Solução</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label for="hel_seqemp_ios" class="col-sm-1 control-label">Serviço</label>
				<div class="col-sm-5" >
					<select class="form-control" id="hel_seqser_ios" name="hel_seqser_ios" autofocus="autofocus" disabled>
						<option value="">Selecione...</option>
							{BLC_SERVICO}
								<option value="{hel_pk_seq_ser}" {sel_hel_seqser_ios}>{hel_desc_ser}</option>
							{/BLC_SERVICO}
					</select>   
				</div>
			<label for="hel_seqsis_ios" class="col-sm-1 control-label">Sistema</label>
				<div class="col-sm-5">
					<select class="form-control" id="hel_seqsis_ios" name="hel_seqsis_ios" autofocus="autofocus" disabled>
						<option value="">Selecione...</option>
						{BLC_SISTEMA}
							<option value="{hel_pk_seq_sis}" {sel_hel_seqsis_ios}>{hel_desc_sis}<small> ({hel_tipo_sis}) </small></option>
						{/BLC_SISTEMA}
					</select>
				</div>
		</div>
		<div class="form-group">
			<label for="hel_complemento_ios" class="col-sm-1 control-label">Complemento</label>
				<div class="col-sm-11">
					<textarea class="form-control" id="hel_complemento_ios" name="hel_complemento_ios" readonly  
					          autocomplete="off" autofocus>{hel_complemento_ios}</textarea>
				</div>
		</div>
		<div class="form-group">
			<label for="hel_solucao_ios" class="col-sm-1 control-label">Solução</label>
				<div class="col-sm-11">
					<textarea readonly class="form-control" id="hel_solucao_ios" name="hel_solucao_ios" 
					          autocomplete="off" autofocus>{hel_solucao_ios}</textarea>
				</div>
		</div>
	
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
		        	<a type="button-primary" href="{VOLTAR_ITEM_CHAMADO}" class="btn btn-default">Voltar</a>
				</div>
			</div>
		</div>
	</div>
</div>		