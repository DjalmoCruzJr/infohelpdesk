<header class="page-header">
	<h2>Item Ordem Serviço - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden"  id="hel_pk_seq_ios" name="hel_pk_seq_ios" value="{hel_pk_seq_ios}"/>
			<input type="hidden" id="hel_tipo_ios" name="hel_tipo_ios" value="{hel_tipo_ios}"/>
			<input type="hidden" id="hel_seqose_ios" name="hel_seqose_ios" value="{hel_seqose_ios}"/>
			<div class="form-group">
				<div class="{ERRO_HEL_SEQCHA_IOS}">
					<label for="hel_seqcha_ios" class="col-sm-1 control-label">Chamado</label>
						<div class="col-sm-4">
							<select class="form-control chosen-select" id="hel_seqcha_ios" name="hel_seqcha_ios" onchange="carregarItemChamado()" autofocus="autofocus">
								<option value="">Selecione...</option>
								{BLC_CHAMADO}
									<option value="{hel_pk_seq_cha}" {sel_hel_seqcha_ios}>{hel_desc_cha}</option>
								{/BLC_CHAMADO}
							</select>   
						</div>
				</div>
				<div class="{ERRO_HEL_SEQCHAIOS_IOS}">
					<label for="hel_seqioscha_ios" class="col-sm-1 control-label">Item</label>
						<div class="col-sm-6">
							<select class="form-control" id="hel_seqioscha_ios" name="hel_seqioscha_ios" autofocus="autofocus" onchange="carregarDados()">
								{BLC_ITEM_CHAMADO}
									<option value="{hel_pk_seq1_ios}" {sel_hel_seqioscha_ios}>{hel_complemento1_ios}</option>
								{/BLC_ITEM_CHAMADO}
							</select>   
						</div>
				</div>
			</div>				
			<div class="form-group">
				<div class="{ERRO_HEL_SEQSER_IOS}">
					<label for="hel_seqser_ios" class="col-sm-1 control-label">Serviço</label>
					<div class="col-sm-5">
							<select class="form-control" id="hel_seqser_ios" name="hel_seqser_ios" autofocus="autofocus" {hel_disabledseqser_ios}>
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
							<select class="form-control" id="hel_seqsis_ios" name="hel_seqsis_ios" autofocus="autofocus" {hel_disabledseqsis_ios}>
								<option value="">Selecione...</option>
									{BLC_SISTEMA}
										<option value="{hel_pk_seq_sis}"  {sel_hel_seqsis_ios}>{hel_desc_sis}<small> ({hel_tipo_sis}) </small></option>
									{/BLC_SISTEMA}
							</select>
					</div>
				</div>
			</div>
			<div class="{ERRO_HEL_COMPLEMENTO_IOS}">
				<div class="form-group">
					<label for="hel_observacao_ose" class="col-sm-1 control-label">Complemento</label>
						<div class="col-sm-11">
							<textarea class="form-control" id="hel_complemento_ios" name="hel_complemento_ios"
							      maxlength="499" autocomplete="off" autofocus>{hel_complemento_ios}</textarea>
						</div>
				</div>
			</div>
			<br/>
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
<script type="text/javascript">

	function carregarItemChamado(){		
		var chamado 	   = document.getElementById("hel_seqcha_ios");
		var filtro_chamado = "";
		
		for (var i = 0; i < chamado.options.length; i++) {
	  		if (chamado.options[i].selected){
	  			filtro_chamado = chamado.options[i].value; 
	    	}
	  	}

	  	if (filtro_chamado == ""){
	  		filtro_chamado = "0";
		}

	  	$.ajax({
	  		  url      : '{URL_BUSCAR_CHAMADO}/' + filtro_chamado,
			  dataType : "json",
			  async    : true,
			  success  : function(data) {
				var options = '<option value="">Selecione...</option>';
				$("#hel_seqioscha_ios").empty();
				for (i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].hel_pk_seq1_ios + '">' + data[i].hel_complemento1_ios + '</option>';
				}
				$("#hel_seqioscha_ios").html(options);
			  },
			 error    : function(error){
				console.log('Error na function carregarContato()');
		    }	
		});

	  	desabilitarHabilitarComponentes();					
	}

	function carregarDados(){
		var item_chamado 	    = document.getElementById("hel_seqioscha_ios");
		var filtro_item_chamado = "";

		for (var i = 0; i < item_chamado.options.length; i++) {
			if (item_chamado.options[i].selected){
				filtro_item_chamado = item_chamado.options[i].value;
			}
		}

		if (filtro_item_chamado == ""){
			filtro_item_chamado = "0"
		}

		$.ajax({
			url      : '{URL_BUSCAR_ITEM_ORDEM_SERVICO}/' + filtro_item_chamado,
			dataType : "json",
			async    : true,
			success  : function(data) {
				var disabled_servico = false;
				var disabled_sistema = false;
				var servico	         = document.getElementById("hel_seqser_ios");
				var sistema          = document.getElementById("hel_seqsis_ios");

				desabilitarHabilitarComponentes();				
					
				for (var i = 0; i < servico.options.length; i++) {
					if (servico.options[i].value == data.hel_seqser_ios){
						servico.options[i].selected = true;
						disabled_servico = true;
					} 
				}

				document.getElementById("hel_seqser_ios").disabled = disabled_servico;

				if (!disabled_servico){
					document.getElementById("hel_seqser_ios").selected = disabled_servico;	
				} 

				for (var i = 0; i < sistema.options.length; i++) {
					if (sistema.options[i].value == data.hel_seqsis_ios){
						sistema.options[i].selected = true;
						disabled_sistema = true;
					}
				}

				document.getElementById("hel_seqsis_ios").disabled = disabled_sistema;

				if (!disabled_sistema){
					document.getElementById("hel_seqsis_ios").selected = disabled_sistema;	
				} 

			},
			error    : function(error){
				console.log('Error na function carregarDados()');
			}
		});
	}

	function desabilitarHabilitarComponentes(){
		var servico	 = document.getElementById("hel_seqser_ios");
		var sistema  = document.getElementById("hel_seqsis_ios");

		for (var i = 0; i < servico.options.length; i++) {
			servico.options[i].selected = false;
		}

		for (var i = 0; i < sistema.options.length; i++) {
			sistema.options[i].selected = false;
		}

	  	if (document.getElementById("hel_seqsis_ios").disabled){
			document.getElementById("hel_seqsis_ios").disabled = false;	
		}

		if (document.getElementById("hel_seqser_ios").disabled){
			document.getElementById("hel_seqser_ios").disabled = false;	
		}
	}

</script>		