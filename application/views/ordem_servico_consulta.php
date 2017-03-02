<header class="page-header" xmlns="http://www.w3.org/1999/html">
	<h2>Consulta de Ordem de Serviço</h2>
</header>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVA_ORDEM_SERVICO}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Nova Ordem de Serviço</a>
	                <div class="pull-right" >
	                	<a onclick="abrirDialogFiltro()" class="btn btn-info"><i class="glyphicon glyphicon-filter"></i> Filtro</a>

			    		<a onclick="abrirDialogRelatorio()" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Imprimir</a> 
			    	</div>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_ordem_servico">
						<thead>
                            <tr>
                            	<th>Número</th>
                                <th>Nome Fantasia</th>    
                                <th>Técnico</th>
                                <th>Data inicial</th>
                                <th>Data Final</th>
                                <th class="coluna-acao" width="140">Itens Ordem de Serviço</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                            	<td class="vertical-center">{hel_pk_seq_ose}</td>
	                                <td class="vertical-center">{hel_nomefantasia_emp}</td>	    
	                                <td class="vertical-center">{hel_nome_con}</td>
	                                <td class="vertical-center">{hel_datainicial_ose}</td>
	                                <td class="vertical-center">{hel_datafinal_ose}</td>
									<td class="text-center"><a href="{ITEM_ORDEM_SERVICO}" class="btn btn-link btn-xs" title="Item da Ordem Serviço"><i class="glyphicon glyphicon-list-alt"></i></a></td>	                                
	                                <td class="text-center"><a href="{EDITAR_ORDEM_SERVICO}" class="btn btn-link btn-xs"  title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_ORDEM_SERVICO}" class="btn btn-link btn-xs {hel_disabledexcluir_ose}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filtro_ordem_servico" tabindex="-1" role="dialog" aria-labelledby="filtro_ordem_servico_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_filtro_label">Opções de filtro</h3>
                </div>
                <div class="modal-body">
                	<form class="form-horizontal" action="{ACAO_FILTRO}" method="post">
						<div class="form-group">
							<label for="hel_seqemp_filtro" class="col-sm-3 control-label">Filtro Empresa</label>
								<div class="col-sm-9">
									<select class="form-control" id="hel_seqemp_filtro" name="hel_seqemp_filtro" onchange="carregarChamadoFiltro()" autofocus="autofocus">
										<option value="">Selecione...</option>
										{BLC_EMPRESA_FILTRO}
											<option value="{hel_pk_seq_emp}" {sel_hel_seqempfiltro_cha}>{hel_nomefantasia_emp}</option>
										{/BLC_EMPRESA_FILTRO}
									</select>
								</div>
	                	</div>

	                	<div class="form-group">
							<label for="hel_seqcon_filtro" class="col-sm-3 control-label">Filtro Técnico</label>
								<div class="col-sm-9">
									<select class="form-control" id="hel_seqcon_filtro" name="hel_seqcon_filtro" onchange="carregarChamadoFiltro()" autofocus="autofocus">
										<option value="">Selecione...</option>
										{BLC_TECNICO_FILTRO}
											<option value="{hel_pk_seq_con}" {sel_hel_seqconfiltro_con}>{hel_nome_con}</option>
										{/BLC_TECNICO_FILTRO}
									</select>
								</div>
	                	</div>	                	

						<div class="form-group">
							<label for="hel_dateinicialfiltro_ose" class="col-sm-1 control-label">Data Inicial</label>
								<div class="col-sm-3">
									<input type="text" class="form-control mask-date" id="hel_dateinicialfiltro_ose" name="hel_dateinicialfiltro_ose"  onblur="validarDataInicial()" 
									value="{hel_datainicial_ose}" autocomplete="off" autofocus/>
								</div>
						
										
							<label for="hel_datafinalfiltro_ose" class="col-sm-1 control-label">Data Final</label>
								<div class="col-sm-3">
									<input type="text" class="form-control mask-date" id="hel_datafinalfiltro_ose" name="hel_datafinalfiltro_ose" 
								    value="{hel_datafinal_ose}" onblur="validarDataFinal()" autocomplete="off" autofocus/>
								</div>
						</div>

						                	
	                	<br/>					
						<div class="form-group">
							<center>
								<button type="submit" name="filtro_ordem_servico" class="btn btn-primary" > <i class="glyphicon glyphicon-filter"></i> Filtrar</button>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							</center>	
						</div>
					</form>						
                </div>
        	</div>
    	</div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="myModalLabel">Info Rio Sistemas</h3>
                </div>
                <div class="modal-body">
                    <h4>Deseja realmente apagar esta ordem de serviço ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="relatorio_ordem_servico" tabindex="-1" role="dialog" aria-labelledby="relatorio_empresa_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_empresa_label">Relatório - Ordem de serviço</h3>
                </div>
				 <div class="modal-body">					 
					<div class="form-group">
						<label for="hel_dateinicialrelatorio_ose" class="col-sm-1 control-label">Data Inicial</label>
							<div class="col-sm-3">
								<input type="text" class="form-control mask-date" id="hel_dateinicialrelatorio_ose" name="hel_dateinicialrelatorio_ose"  onblur="validarDataRelatorioInicial()"  autocomplete="off"/>
							</div>
								
												
							<label for="hel_datafinalrelatorio_ose" class="col-sm-1 control-label">Data Final</label>
								<div class="col-sm-3">
									<input type="text" class="form-control mask-date" id="hel_datafinalrelatorio_ose" name="hel_datafinalfiltro_ose" onblur="validarDataRelatorioFinal()" autocomplete="off"/>
								</div>
						</div>
						<div class="form-group">						
							<label for="hel_seqcon_filtro" class="col-sm-3 control-label">Filtro O.S </label>
								<select id="ordem_servico_relatorio" onchange="habilitarDesabilitarComponentes()" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" >
									 {BLC_ORDEM_SERVICO_RELATORIO}
									 	<option value="{hel_pk_seq_ose}" >{hel_numero_ose}</option>
									 {/BLC_ORDEM_SERVICO_RELATORIO}
								 </select>
						 </div>

					 <div class="form-group">
						 <label for="tecnico_relatorio" class="col-sm-3 ">Filtro por técnico</label>
						 <div>
							 <select id="tecnico_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" >
								 {BLC_TECNICO_RELATORIO}
								 	<option value="{hel_pk_seq_con}" {dis_hel_tco}>{hel_nome_con}</option>
								 {/BLC_TECNICO_RELATORIO}
							 </select>
						 </div>
					 </div>

					 <div class="form-group">
							<label for="empresa_relatorio" class="col-sm-3 ">Filtro por empresa</label>
							<div>
								<select id="empresa_relatorio" onchange="habilitarDesabilitarEmpresa()" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple">
									{BLC_EMPRESA_RELATORIO}
									<option value="{hel_pk_seq_emp}" >{hel_nomefantasia_emp}</option>
									{/BLC_EMPRESA_RELATORIO}
								</select>
							</div>
						</div>
					</form>
					<br/>					
					<div class="form-group">
						<center>
							<button onclick="visualizarRelatorio()" name="salvar_usuario" class="btn btn-primary" > <i class="glyphicon glyphicon-print"></i> Visualizar</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						</center>	
					</div>	
                </div>
        	</div>
    	</div>
