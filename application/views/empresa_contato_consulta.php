<header class="page-header">
	<h2>Contatos - {HEL_NOMEFANTASIA_EMP}</h2>
</header>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="table">
                    <table class="table table-striped table-bordered table-hover table-condensed" id="tb_empresa_contato">
						<thead>
                            <tr>
                                <th>Nome</th>    
                                <th>Tipo Contato</th>
                                <th>Ativo</th>
                            </tr>
                        </thead> 
                        <tbody>
                        	{BLC_DADOS}
	                            <tr>
	                                <td class="vertical-center">{hel_nome_con}</td>	    
	                                <td class="vertical-center">{hel_desc_tco}</td>
	                                <td class="vertical-center">{hel_ativo_con}</td>	                                
	                            </tr>
                        	{/BLC_DADOS}
                        </tbody>                   
                    </table>
                </div>
            </div>
        </div>
     <div class="text-right">
       	<a href="{VOLTAR_EMPRESA}" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Voltar Empresa</a>
    </div>   
    </div>
</div>