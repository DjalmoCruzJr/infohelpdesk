<header class="page-header">
	<h2>Item Chamado - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_ios" name="hel_pk_seq_ios" value="{hel_pk_seq_ios}"/>
			<input type="hidden" id="hel_tipo_ios" name="hel_tipo_ios" value="{hel_tipo_ios}"/>
			<input type="hidden" id="hel_seqcha_ios" name="hel_seqcha_ios" value="{hel_seqcha_ios}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_SEQSER_IOS}">
					<label for="hel_seqemp_ios" class="col-sm-1 control-label">Serviço</label>
					<div class="col-sm-5">
							<select class="form-control" id="hel_seqser_ios" name="hel_seqser_ios" autofocus="autofocus" >
								<option value="">Selecione...</option>
									{BLC_SERVICO}
								    	<option value="{hel_pk_seq_ser}" {sel_hel_seqser_ios}>{hel_desc_ser}</option>
								    {/BLC_SERVICO}
							</select>   
					</div>
				</div>
				<div class="{ERRO_HEL_SEQSIS_IOS}">
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
			</div>
			<div class="form-group">
				<label for="hel_complemento_ios" class="col-sm-1 control-label">Complemento</label>
					<div class="col-sm-11">
						<textarea class="form-control" id="hel_complemento_ios" name="hel_complemento_ios" {hel_disabledcomplemento_ios} 
						          autocomplete="off" autofocus>{hel_complemento_ios}</textarea>
					</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_STATUS_IOS}">
					<label for="hel_solucao_ios" class="col-sm-1 control-label">Solução</label>
						<div class="col-sm-11">
							<textarea {hel_hiddensolucao_ios} class="form-control" id="hel_solucao_ios" name="hel_solucao_ios" 
							          autocomplete="off" autofocus>{hel_solucao_ios}</textarea>
						</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="{ERRO_HEL_STATUS_IOS}">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox" id="hel_status_ios" name="hel_encerrado_ios" value="1"  
								{hel_checkedencerrado_ios} autocomplete="off" autofocus {hel_disabledencerrado_ios}/>Encerrado
							</label>										
						</div>
					</div>
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