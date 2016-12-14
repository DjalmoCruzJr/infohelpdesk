<header class="page-header">
	<h2>Consulta dos Itens do Chamado Nº {hel_seqcha_ios}</h2>
</header>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    <a href="{NOVO_ITEM_CHAMADO}" class="btn btn-primary {hel_hiddenovoitemchamado_ios}"><i class="glyphicon glyphicon-plus"></i> Novo Item</a>
                </div>
                </br>
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_item_chamado">
						<thead>
                            <tr>
                                <th>Seq. item</th>                                
                                <th>Serviço</th>    
                                <th>Sistema</th>
                                <th>Horário Encerramento</th>
                                <th>Status</th>
                                <th>Técnico</th>
                                <th>O.S.</th>
                                <th class="coluna-acao" width="60" {hel_hiddenencerraritemchamado_ios}>Encerrar</th>
                                <th class="coluna-acao" width="60" >Solução</th>
                                <th class="coluna-acao" width="80"></th>
                                <th class="coluna-acao" width="80"></th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
                                    <td class="vertical-center">{hel_pk_seq_ios}</td>                                     
	                                <td class="vertical-center">{hel_desc_ser}</td>	    
	                                <td class="vertical-center">{hel_desc_sis}</td>
	                                <td class="vertical-center">{hel_horaricioencerrado_ios}</td>
	                                <td class="vertical-center">{hel_encerrado_ios}</td>
	                                <td class="vertical-center">{hel_nometec_con}</td>
	                                <td class="vertical-center">{hel_seqose_ios}</td>
	                                <td class="text-center"><a href="{ENCERRAR_ITEM_CHAMADO}" class="btn btn-link btn-xs" title="Encerrar"><i class="glyphicon glyphicon-ok"></i></a></td>
	                                <td class="text-center"><a href="{SOLUCAO}" class="btn btn-link btn-xs {hel_disabledsolucao_ios}" title="Solução"><i class="glyphicon glyphicon-info-sign"></i></a></td>
	                                <td class="text-center"><a href="{EDITAR_ITEM_CHAMADO}" class="btn btn-link btn-xs" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
	                                <td class="text-center"><a onclick="{APAGAR_ITEM_CHAMADO}" class="btn btn-link btn-xs" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
            <div class="text-right">
            <a href="{VOLTAR_CHAMADO}" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Chamado</a>
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
                    <h4>Deseja realmente apagar este item do chamado ?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="apagar()">Sim</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                </div>
        </div>
    </div>
</div>


<script type="text/javascript">

	var idExclusao	= "";
	var idChamado 	= "";	

    function abrirConfirmacao(id, idcha){
        idExclusao = id;
        idChamado  = idcha;
        $('#myModal').modal('show');
    }

    function apagar(){
        $('#myModal').modal('hide');
        location.href = '{URL_APAGAR}/' + idExclusao + '/' + idChamado;
    }
    
</script>