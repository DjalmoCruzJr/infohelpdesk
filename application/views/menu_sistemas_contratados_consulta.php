<header class="page-header">
	<h2>Consulta de Menu Contratados - {NOME_SISTEMA}</h2>
</header>


<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_CONTATO}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo Sistema Contratado</a>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_menu_sistema_contratado">
						<thead>
                            <tr>
                                <th>Descrição</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_desc_men}</td>
	                                <td class="text-center"><a href="{EDITAR_SISTEMAS_CONTRATADOS}" class="btn btn-link btn-xs " title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_SISTEMAS_CONTRATADOS}" class="btn btn-link btn-xs" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
        <div class="text-right">
            <a href="{VOLTAR_SISTEMA_CONTRATADO}" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Sistema Contratado</a>
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
                    <h4>Deseja realmente apagar esta Menu Contratado ?</h4>
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
    var idEmpresa  = "";
    var idSistema  = "";

    function abrirConfirmacao(id, empresa, sistema){
        idExclusao = id;
        idEmpresa  = empresa;
        idSistema  = sistema;
        $('#myModal').modal('show');
    }

    function apagar(){
        $('#myModal').modal('hide');
        location.href = '{URL_APAGAR}/' + idExclusao + '/' + idEmpresa + '/' + idSistema;
    }

</script>