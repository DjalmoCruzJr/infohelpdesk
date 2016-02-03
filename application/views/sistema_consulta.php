<header class="page-header">
	<h2>Consulta de Sistema</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-12">
				<div>
					<a href="{NOVO_SISTEMA}" class="btn btn-primary {dis_incluir}"><i class="glyphicon glyphicon-plus"></i> Novo Sistema</a>
					<div class="pull-right">
						<a onclick="abrirDialogRelatorio()" class="btn btn-primary {dis_imprimir}"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
					</div>
				</div>
				</br>
				<div class="table">
					<table class="table table-striped table-bordered table-hover table-condensed" id="tb_sistema">
						<thead>
							<tr>
								<th>Código</th>
								<th>Descrição</th>
								<th>Tipo</th>
								<th class="coluna-acao" width="105">Assunto Sistema</th>
								<th class="coluna-acao" width="80"></th>
								<th class="coluna-acao" width="80"></th>
							</tr>
						</thead>
						<tbody>
							{BLC_DADOS}
							<tr>
								<td class="vertical-center">{hel_codigo_sis}</td>
								<td class="vertical-center">{hel_desc_sis}</td>
								<td class="vertical-center">{hel_tipo_sis}</td>
								<td class="text-center"><a href="{ASSUNTO_SISTEMA}" class="btn btn-link btn-xs {dis_alterar}" title="Assunto Sistema"><i class="glyphicon glyphicon-list-alt"></i></a></td>
								<td class="text-center"><a href="{EDITAR_SISTEMA}" class="btn btn-link btn-xs {dis_alterar}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
								<td class="text-center"><a onclick="{APAGAR_SISTEMA}" class="btn btn-link btn-xs {dis_excluir}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
							</tr>
							{/BLC_DADOS}
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span>
				</button>
				<h3 class="modal-title" id="myModalLabel">Info Rio Sistemas</h3>
			</div>
			<div class="modal-body">
				<h4>Deseja realmente apagar este sistema ?</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="relatorio_sistema" tabindex="-1" role="dialog" aria-labelledby="relatorio_sistema_label" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    <h3 class="modal-title" id="relatorio_sistema_label">Relatório - Sistema</h3>
                </div>
                <div class="modal-body">
                	<form class="form-horizontal">
						<div class="form-group">
							<label for="ordenacao_relatorio" class="col-sm-3 ">Ordenar por</label>
								<div class="col-sm-9">
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_codigo_sistema" name="ordenacao_relatorio" value="0"/>Código do Sistema
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_codigo" name="ordenacao_relatorio" value="1" checked/>Código
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="ordenacao_nome" name="ordenacao_relatorio" value="2" />Nome
										</label>
									</div>
								</div>
						</div>
						
						<div class="form-group">
							<label for="tipo_relatorio" class="col-sm-3 ">Filtrar por sistema</label>
								<div class="col-sm-9">
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_tipoDesktop_sis" name="tipo_relatorio" value="0"/>Desktop
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_tipoMobile_sis" name="tipo_relatorio" value="1" checked/>Mobile
										</label>
									</div>
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_tipoWeb_sis" name="tipo_relatorio" value="2" />Web
										</label>
									</div>
									
									<div class="radio-inline">
										<label>
											<input type="radio" id="hel_tipoTodos_sis" name="tipo_relatorio" value="3" checked/>Todos
										</label>
									</div>
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

    function apagar(){
        $('#myModal').modal('hide');
        location.href = 'sistema/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_sistema').modal('show');
    }

    function visualizarRelatorio() {
      	
      	var tipo = "";  

      	if (document.getElementById('hel_tipoDesktop_sis').checked) {
      		tipo = "0";
		} else if (document.getElementById('hel_tipoMobile_sis').checked) {
			tipo = "1";
		} else if (document.getElementById('hel_tipoWeb_sis').checked){
			tipo = "2"
		}else{
			tipo = "3";
		}

      	var orderBy = "";
      	
    	if (document.getElementById('ordenacao_codigo_sistema').checked) {
    		orderBy = " ORDER BY hel_codigo_sis";
    	} else if (document.getElementById('ordenacao_codigo').checked){
    		orderBy = " ORDER BY hel_pk_seq_sis";
		}else{
			orderBy = " ORDER BY hel_desc_sis";
		}
    	
    	$('#relatorio_sistema').modal('hide');
    	
    	window.open('sistema/relatorio/'+ orderBy +'/'+ tipo, '_blank');
    }
    
</script>