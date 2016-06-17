<header class="page-header">
	<h2>Assunto do Sistema - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
	<?php
		echo form_open_multipart('assunto_sistema/salvar');
	?>
<!-- 		<form form_open_multipart="{ACAO_FORM}" class="form-horizontal" enctype="multipart"> -->
			<input type="hidden" id="hel_pk_seq_asu" name="hel_pk_seq_asu" value="{hel_pk_seq_asu}"/>
			<input type="hidden" id="hel_seqsis_asu" name="hel_seqsis_asu" value="{hel_seqsis_asu}"/>
			<div class="form-group">
				<div class="{ERRO_HEL_TITULO_ASU}">
					<label for="hel_desc_tco" class="col-sm-1 control-label">Título</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_titulo_asu" name="hel_titulo_asu" 
							   value="{hel_titulo_asu}" maxlength="100" autocomplete="off" autofocus/>
					</div>
				</div>
				
				<div class="">
					<div class="col-sm-11">
						<br/>
						<input type="file" id="hel_link_asu" name="hel_link_asu" />
					</div>
				</div>
								
					
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_tipo_contato" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_ASSUNTO_SISTEMA}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
<!-- 		</form> -->
			 <?php
				echo form_close();
			 ?> 
	</div>
</div>	
