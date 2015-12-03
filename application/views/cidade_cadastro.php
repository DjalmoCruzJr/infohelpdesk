<header class="page-header">
	<h2>Cidade- {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_cid" name="hel_pk_seq_cid" value="{hel_pk_seq_cid}"/>				
			<div class="form-group">
				<div class="{ERRO_GAB_NOME_HEL}">
					<label for="hel_nome_cid" class="col-sm-1 control-label">Nome</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_nome_cid"  
							   name="hel_nome_cid" value="{hel_nome_cid}" maxlength="60" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_GAB_UF_HEL}">
					<label for="hel_uf_cid" class="col-sm-1 control-label">UF</label>
					<div class="col-sm-3">
							<select class="form-control" id="hel_uf_cid" name="hel_uf_cid" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_UF}
								    	<option value="{uf}" {selected_uf}>{uf}</option>
								    {/BLC_UF}
							</select>   
					</div>
				</div>
			<label for="gab_codmun_cid" class="col-lg-1 control-label">Codigo Mun.</label>
				<div class="col-lg-2">
					<input type="text" class="form-control mask-cod-mun" id="hel_codmun_cid"  name="hel_codmun_cid"
						   value="{hel_codmun_cid}" maxlength="7" autocomplete="off" autofocus/>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_CIDADE}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		


