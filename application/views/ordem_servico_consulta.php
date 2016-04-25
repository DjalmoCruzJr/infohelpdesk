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

					 <div class="form-group col-sm-13">
						 <label for="hel_ativo_emp" class="col-sm-3 ">Status do contato</label>
						 <div class="col-sm-9">
							 <div class="radio-inline">
								 <label>
									 <input type="radio" id="hel_statusinativo_con" name="status_relatorio" value="0" checked/>Inativo
								 </label>
							 </div>
							 <div class="radio-inline">
								 <label>
									 <input type="radio" id="hel_statusativo_con" name="status_relatorio" value="1"/>Ativo
								 </label>
							 </div>
							 <div class="radio-inline">
								 <label>
									 <input type="radio" id="hel_statustodos_con" name="status_relatorio" value="2" checked="checked" />Todos
								 </label>
							 </div>
						 </div>
					 </div>
					 
					 <div class="form-group">
						 <label for="ordem_servico_relatorio" class="col-sm-3 ">Filtro por O.S</label>
						 <div>
							 <select id="ordem_servico_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" >
								 {BLC_ORDEM_SERVICO_RELATORIO}
								 	<option value="{hel_pk_seq_ose}" >{hel_numero_ose}</option>
								 {/BLC_ORDEM_SERVICO_RELATORIO}
							 </select>
						 </div>
					 </div>

					 <div class="form-group">
						 <label for="tecnico_relatorio" class="col-sm-3 ">Filtro por técnico</label>
						 <div>
							 <select id="tecnico_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" >
								 {BLC_TECNICO_RELATORIO}
								 	<option value="{hel_pk_seq_tco}" {dis_hel_tco}>{hel_desc_tco}</option>
								 {/BLC_TECNICO_RELATORIO}
							 </select>
						 </div>
					 </div>

					 <div class="form-group">
							<label for="empresa_relatorio" class="col-sm-3 ">Filtro por empresa</label>
							<div>
								<select onchange="carregarContato()" id="empresa_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple">
									{BLC_EMPRESA_RELATORIO}
									<option value="{hel_pk_seq_emp}" >{hel_nomefantasia_emp}</option>
									{/BLC_EMPRESA_RELATORIO}
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="contato_relatorio" class="col-sm-3 ">Filtro por contato da empresa</label>
								<div>
			                		<select id="contato_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" disabled>
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

	function carregarContato(){

		var empresa 	   = document.getElementById("empresa_relatorio");
		var filtro_empresa = "";
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

	function habilitarSistema(){
		if (document.getElementById("tipo_empresa_relatorio").disabled == false){
			document.getElementById("tipo_contato_relatorio").disabled = false;
		}else {
			document.getElementById("tipo_contato_relatorio").disabled = true;
		}
	}

    function apagar(){
        $('#myModal').modal('hide');
        location.href = 'ordem_servico/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_ordem_servico').modal('show');
    }

    function visualizarRelatorio() {
    	var tecnico_relatorio 		= document.getElementById("tecnico_relatorio");
		var empresa_relatorio		= document.getElementById("empresa_relatorio");
		var contato_relatorio 		= document.getElementById("contato_relatorio");
		var ordem_servico_relatorio = document.getElementById("ordem_servico_relatorio");
      	var orderBy 		 	    = "";

      	var filtroTecnico	 = "";
      	var separadorTecnico = "";

		for (var i = 0; i < tecnico_relatorio.options.length; i++) {
      		if (tecnico_relatorio.options[i].selected){
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
			if (empresa_relatorio.options[i].selected){
				filtroEmpresa 	 = filtroEmpresa + separadorEmpresa + empresa_relatorio.options[i].value;
				separadorEmpresa = ",";
			}
		}

		if (filtroEmpresa == ""){
			filtroEmpresa = "0";
		}

		var filtroContato	 = "";
		var separadorContato = "";

		for (var i = 0; i < contato_relatorio.options.length; i++) {
			if (contato_relatorio.options[i].selected){
				filtroContato 	 = filtroContato + separadorContato + contato_relatorio.options[i].value;
				separadorContato = ",";
			}
		}

		if (filtroContato == ""){
			filtroContato = "0";
		}

		var filtroOrdemServico	  = "";
      	var separadorOrdemServico = "";

		for (var i = 0; i < ordem_servico_relatorio.options.length; i++) {
      		if (ordem_servico_relatorio.options[i].selected){
      			filtroOrdemServico 	 = filtroOrdemServico + separadorOrdemServico + ordem_servico_relatorio.options[i].value;
				separadorOrdemServico = ",";
        	}
      	} 

      	if (filtroOrdemServico == ""){
      		filtroOrdemServico = "0";
        }

    	$('#relatorio_ordem_servico').modal('hide');
    	
    	window.open('ordem_servico/relatorio/'+ filtroOrdemServico +'/'+ filtroTecnico + '/' + filtroEmpresa + '/' + filtroContato, '_blank');
    }	

</script>