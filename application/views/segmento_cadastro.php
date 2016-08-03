<header class="page-header">
	<h2>Segmento- {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_seg" name="hel_pk_seq_seg" value="{hel_pk_seq_seg}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_DESC_SEG}">
					<label for="hel_desc_seg" class="col-sm-1 control-label">Descrição</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_desc_seg" name="hel_desc_seg" 
						       value="{hel_desc_seg}" maxlength="60" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_SEGMENTO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		


