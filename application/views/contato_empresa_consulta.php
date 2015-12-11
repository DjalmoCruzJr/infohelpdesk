<header class="page-header">
	<h2>Consulta de Contato - {HEL_NOME_CON}</h2>
</header>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_EMPRESA_CONTATO}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Nova Contato da empresa</a>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_contato_empresa">
						<thead>
                            <tr>
                                <th>Empresa</th>    
                                <th>Contato</th>
                                <th width="120">Tipo de Contato</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_nomefantasia_emp}</td>	    
	                                <td class="vertical-center">{hel_nome_con}</td>
	                                <td class="vertical-center">{hel_desc_tco}</td>
	                                <td class="text-center"><a href="{EDITAR_EMPRESA_CONTATO}" class="btn btn-link btn-xs" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_EMPRESA_CONTATO}" class="btn btn-link btn-xs" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
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
                    <h4>Deseja realmente apagar esta contado da empresa ?</h4>
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
	var idContato  = "";	

    function abrirConfirmacao(id, idC){
        idExclusao = id;
        idContato  = idC;
        $('#myModal').modal('show');
    }

    function apagar(){
        $('#myModal').modal('hide');
        location.href = '{URL_APAGAR}/' + idExclusao + '/' + idContato;
    }

</script>