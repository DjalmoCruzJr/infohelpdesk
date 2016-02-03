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
			    		<a onclick="abrirDialogRelatorio()" class="btn btn-primary {dis_imprimir}"><i class="glyphicon glyphicon-print"></i> Imprimir</a> 
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
	                                <td class="text-center"><a href="{ITEM_CHAMADO}" class="btn btn-link btn-xs" title="Itens do Chamado"><i class="glyphicon glyphicon-list-alt""></i></a></td>
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
                    <h3 class="modal-title" id="relatorio_chamado_label">Relatório - Chamado</h3>
                </div>
                <div class="modal-body">
<!--                 	<form class="form-horizontal"> -->
<!-- 						<div class="form-group"> -->
<!-- 							<label for="ordenacao_relatorio" class="col-sm-2 ">Ordenar por</label> -->
<!-- 								<div class="col-sm-4"> -->
<!-- 									<div class="radio-inline"> -->
<!-- 										<label> -->
<!-- 											<input type="radio" id="ordenacao_codigo" name="ordenacao_relatorio" value="0" checked/>Código -->
<!-- 										</label> -->
<!-- 									</div> -->
<!-- 									<div class="radio-inline"> -->
<!-- 										<label> -->
<!-- 											<input type="radio" id="ordenacao_nome" name="ordenacao_relatorio" value="1"/>Nome -->
<!-- 										</label> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 						</div> -->
<!-- 						<div class="form-group col-sm-11"> -->
<!-- 						    <label for="hel_ativo_emp" class="col-sm-1 control-label">Status</label> -->
<!-- 								<div class="col-sm-11"> -->
<!-- 									<div class="radio-inline"> -->
<!-- 										<label> -->
<!-- 											<input type="radio" id="hel_statusinativo_cha" name="status_relatorio" value="0" checked/>Aberto -->
<!-- 										</label> -->
<!-- 									</div> -->
<!-- 									<div class="radio-inline"> -->
<!-- 										<label> -->
<!-- 											<input type="radio" id="hel_statusativo_cha" name="status_relatorio" value="1"/>Encerrado  -->
<!-- 										</label> -->
<!-- 									</div> -->
<!-- 									<div class="radio-inline"> -->
<!-- 										<label> -->
<!-- 											<input type="radio" id="hel_statustodos_cha" name="status_relatorio" value="2" checked="checked" />Todos -->
<!-- 										</label> -->
<!-- 									</div> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 					</form> -->
<!--                 	</div> -->
					<br/>					
					<div class="form-group">
						<center>
							<button onclick="visualizarRelatorio()" name="salvar_chamado" class="btn btn-primary" > <i class="glyphicon glyphicon-print"></i> Visualizar</button>
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

    function visualizarRelatorio() {
//     	var tipo_contato_relatorio = document.getElementById("tipo_contato_relatorio");
      	

//       	var filtroTipoContato	 = "";
//       	var separadorTipoContato = "";
//     	for (var i = 0; i < tipo_contato_relatorio.options.length; i++) {
//       		if (tipo_contato_relatorio.options[i].selected){
//       			filtroTipoContato 	 = filtroTipoContato + separadorTipoContato + tipo_contato_relatorio.options[i].value;
//       			separadorTipoContato = ",";
//         	}
//       	} 

//       	if (filtroTipoContato == ""){
//       		filtroTipoContato = "0";
//         }

//         var status = "";  

//       	if (document.getElementById('hel_statusinativo_con').checked) {
//       		status = "0";
// 		} else if (document.getElementById('hel_statusativo_con').checked) {
// 			status = "1";
// 		} else {
// 			status = "2"
// 		}
		
//     	if (document.getElementById('ordenacao_codigo').checked) {
//     		orderBy = " ORDER BY hel_pk_seq_con";
//     	} else {
//     		orderBy = " ORDER BY hel_nome_con";
// 		}
    	
    	$('#relatorio_chamado').modal('hide');
    	
    	window.open('chamado/relatorio/', '_blank');
    }	

</script>