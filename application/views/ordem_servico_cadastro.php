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
							<select class="form-control chosen-select-deselect" id="hel_seqemp_ose" name="hel_seqemp_ose" autofocus="autofocus" onchange="carregarContato()" >
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
									{BLC_CONTATO_EMPRESA}
										<option value="{hel_pk_seq_con}" {sel_hel_seqcon_ose}>{hel_nome_con}</option>
									{/BLC_CONTATO_EMPRESA}
								</select>   
						</div>
					</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_DATEINCIAL_OSE}">
					<label for="hel_dateinicial_ose" class="col-sm-1 control-label">Data Inicial</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-date" id="hel_dateinicial_ose" name="hel_dateinicial_ose"
						       value="{hel_datainicial_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_HORARIOINCIAL_OSE}">
					<label for="hel_horarioinicial_ose" class="col-sm-1 control-label">Horário Inicial</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-time" id="hel_horarioinicial_ose" name="hel_horarioinicial_ose" 
						       value="{hel_horarioinicial_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_DATEFINAL_OSE}">
					<label for="hel_datefinal_ose" class="col-sm-1 control-label">Data Final</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-date" id="hel_datefinal_ose" name="hel_datefinal_ose"
						       value="{hel_datafinal_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_HORARIOFINAL_OSE}">
					<label for="hel_horariofinal_ose" class="col-sm-1 control-label">Horário Final</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-time" id="hel_horariofinal_ose" name="hel_horariofinal_ose" 
						       value="{hel_horariofinal_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_KMINICIAL_OSE}">
					<label for="hel_kminicial_ose" class="col-sm-1 control-label">KM Inicial</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-km" id="hel_kminicial_ose" name="hel_kminicial_ose" 
						       value="{hel_kminicial_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_KMFINAL_OSE}">
					<label for="hel_kmfinal_ose" class="col-sm-1 control-label">KM Final</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-km" id="hel_kmfinal_ose" name="hel_kmfinal_ose" 
						       value="{hel_kmfinal_ose}" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="hel_observacao_ose" class="col-sm-1 control-label">Observação</label>
					<div class="col-sm-11">
						<textarea class="form-control" id="hel_observacao_ose" name="hel_observacao_ose" 
						       autocomplete="off" autofocus>{hel_observacao_ose}</textarea>
					</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_ORDEM_SERVICO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		
<script>
	function carregarContato(){
		
		var empresa 	   = document.getElementById("hel_seqemp_ose");
		var filtro_empresa = "";
	
		for (var i = 0; i < empresa.options.length; i++) {
	  		if (empresa.options[i].selected){
	  			filtro_empresa = empresa.options[i].value; 
	    	}
	  	}
	
		$.ajax({
	  		  url      : '{URL_BUSCAR_CONTATO}/' + filtro_empresa,
			  dataType : "json",
			  async    : true,
			  success  : function(data) {
				var options = '<option value="">Selecione...</option>';
				$("#hel_seqcon_ose").empty();
				for (i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].hel_pk_seq_con + '">' + data[i].hel_nome_con + '</option>';
				}
				$("#hel_seqcon_ose").html(options);
			  },
			 error    : function(error){
				console.log('Error na function carregarContato()');
		    }	
		});		
	}
</script>