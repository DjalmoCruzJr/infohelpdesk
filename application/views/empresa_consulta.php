<header class="page-header">
	<h2>Consulta de Empresa</h2>
</header>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVA_EMPRESA}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Nova Empresa</a>
	                <div class="pull-right">
			    		<a onclick="abrirDialogRelatorio()" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Imprimir</a> 
			    	</div>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_empresa">
						<thead>
                            <tr>
                                <th>Nome Fantasia</th>    
                                <th>CNPJ</th>
                                <th>Cidade</th>
                                <th>Ativo</th>
                                <th class="coluna-acao" width="130">Contato da Empresa</th>
                                <th class="coluna-acao" width="140">Sistemas Contratados</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_nomefantasia_emp}</td>	    
	                                <td class="vertical-center">{hel_cnpj_emp}</td>
	                                <td class="vertical-center">{hel_nome_cid}</td>
	                                <td class="vertical-center">{hel_ativo_emp}</td>
	                                <td class="text-center"><a href="{EMPRESA_CONTATO}" class="btn btn-link btn-xs" title="Editar"><i class="glyphicon glyphicon-comment"></i></a></td>
                                    <td class="text-center"><a href="{EMPRESA_SISTEMA_CONTRATADO}" class="btn btn-link btn-xs" title="Sistema Contratado"><i class="glyphicon glyphicon-random"></i></a></td>
	                                <td class="text-center"><a href="{EDITAR_EMPRESA}" class="btn btn-link btn-xs" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_EMPRESA}" class="btn btn-link btn-xs" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
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
                    <h4>Deseja realmente apagar esta empresa ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="relatorio_empresa" tabindex="-1" role="dialog" aria-labelledby="relatorio_empresa_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_empresa_label">Relatório - Empresa</h3>
                </div>
                <div class="modal-body">
                	<form class="form-horizontal">
						<div class="form-group">
						<div class="form-group col-sm-11 text-center">
							<label class="checkbox-inline">
						       	<input type="checkbox" id="imprimir_sistema_contratado" name="imprimir_sistema_contratado" onclick="habilitarSistema()">Imprimir Sistemas Contratados ?
						    </label>
					    </div>
							<label for="ordenacao_relatorio" class="col-sm-2 ">Ordenar por</label>
								<div class="col-sm-4">
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_codigo" name="ordenacao_relatorio" value="0" checked/>Código
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_nome" name="ordenacao_relatorio" value="1"/>Nome
										</label>
									</div>
								</div>
						</div>
						<div class="form-group col-sm-11">
						    <label for="hel_ativo_emp" class="col-sm-1 control-label">Status</label>
								<div class="col-sm-11">
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
							<label for="cidade_relatorio" class="col-sm-3 ">Filtro por Cidade</label>
								<div>
			                		<select id="cidade_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple">
									{BLC_CIDADE_RELATORIO}
										<option value="{hel_pk_seq_cid}" {dis_hel_cid}>{hel_nome_cid}</option>
									{/BLC_CIDADE_RELATORIO}
									</select>	                			
								</div>
	                	</div>
	                	<div class="form-group">
	                		<label for="sistema_relatorio" class="col-sm-3 ">Filtro por Sistema</label>
								<div>
			                		<select id="sistema_relatorio" disabled class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple" >
									{BLC_SISTEMA_RELATORIO}
										<option value="{hel_pk_seq_sis}" {dis_hel_sis}>{hel_codigo_sis}</option>
									{/BLC_SISTEMA_RELATORIO}
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

	function habilitarSistema(){
		if (document.getElementById("sistema_relatorio").disabled){
			document.getElementById("sistema_relatorio").disabled = false;
		}else {
			document.getElementById("sistema_relatorio").disabled = true;
		}
	}	

    function abrirConfirmacao(id){
        idExclusao = id;
        $('#myModal').modal('show');
    }

    function apagar(){
        $('#myModal').modal('hide');
        location.href = 'empresa/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_empresa').modal('show');
    }

    function visualizarRelatorio() {
    	var cidade_relatorio  			= document.getElementById("cidade_relatorio");
    	var sistema_relatorio 			= document.getElementById("sistema_relatorio");
    	var imrprimi_sistema_contratado = "";
      	var orderBy 		  			= "";

      	var filtroCidade	 = "";
      	var separadorCidade  = "";
    	for (var i = 0; i < cidade_relatorio.options.length; i++) {
      		if (cidade_relatorio.options[i].selected){
      			filtroCidade 	 = filtroCidade + separadorCidade + cidade_relatorio.options[i].value;
      			separadorCidade  = ",";
        	}
      	} 

      	if (filtroCidade == ""){
      		filtroCidade = "0";
        }

      	var filtroSistema	 = "";
      	var separadorSistema  = "";
    	for (var i = 0; i < sistema_relatorio.options.length; i++) {
      		if (sistema_relatorio.options[i].selected){
      			filtroSistema 	  = filtroSistema + separadorSistema + sistema_relatorio.options[i].value;
      			separadorSistema  = ",";
        	}
      	} 

      	if (filtroSistema == ""){
      		filtroSistema = "0";
        }

        if (document.getElementById("imprimir_sistema_contratado").checked){
        	imrprimi_sistema_contratado = "1";
        } else {
        	imrprimi_sistema_contratado = "0";
        }

        var status = "";  

      	if (document.getElementById('hel_statusinativo_con').checked) {
      		status = "0";
		} else if (document.getElementById('hel_statusativo_con').checked) {
			status = "1";
		} else {
			status = "2"
		}
		
    	if (document.getElementById('ordenacao_codigo').checked) {
    		orderBy = " ORDER BY hel_pk_seq_emp";
    	} else {
    		orderBy = " ORDER BY hel_nomefantasia_emp";
		}
    	
    	$('#relatorio_empresa').modal('hide');
    	
    	
    	window.open('empresa/relatorio/'+ orderBy+'/'+filtroCidade+'/'+ imrprimi_sistema_contratado +'/'+ filtroSistema +'/'+ status, '_blank');
    }	

</script>