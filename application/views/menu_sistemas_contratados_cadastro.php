<header class="page-header">
	<h2>Sistemas Contratados - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_msc" name="hel_pk_seq_msc" value="{hel_pk_seq_msc}"/>
			<input type="hidden" id="hel_seqsco_msc" name="hel_seqsco_msc" value="{hel_seqsco_msc}"/>

			<div class="form-group">
				<div class="{ERRO_HEL_SEQMEN_MSC}">
					<label for="hel_seqmen_msc" class="col-sm-1 control-label">Menu Contratados</label>
					<div class="col-sm-8">
						<select class="form-control" id="hel_seqmen_msc" name="hel_seqmen_msc" autofocus="autofocus">
							<option value="">Selecione...</option>
							{BLC_MENU}
								<option value="{hel_pk_seq_men}" {sel_hel_seqsco_msc} >{hel_desc_men}</option>
							{/BLC_MENU}
						</select>
				    </div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1	 col-sm-11">
					<button type="submit" name="salvar_sistema_cadastrado" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_MENU_CONTRATADOS}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		