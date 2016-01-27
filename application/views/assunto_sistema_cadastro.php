<header class="page-header">
	<h2>Assunto do Sistema - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal" enctype="multipart">
			<input type="hidden" id="hel_pk_seq_asu" name="hel_pk_seq_asu" value="{hel_pk_seq_asu}"/>
			<input type="hidden" id="hel_seqsis_asu" name="hel_seqsis_asu" value="{hel_seqsis_asu}"/>
			<div class="form-group">
				<div class="{ERRO_HEL_TITULO_ASU}">
					<label for="hel_desc_tco" class="col-sm-1 control-label">Assunto</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_titulo_asu" name="hel_titulo_asu" 
							   value="{hel_titulo_asu}" maxlength="100" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_tipo_contato" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_ASSUNTO_SISTEMA}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
	</div>
</div>	

<script id="upload" type="text/x-tmpl">
	{% for (var i = 0, file; file=o.fales[i]; i++) { %}
		<tr class="upload" fade> 
			<td> 
				<span class="preview"></span>
			</td>
			<td>
				<p class="name">{%=file.name%} </p>
					{% if (file.erro ) { %}
						<div>
							<span class="label label-danger">Error</span>
								{%=fale.Error%}
						</div>
					{% } %}
			</td>
			<td>
				<p class="size"> {%=o.formatFilesize(file.size) %} </p>
					{% if (!o.files.error) { %}
						<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<div class="progress-bar  progress-bar-cuccess" style="width:0%"/>
								</div>
					{% } %}
			</td>
			<td>
				{% if (! o.fole.error && !i && !o.options.autoUpload) { %}
					<button type="button" class="btn btn-primary start">
						<i class="icon-upload ico-white"> </i>
							<span>Start</span>
					</button>
				{% } %}
					{% if (!i) { %}
						<button type="button" class="btn btn-primary start">
							<i class="ico-white" icon-bar-circle > </i>
								<span>cancel</span>
						</button>
					{% } %}
			</td>
		</tr>
	{% } %}
</script>

