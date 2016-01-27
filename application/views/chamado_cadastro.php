<header class="page-header">
	<h2>Chamado - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_cha" name="hel_pk_seq_cha" value="{hel_pk_seq_cha}"/>
			<input type="hidden" id="hel_seqcon_cha" name="hel_seqcon_cha" value="{hel_seqcon_cha}"/>
			<input type="hidden" id="hel_seqconde_cha" name="hel_seqconde_cha" value="{hel_seqconde_cha}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_SEQEMP_CHA}">
					<label for="hel_seqemp_cha" class="col-sm-1 control-label">Empresa</label>
						<div class="col-sm-11">
							<select class="form-control chosen-select" id="hel_seqemp_cha" name="hel_seqemp_cha" autofocus="autofocus" onchange="carregarContato()">
								<option value="">Selecione...</option>
								{BLC_EMPRESA}
									<option value="{hel_pk_seq_emp}" {sel_hel_seqemp_cha}>{hel_nomefantasia_emp}</option>
								{/BLC_EMPRESA}
							</select>
						</div>
				</div>
			</div>
			<div class="form-group" {hel_hiddenseqconsolicitante_cha}>
				<div class="{ERRO_HEL_SEQCON_CHA}">
					<label for="hel_seqconsolicitante_cha" class="col-sm-1 control-label">Solicitante</label>
					<div class="col-sm-7">
							<select class="form-control" id="hel_seqconsolicitante_cha" name="hel_seqconsolicitante_cha" autofocus="autofocus">
								{BLC_CONTATO_SOLICITANTE}
									<option value="{hel_pk_seq_con}" {sel_hel_seqconsolicitante_cha}>{hel_nome_con}</option>
								{/BLC_CONTATO_SOLICITANTE}
							</select>   
					</div>
				</div>
			</div>
			
			<div class="form-group" {hel_hiddenseqconpara_cha}>
				<div class="{ERRO_HEL_SEQCONDE_CHA}">
					<label for="hel_seqconpara_cha" class="col-sm-1 control-label">Aberto Por</label>
					<div class="col-sm-6">
							<select class="form-control" id="hel_seconde_cha" name="hel_seconde_cha" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_CONTATO_DE}
								    	<option value="{hel_pk_seq_con}" {sel_hel_seqconode_cha}>{hel_nome_con}</option>
								    {/BLC_CONTATO_DE}
							</select>   
					</div>
				</div>
			</div>
			
			<div class="form-group" {hel_hiddenseqconpara_cha}>
				<div class="{ERRO_HEL_SEQCONPARA_CHA}">
					<label for="hel_seqconpara_cha" class="col-sm-1 control-label">Aberto Para</label>
					<div class="col-sm-6">
							<select class="form-control" id="hel_seqconpara_cha" name="hel_seqconpara_cha" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_CONTATO_PARA}
								    	<option value="{hel_pk_seq_con}" {sel_hel_seqconopara_cha}>{hel_nome_con}</option>
								    {/BLC_CONTATO_PARA}
							</select>   
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="{ERRO_HEL_STATUS_CHA}">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"  id="hel_status_cha"name="hel_status_cha" value="1" 
								{hel_checkedencerrado_cha} autocomplete="off" autofocus {hel_disabledencerrado_cha}/>Encerrado
							</label>										
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_CHAMADO}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function carregarContato(){
		
		var empresa 	   = document.getElementById("hel_seqemp_cha");
		var filtro_empresa = "";
	
		for (var i = 0; i < empresa.options.length; i++) {
	  		if (empresa.options[i].selected){
	  			filtro_empresa = empresa.options[i].value; 
	    	}
	  	}

	  	console.log("Filtro Empresa -> " + filtro_empresa);
	
		$.ajax({
	  		  url      : '{URL_BUSCAR_CONTATO}/' + filtro_empresa,
			  dataType : "json",
			  async    : true,
			  success  : function(data) {
				var options = '<option value="">Selecione...</option>';
				$("#hel_seqconsolicitante_cha").empty();
				for (i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].hel_pk_seq_con + '">' + data[i].hel_nome_con + '</option>';
				}
				$("#hel_seqconsolicitante_cha").html(options);
			  },
			 error    : function(error){
				console.log('Error na function carregarContato()');
		    }	
		});		
	}
</script>		