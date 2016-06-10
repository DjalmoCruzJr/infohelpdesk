<header class="page-header">
	<h2>Consulta de Chamado</h2>
</header>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_CHAMADO}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo Chamado</a>
	                <div class="pull-right">
			    		<a onclick="abrirDialogRelatorio()" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Imprimir</a> 
			    	</div>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_chamado">
						<thead>
                            <tr>
                                <th>Número</th>    
                                <th>Empresa</th>
                                <th>Contato</th>
                                <th>Data Abertura</th>
                                <th>Status</th>
                                <th class="coluna-acao" width="40">Itens</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_pk_seq_cha}</td>	    
	                                <td class="vertical-center">{hel_nomefantasia_emp}</td>
	                                <td class="vertical-center">{hel_nome_con}</td>
	                                <td class="vertical-center">{hel_horarioabertura_cha}</td>
	                                <td class="vertical-center">{hel_status_cha}</td>
	                                <td class="text-center"><a href="{ITEM_CHAMADO}" class="btn btn-link btn-xs {hel_disableditemencerrado_cha}" title="Itens do Chamado"><i class="glyphicon glyphicon-list-alt""></i></a></td>
	                                <td class="text-center"><a href="{EDITAR_CHAMADO}" class="btn btn-link btn-xs" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_CHAMADO}" class="btn btn-link btn-xs" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
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
                    <h4>Deseja realmente apagar este chamado ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="relatorio_chamado" tabindex="-1" role="dialog" aria-labelledby="relatorio_chamado_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_empresa_label">Relatório - Chamado</h3>
                </div>
                <div class="modal-body">
                	<form class="form-horizontal">
                		<div class="form-group col-sm-11 text-center">
							<label class="checkbox-inline">
						       	<input type="checkbox" id="imprimir_itens" name="imprimir_itens">Imprimir Itens do chamado
						    </label>
					    </div>
					    <div class="form-group col-sm-11 text-center">
							<label class="radio-inline">
							  <input type="radio" name="layout" id="hel_sintetico_cha" value="0" checked> Layout Sintetico
							</label>
							<label class="radio-inline">
							  <input type="radio" name="layout" id="hel_analitico_cha" value="1"> Layout Analitico
							</label>
						</div>
						<div class="form-group">
							<label for="ordenacao_relatorio" class="col-sm-2 ">Ordenar por</label>
								<div class="col-sm-7">
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_numero" name="ordenacao_relatorio" value="0" checked/>Numero
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_data" name="ordenacao_relatorio" value="1"/>Data Abertura
										</label>
									</div>
								</div>
						</div>						
						<div class="form-group col-sm-11">
						    <label for="hel_ativo_emp" class="col-sm-1 control-label">Status</label>
								<div class="col-sm-11">
								<div class="radio-inline">
										<label>
											<input type="radio" id="hel_statustodos_cha" onclick="carregarChamado()" name="status_relatorio" value="0" checked/>Todos
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_statusaberto_cha" onclick="carregarChamado()" name="status_relatorio" value="1"/>Aberto
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_statusencerrado_cha" onclick="carregarChamado()" name="status_relatorio" value="2" />Encerrado
										</label>
									</div>
								</div>
						</div>
						<div class="form-group">
							<label for="chamado_relatorio" class="col-sm-3 ">Filtro por Chamado</label>
								<div>
			                		<select id="chamado_relatorio" onchange="habilitarDesabilitaComponentes()" class="js-example-basic-multiple form-control" style="width: 360px;" multiple="multiple">
										{BLC_CHAMADO_RELATORIO}
											<option value="{hel_pk_seq_cha}" >{hel_numero_cha}</option>
										{/BLC_CHAMADO_RELATORIO}
									</select>	                			
								</div>	
	                	</div>
						<div class="form-group">
							<label for="empresa_relatorio" class="col-sm-3 ">Filtro por Empresa</label>
								<div>
			                		<select id="empresa_relatorio" class="js-example-basic-multiple form-control" style="width: 360px;" multiple="multiple">
										{BLC_EMPRESA_RELATORIO}
											<option value="{hel_pk_seq_emp}" >{hel_nomefantasia_emp}</option>
										{/BLC_EMPRESA_RELATORIO}
									</select>	                			
								</div>	
	                	</div>
