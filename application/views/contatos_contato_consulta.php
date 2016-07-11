<header class="page-header">
 	<h2>Consulta de dados adicionais - {NOME_CONTATO}</h2>
 </header>
 
 <div class="panel panel-default">
     <div class="panel-body">
         <div class="row">
             <div class="col-lg-12">
                 <div>
                     <a href="{NOVO_CONTATOS_CONTATO}" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Novo Dado</a>
                 </div>
                 </br>
                 <div class="table">
                     <table class="table table-striped table-bordered table-hover table-condensed" id="tb_dados_adicionais">
 						<thead>
                             <tr>
                             	<th>Tipo</th>
                                 <th>Telefone</th>
                                 <th>Whatsapp</th>
                                 <th class="coluna-acao" width="80"></th>
                                 <th class="coluna-acao" width="80"></th>
                             </tr>
                         </thead> 
                         <tbody>
                         	{BLC_DADOS}
 	                            <tr>
 	                            	<td class="vertical-center">{hel_tipo_cco}</td>
 	                                <td class="vertical-center">{hel_telefone_cco}</td>
 	                                <td class="vertical-center">{hel_whatsapp_cco}</td>
 	                                <td class="text-center"><a href="{EDITAR_CONTATOS_CONTATO}" class="btn btn-link btn-xs {dis_alterar}" title="Editar"><i class="glyphicon glyphicon-pencil"></i></a></td>
 	                                <td class="text-center"><a onclick="{APAGAR_CONTATOS_CONTATO}" class="btn btn-link btn-xs {dis_excluir}" title="Apagar"><i class="glyphicon glyphicon-trash"></i></a></td>
 	                            </tr>
                         	{/BLC_DADOS}
                         </tbody>                   
                     </table>
                 </div>
             </div>
         </div>
         <div class="text-right">
         	<a href="{VOLTAR_CONTATO}" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Contato</a>
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
                     <h4>Deseja realmente apagar este dado adicional ?</h4>
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
     var idContato = "";
 
     function abrirConfirmacao(id, idCon){
         idExclusao = id;
         idContato  = idCon;
         $('#myModal').modal('show');
     }
 
     function apagar(){
         $('#myModal').modal('hide');
         location.href = '{URL_APAGAR}/' + idExclusao + '/' + idContato;
     }
 
 </script> 