</div>


<script type="text/javascript">

	var idExclusao = "";	

    function abrirConfirmacao(id){
        idExclusao = id;
        $('#myModal').modal('show');
    }


    function abrirDialogFiltro(){
        $('#filtro_ordem_servico').modal('show');
    }

    function checarDatas(){
		var dataInicial = document.getElementById("hel_dateinicialfiltro_ose").value;
		var dataFinal   = document.getElementById("hel_datafinalfiltro_ose").value;

		if ((dataInicial != "__/__/____") && (dataFinal == "__/__/____" )){
			alert("Data Final deve ser preenchida");
		}else if ((dataInicial == "__/__/____") && (dataFinal != "__/__/____" )){
			alert("Data Inicial deve ser preenchida");
		}else if ((dataInicial != "__/__/____") && (dataFinal != "__/__/____")){
			var dataIni = new Date(dataInicial.split("/")[2], dataInicial.split("/")[1] - 1, dataInicial.split("/")[0]);
			var dataFim = new Date(dataFinal.split("/")[2], dataFinal.split("/")[1] - 1, dataFinal.split("/")[0])
			
			if (dataIni > dataFim) {
			   alert("Data inicial não pode ser maior que a data final");
			   return false;
			}
			else {
			    return true
			}
		}
	}

	function checarDatasRelatorio(){
		var dataInicial = document.getElementById("hel_dateinicialrelatorio_ose").value;
		var dataFinal   = document.getElementById("hel_datafinalrelatorio_ose").value;

		if ((dataInicial != "__/__/____") && (dataFinal != "__/__/____")){
			var dataIni = new Date(dataInicial.split("/")[2], dataInicial.split("/")[1] - 1, dataInicial.split("/")[0]);
			var dataFim = new Date(dataFinal.split("/")[2], dataFinal.split("/")[1] - 1, dataFinal.split("/")[0])
			
			if (dataIni > dataFim) {
			   alert("Data inicial não pode ser maior que a data final");
			   return false;
			}
			else {
			    return true
			}
		}
	}

    function validarDataFinal(){

    	dataFinal = document.getElementById("hel_datafinalfiltro_ose").value;
    	var dataInvalida = false;

    	if (dataFinal != "__/__/____"){
    		day   = dataFinal.substring(0,2);
			month = dataFinal.substring(3,5);
			year  = dataFinal.substring(6,10);

			if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) ) {//mes com 31 dias
				if( (day < 01) || (day > 31) ){
				    alert('Data final inválida');
				    dataInvalida = true;
				}
			} else if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
				if( (day < 01) || (day > 30) ){
				    alert('Data final inválida');
				    dataInvalida = true;
				}
			} else if( (month==02) ){//February and leap year
				if( (year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
					if( (day < 01) || (day > 29) ){
					    alert('Data final inválida');
					    dataInvalida = true;
					}
				} else {
					if( (day < 01) || (day > 28) ){
						alert('Data final inválida');
						dataInvalida = true;
					}
				}
			}
			if (!dataInvalida){
				checarDatas();	
			}
			
    	}else {
    		alert('Data final não preenchida');
    	}
	}

    function validarDataInicial(){

    	dataInicial = document.getElementById("hel_dateinicialfiltro_ose").value;
    	var dataInvalida = false;

    	if (dataInicial != "__/__/____"){
    		day   = dataInicial.substring(0,2);
			month = dataInicial.substring(3,5);
			year  = dataInicial.substring(6,10);

			if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) ) {//mes com 31 dias
				if( (day < 01) || (day > 31) ){
				    alert('Data inicial inválida');
				    dataInvalida = true;
				}
			} else if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
				if( (day < 01) || (day > 30) ){
				    alert('Data inicial inválida');
				    dataInvalida = true;
				}
			} else if( (month==02) ){//February and leap year
				if( (year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
					if( (day < 01) || (day > 29) ){
					    alert('Data inicial inválida');
					    dataInvalida = true;
					}
				} else {
					if( (day < 01) || (day > 28) ){
						alert('Data inicial inválida');
						dataInvalida = true;
					}
				}
			}
			if (!dataInvalida){
				checarDatas();	
			}
    	}else {
    		alert('Data Inicial não preenchida');
    	}
		
	}

	function validarDataRelatorioFinal(){

    	dataFinal = document.getElementById("hel_datafinalrelatorio_ose").value;
    	var dataInvalida = false;

    	if (dataFinal != "__/__/____"){
    		day   = dataFinal.substring(0,2);
			month = dataFinal.substring(3,5);
			year  = dataFinal.substring(6,10);

			if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) ) {//mes com 31 dias
				if( (day < 01) || (day > 31) ){
				    alert('Data final inválida');
				    dataInvalida = true;
				}
			} else if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
				if( (day < 01) || (day > 30) ){
				    alert('Data final inválida');
				    dataInvalida = true;
				}
			} else if( (month==02) ){//February and leap year
				if( (year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
					if( (day < 01) || (day > 29) ){
					    alert('Data final inválida');
					    dataInvalida = true;
					}
				} else {
					if( (day < 01) || (day > 28) ){
						alert('Data final inválida');
						dataInvalida = true;
					}
				}
			}
			if (!dataInvalida){
				if (checarDatasRelatorio()){
					document.getElementById("ordem_servico_relatorio").disabled = true;
				}else{
					document.getElementById("ordem_servico_relatorio").disabled = false;
				}
			}
			
    	}else {
    		document.getElementById("ordem_servico_relatorio").disabled = false;
    		alert('Data final não preenchida');
    	}

    	return dataInvalida;
	}

	function validarDataRelatorioInicial(){

    	dataInicial = document.getElementById("hel_dateinicialrelatorio_ose").value;
    	var dataInvalida = false;

    	if (dataInicial != "__/__/____"){
    		day   = dataInicial.substring(0,2);
			month = dataInicial.substring(3,5);
			year  = dataInicial.substring(6,10);

			if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) ) {//mes com 31 dias
				if( (day < 01) || (day > 31) ){
				    alert('Data inicial inválida');
				    dataInvalida = true;
				}
			} else if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
				if( (day < 01) || (day > 30) ){
				    alert('Data inicial inválida');
				    dataInvalida = true;
				}
			} else if( (month==02) ){//February and leap year
				if( (year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
					if( (day < 01) || (day > 29) ){
					    alert('Data inicial inválida');
					    dataInvalida = true;
					}
				} else {
					if( (day < 01) || (day > 28) ){
						alert('Data inicial inválida');
						dataInvalida = true;
					}
				}
			}
			if (!dataInvalida){
				if (checarDatasRelatorio()){
					document.getElementById("ordem_servico_relatorio").disabled = true;
				}else{
					document.getElementById("ordem_servico_relatorio").disabled = false;
				}
			}
    	}else {
    		document.getElementById("ordem_servico_relatorio").disabled = false;
    		alert('Data Inicial não preenchida');
    	}
	}

	function validarDataRelatorio(opcao){
		var dataInvalida = false;
		var date = "";
		if (opcao =='I'){
			date = document.getElementById("hel_dateinicialrelatorio_ose").value;
		}else {
			date = document.getElementById("hel_datafinalrelatorio_ose").value;
		}

    	if (date != "__/__/____"){
    		day   = date.substring(0,2);
			month = date.substring(3,5);
			year  = date.substring(6,10);

			if( (month==01) || (month==03) || (month==05) || (month==07) || (month==08) || (month==10) || (month==12) ) {//mes com 31 dias
				if( (day < 01) || (day > 31) ){
				    dataInvalida = true;
				}
			} else if( (month==04) || (month==06) || (month==09) || (month==11) ){//mes com 30 dias
				if( (day < 01) || (day > 30) ){
				    dataInvalida = true;
				}
			} else if( (month==02) ){//February and leap year
				if( (year % 4 == 0) && ( (year % 100 != 0) || (year % 400 == 0) ) ){
					if( (day < 01) || (day > 29) ){
					    dataInvalida = true;
					}
				} else {
					if( (day < 01) || (day > 28) ){
						dataInvalida = true;
					}
				}
			}
    	}else {
    		dataInvalida = true;
    	}

    	return !dataInvalida;
	}

	function carregarContato(){

		var empresa 	    = document.getElementById("empresa_relatorio");
		var filtro_empresa  = "";
		var separar_empresa = "";

		for (var i = 0; i < empresa.options.length; i++) {
			if (empresa.options[i].selected){
				filtro_empresa =  filtro_empresa + separar_empresa + empresa.options[i].value;
				separar_empresa = ",";
			}
		}

		$.ajax({
			url      : '{URL_BUSCAR_CONTATO}/' + filtro_empresa,
			dataType : "json",
			async    : true,
			success  : function(data) {
				var options = '<option value="">Selecione...</option>';
				$("#contato_relatorio").empty();
				for (i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].hel_pk_seq_con + '">' + data[i].hel_nome_con + '</option>';
				}
				$("#contato_relatorio").html(options);
				document.getElementById("contato_relatorio").disabled = false;
			},
			error    : function(error){
				console.log('Error na function carregarContato()');
			}
		});
	}

    function apagar(){
        $('#myModal').modal('hide');
        location.href = 'ordem_servico/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_ordem_servico').modal('show');
    }

    function habilitarDesabilitarComponentes(){
    	var ordem_servico_relatorio = document.getElementById("ordem_servico_relatorio");
		var disabled          		= false;

		for (var i = 0; i < ordem_servico_relatorio.options.length; i++) {
      		if (ordem_servico_relatorio.options[i].selected){
      			disabled = true;
        	}
      	}

		document.getElementById("tecnico_relatorio").disabled = disabled;
		document.getElementById("empresa_relatorio").disabled = disabled;
   	}

    function habilitarDesabilitarEmpresa(){
    	var empresa_relatorio 	= document.getElementById("empresa_relatorio");
    	var disabled			= false
    	for (var i = 0; i < empresa_relatorio.options.length; i++) {
    		if (empresa_relatorio.options[i].selected){
    			disabled = true;
    		}
    	}
    	document.getElementById("ordem_servico_relatorio").disabled = disabled;
   	}

    function visualizarRelatorio() {
        
    	var tecnico_relatorio 		= document.getElementById("tecnico_relatorio");
		var empresa_relatorio		= document.getElementById("empresa_relatorio");
		var ordem_servico_relatorio = document.getElementById("ordem_servico_relatorio");
		var dataIni 	    		= document.getElementById("hel_dateinicialrelatorio_ose").value;
		var dataFim     			= document.getElementById("hel_datafinalrelatorio_ose").value;		
      	var orderBy 		 	    = "";

      	var filtroTecnico	 = "";
      	var separadorTecnico = "";

		for (var i = 0; i < tecnico_relatorio.options.length; i++) {
      		if ( (tecnico_relatorio.options[i].selected) && (!document.getElementById("tecnico_relatorio").disabled)){
				filtroTecnico 	 = filtroTecnico + separadorTecnico + tecnico_relatorio.options[i].value;
				separadorTecnico = ",";
        	}
      	} 

      	if (filtroTecnico == ""){
			filtroTecnico = "0";
        }

		var filtroEmpresa	 = "";
		var separadorEmpresa = "";

		for (var i = 0; i < empresa_relatorio.options.length; i++) {
			if ( (empresa_relatorio.options[i].selected) && (!document.getElementById("empresa_relatorio").disabled) ){
				filtroEmpresa 	 = filtroEmpresa + separadorEmpresa + empresa_relatorio.options[i].value;
				separadorEmpresa = ",";
			}
		}

		if (filtroEmpresa == ""){
			filtroEmpresa = "0";
		}
		var filtroOrdemServico	  = "";
      	var separadorOrdemServico = "";

		for (var i = 0; i < ordem_servico_relatorio.options.length; i++) {
      		if (ordem_servico_relatorio.options[i].selected){
      			filtroOrdemServico 	  = filtroOrdemServico + separadorOrdemServico + ordem_servico_relatorio.options[i].value;
				separadorOrdemServico = ",";
        	}
      	} 

      	if (filtroOrdemServico == ""){
      		filtroOrdemServico = "0";
        }

        var dataFinalFiltroRelatorio    = "0";
        var dataInicialFiltroRelatorio  = "0";

		
        if ((dataIni != "") && (validarDataRelatorio('I'))){
        	var fiedData = dataIni.split("/")
        	dataInicialFiltroRelatorio = fiedData[2]+ "-" + fiedData[1] + "-" + fiedData[0];
        	var dateIni = new Date(dataIni.split("/")[2], dataIni.split("/")[1] - 1, dataIni.split("/")[0]);
        }

        if ((dataFim != "") && (validarDataRelatorio('F'))){
        	var fiedData = dataFim.split("/")
        	dataFinalFiltroRelatorio = fiedData[2]+ "-" + fiedData[1] + "-" + fiedData[0];
        	var dateFim = new Date(dataFim.split("/")[2], dataFim.split("/")[1] - 1, dataFim.split("/")[0])
        }
   
   		if (dateIni > dateFim){
   			alert('Data inicial maior que a final');
   		}else{
   			$('#relatorio_ordem_servico').modal('hide');	
			window.open('ordem_servico/relatorio/'+ filtroOrdemServico +'/'+ filtroTecnico + '/' + filtroEmpresa + '/' + dataInicialFiltroRelatorio + '/' + dataFinalFiltroRelatorio , '_blank');   			
   		}
    	    	
    }	

</script>