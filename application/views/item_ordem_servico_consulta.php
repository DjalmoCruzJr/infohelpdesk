<header class="page-header">
	<h2>Consulta dos Itens da Ordem de Serviço</h2>
</header>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_ITEM_ORDEM_SERVICO}" class="btn btn-primary {hel_disabled_ios}"><i class="glyphicon glyphicon-plus"></i> Novo Item</a>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_item_ordem_servico">
						<thead>
                            <tr>
                                <th>Serviço</th>    
                                <th>Chamado</th>
                                <th>Sistema</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_desc_ser}</td>	    
	                                <td class="vertical-center">{hel_seqcha_ios}</td>
	                                <td class="vertical-center">{hel_desc_sis}</td>
	                                <td class="text-center"><a href="{EDITAR_ITEM_ORDEM_SERVICO}" class="btn btn-link btn-xs {hel_disabled_ios}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_ITEM_ORDEM_SERVICO}" class="btn btn-link btn-xs {hel_disabled_ios}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
            <div class="text-right">
            <a href="{VOLTAR_ORDEM_SERVICO}" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Ordem Serviço</a>
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
                    <h4>Deseja realmente apagar este item da ordem de serviço ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="relatorio_contato" tabindex="-1" role="dialog" aria-labelledby="relatorio_empresa_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_empresa_label">Relatório - Contato</h3>
                </div>
                <div class="modal-body">
                	<form class="form-horizontal">
						<div class="form-group">
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
							<label for="tipo_contato_relatorio" class="col-sm-3 ">Filtro por Tipo de contato</label>
								<div>
			                		<select id="tipo_contato_relatorio" class="js-example-basic-multiple form-control " style="width: 360px;" multiple="multiple">
									{BLC_TIPO_CONTATO_RELATORIO}
										<option value="{hel_pk_seq_tco}" {dis_hel_tco}>{hel_desc_tco}</option>
									{/BLC_TIPO_CONTATO_RELATORIO}
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

	var idExclusao 		= "";
	var idOrdemServico 	= "";	

    function abrirConfirmacao(id, idos){
        idExclusao 		= id;
        idOrdemServico 	= idos;
        $('#myModal').modal('show');
    }

    function apagar(){
        $('#myModal').modal('hide');
        location.href = '{URL_APAGAR}/' + idExclusao + '/' + idOrdemServico;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_contato').modal('show');
    }

    function visualizarRelatorio() {
    	var tipo_contato_relatorio = document.getElementById("tipo_contato_relatorio");
      	var orderBy 		 	  = "";

      	var filtroTipoContato	 = "";
      	var separadorTipoContato = "";
    	for (var i = 0; i < tipo_contato_relatorio.options.length; i++) {
      		if (tipo_contato_relatorio.options[i].selected){
      			filtroTipoContato 	 = filtroTipoContato + separadorTipoContato + tipo_contato_relatorio.options[i].value;
      			separadorTipoContato = ",";
        	}
      	} 

      	if (filtroTipoContato == ""){
      		filtroTipoContato = "0";
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
    		orderBy = " ORDER BY hel_pk_seq_con";
    	} else {
    		orderBy = " ORDER BY hel_nome_con";
		}
    	
    	$('#relatorio_contato').modal('hide');
    	
    	window.open('contato/relatorio/'+ orderBy+'/'+filtroTipoContato+'/'+status, '_blank');
    }	

</script>