<!-- 	                	<div class="form-group"> -->
<!-- 							<label for="contato_relatorio" class="col-sm-3 ">Filtro por Contato</label> -->
<!-- 								<div> -->
<!--			                		<select id="contato_relatorio" class="js-example-basic-multiple form-control" style="width: 360px;" multiple="multiple" disabled> -->
<!-- 			                			<option value=""></option> -->
<!-- 									</select>	                			 -->
<!-- 								</div>	 -->
<!-- 	                	</div> -->
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

    function apagar(){
        $('#myModal').modal('hide');
        location.href = 'chamado/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_chamado').modal('show');
    }

    function habilitarDesabilitaComponentes(){
    	var chamado        = document.getElementById("chamado_relatorio");
    	var filtro_chamado = "";
    	var disabled       = false;

    	for (var i = 0; i < chamado.options.length; i++) {
	  		if (chamado.options[i].selected){
	  			disabled = true;
	    	}
	  	}
    	
    	document.getElementById("empresa_relatorio").disabled 		= disabled;
    	document.getElementById("hel_statustodos_cha").disabled 	= disabled;
    	document.getElementById("hel_statusaberto_cha").disabled 	= disabled;
    	document.getElementById("hel_statusencerrado_cha").disabled = disabled;    	
    }

	function carregarChamado(){
		
		var status  = "";
		var options = "";

		if (document.getElementById('hel_statusaberto_cha').checked) {
			status = "0"
		}else if (document.getElementById('hel_statusencerrado_cha').checked){
			status = "1"
		}	
	
		$.ajax({
			url      : '{URL_BUSCAR_CHAMADO}/' + status,
			dataType : "json",
			async    : true,
			success  : function(data) {
				$("#chamado_relatorio").empty();
				for (i = 0; i < data.length; i++) {
					options += '<option value="' + data[i].hel_pk_seq_cha + '">' + data[i].hel_numero_cha + '</option>';
				}
				$("#chamado_relatorio").html(options);
			},
			error    : function(error){
				console.log('Error na function carregarChamado()');
			}	
		});
	 		
	}

	function carregarContato(){
		
		var empresa 	      = document.getElementById("empresa_relatorio");
		var separador_empresa = ""; 
		var filtro_empresa    = "";
		var options           = "";
	
		for (var i = 0; i < empresa.options.length; i++) {
	  		if (empresa.options[i].selected){
	  			filtro_empresa = filtro_empresa + separador_empresa+  empresa.options[i].value;
	  			separador_empresa = "," 
	    	}
	  	}

	  	if (filtro_empresa != ""){
	  		$.ajax({
		  		  url      : '{URL_BUSCAR_CONTATO}/' + filtro_empresa,
				  dataType : "json",
				  async    : true,
				  success  : function(data) {
					$("#contato_relatorio").empty();
					for (i = 0; i < data.length; i++) {
						options += '<option value="' + data[i].hel_pk_seq_con + '">' + data[i].hel_nome_con + '</option>';
					}
				  },
				 error    : function(error){
					console.log('Error na function carregarContato()');
			    }	
			});

			document.getElementById("contato_relatorio").disabled = false;
		}else {
			document.getElementById("contato_relatorio").disabled = true;
		}
	 		
	}

    function visualizarRelatorio() {
    	var empresa_relatorio = document.getElementById("empresa_relatorio");
    	var chamado_relatorio = document.getElementById("chamado_relatorio");
      	var orderBy 		  = "";
      	var status 		  	  = "0";
      	var imprimi_itens     = "0";
      	var layout		      = "1";

      	var filtroEmpresa	 = "";
      	var separadorEmpresa = "";
      	for (var i = 0; i < empresa_relatorio.options.length; i++) {
    	     if ( (empresa_relatorio.options[i].selected) && (!document.getElementById("empresa_relatorio").disabled)){
				filtroEmpresa 	 = filtroEmpresa + separadorEmpresa + empresa_relatorio.options[i].value;
				separadorEmpresa = ",";
			}
		}  	

      	if (filtroEmpresa == ""){
      		filtroEmpresa = "0";
        }  

    	var filtroChamado	 = "";
      	var separadorChamado = "";
      	for (var i = 0; i < chamado_relatorio.options.length; i++) {
          	if (chamado_relatorio.options[i].selected){
          		filtroChamado 	 = filtroChamado + separadorChamado + chamado_relatorio.options[i].value;
          		separadorChamado = ",";
        	}
        }
    	 

      	if (filtroChamado == ""){
      		filtroChamado = "0";
        } 

      	if ( (document.getElementById('hel_statusaberto_cha').checked) && (!document.getElementById('hel_statusaberto_cha').disabled) ){
      		status = "1";
		} else if ( (document.getElementById('hel_statusencerrado_cha').checked) && (!document.getElementById('hel_statusencerrado_cha').disabled) ) {
			status = "2";
		}
		
    	if (document.getElementById('ordenacao_numero').checked) {
    		orderBy = " ORDER BY hel_pk_seq_cha";
    	} else {
    		orderBy = " ORDER BY hel_horarioabertura_cha";
        }

    	if (document.getElementById('imprimir_itens').checked){
    		imprimi_itens = "1";
        }

        if (document.getElementById('hel_sintetico_cha').checked){
        	layout = "1";
        }else {
        	layout = "2";
        }
    	
    	$('#relatorio_contato').modal('hide');
    	
    	window.open('chamado/relatorio/'+ orderBy + '/' + layout +'/' + filtroChamado + '/'+ filtroEmpresa +'/'+status + '/' + imprimi_itens, '_blank');
    }	

</script>