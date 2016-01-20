<header class="page-header">
	<h2>Assunto Sistema - {ACAO}</h2>
</header>

<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal" enctype="multipart">
			<input type="hidden" id="hel_pk_seq_asu" name="hel_pk_seq_asu" value="{hel_pk_seq_asu}"/>
			<div class="form-group">
				<div class="{ERRO_HEL_TITULO_ASU}">
					<label for="hel_desc_tco" class="col-sm-1 control-label">Assunto</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_desc_tco"
							   name="hel_titulo_asu" value="{hel_titulo_asu}" maxlength="100" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			
			<div id="upload" class="panel panel-default">
				<div class="span12">
					<button type="submit" class="btn btn-primary start">
						<em class="glyphicon glyphicon-play ico-white"> </em>
						<span>Iniciar Upload</span>
					</button>
					<button type="submit" class="btn btn-primary start">
						<em class="glyphicon glyphicon-remove-circle ico-white"> </em>
						<span>Cancelar</span>
					</button>
					<button type="submit" class="btn btn-primary start">
						<em class="glyphicon glyphicon-trash ico-white"> </em>
						<span>Excluir</span>
					</button>
				</div>
				
				<div class="col-sm-12">
					<div class="row-fluid fileupload-buttonbar">
						<div class="col-sm-7">
							<span class="btn btn-success fileimput-button">
								<em class="glyphicon glyphicon-upload ico-white"> </em>
								<span>Adcionar arquivo</span>
								<input type="file" name="fitos[]"  multiple="multiple"/>
							</span>
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_tipo_contato" class="btn btn-primary"><i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_TIPO_CONTATO}" class="btn btn-default">Cancelar</a>
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

