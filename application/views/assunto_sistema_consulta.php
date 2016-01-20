<header class="page-header">
	<h2>Consulta de assunto do sistema</h2>
</header>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_ASSUNTO_SISTEMA}" class="btn btn-primary {dis_incluir}"><i class="glyphicon glyphicon-plus"></i> Novo Assunto de Sitema</a>
	                <div class="pull-right">
			    		<a onclick="abrirDialogRelatorio()" class="btn btn-primary {dis_imprimir}"><i class="glyphicon glyphicon-print"></i> Imprimir</a>
			    	</div>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_assunto">
						<thead>
                            <tr>
                            	<th>Código Sistema</th>
                            	<th>Sistema</th>
                                <th>Título</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                            	<td class="vertical-center">{hel_codigo_sis}</td>
	                            	<td class="vertical-center">{hel_desc_sis}</td>
	                                <td class="vertical-center">{hel_titulo_asu}</td>
	                                <td class="text-center"><a href="{EDITAR_ASSUNTO_SISTEMA}" class="btn btn-link btn-xs {dis_alterar}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_ASSUNTO_SISTEMA}" class="btn btn-link btn-xs {dis_excluir}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="relatorio_tipo_contato" tabindex="-1" role="dialog" aria-labelledby="relatorio_tipo_contato_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                <h3 class="modal-title" id="relatorio_tipo_contato_label">Relatório - Tipo de Contato</h3>
            </div>
            <div class="modal-body">
                <div class="form-group col-sm-11">
                    <label for="hel_ativo_emp" class="col-sm-3 control-label">Filtro por tipo</label>
                    <div class="col-sm-9">
                        <div class="radio-inline">
                            <label>
                                <input type="radio" id="hel_statustecnico_tco" name="status_relatorio" value="0" checked/>Técnico
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" id="hel_statusresponsavel_tco" name="status_relatorio" value="1"/>Responsável
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" id="hel_statusoutros_tco" name="status_relatorio" value="2" />Outros
                            </label>
                        </div>
                        <div class="radio-inline">
                            <label>
                                <input type="radio" id="hel_statustodos_tco" name="status_relatorio" value="3" checked />Todos
                            </label>
                        </div>
                    </div>
                </div>
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
                                    <input type="radio" id="ordenacao_nome" name="ordenacao_relatorio" value="1"/>Descrição
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
                <br/>
                <div class="form-group">
                    <center>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </center>
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
                    <h4>Deseja realmente apagar este assunto do sistema ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
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
        location.href = 'assunto_sistema/apagar/' + idExclusao;
    }

    function abrirDialogRelatorio(){
        $('#relatorio_tipo_contato').modal('show');
    }

    function visualizarRelatorio() {
        var orderBy = "";
        var status = "";

        if (document.getElementById('hel_statustecnico_tco').checked) {
            status = "0";
        } else if (document.getElementById('hel_statusresponsavel_tco').checked) {
            status = "1";
        } else if (document.getElementById('hel_statusoutros_tco').checked) {
            status = "2";
        }else {
            status = "3";
        }

        if (document.getElementById('ordenacao_codigo').checked) {
            orderBy = " ORDER BY hel_pk_seq_tco";
        } else {
            orderBy = " ORDER BY hel_desc_tco";
        }

        $('#relatorio_tipo_contato').modal('hide');

        window.open('tipo_contato/relatorio/'+ orderBy+'/'+status,'_blank');
    }

</script>