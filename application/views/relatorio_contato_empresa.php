<header class="page-header">
	<h2>Relatório de Contatos da Empresa</h2>
</header>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
               <div class="form-group ">
                	<div class="form-group ">
	                	<label for="ordenacao_relatorio" class="col-sm-2 ">Ordenar por</label>
							<div class="col-sm-9">
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
					<label for="contato_relatorio" class="col-sm-2 ">Filtro por Contato</label>
					<div>
				         <select id="contato_relatorio" class="js-example-basic-multiple form-control " style="width: 720px;" multiple="multiple" >
							{BLC_CONTATO_RELATORIO}
								<option value="{hel_pk_seq_con}" {dis_hel_con}>{hel_nome_con}</option>
							{/BLC_CONTATO_RELATORIO}
						</select>	                			
					</div>
				</div>
				<div class="form-group ">
					<label for="empresa_relatorio" class="col-sm-2 ">Filtro por Empresa</label>
					<div>
				         <select id="empresa_relatorio" class="js-example-basic-multiple form-control " style="width: 720px;" multiple="multiple" >
							{BLC_EMPRESA_RELATORIO}
								<option value="{hel_pk_seq_emp}" {dis_hel_emp}>{hel_nomefantasia_emp}</option>
							{/BLC_EMPRESA_RELATORIO}
						</select>	                			
					</div>
				</div>
                <div class="col-lg-offset-5">
                    <a onclick="visualizarRelatorio()" class="btn btn-primary "><i class="glyphicon glyphicon-print"></i> Visualizar</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	
    function visualizarRelatorio() {
        var contato_relatorio = document.getElementById('contato_relatorio');
        var empresa_relatorio = document.getElementById('empresa_relatorio');
        var orderBy           = "";

        var filtroContato	  = "";
        var separadorContato  = "";
        for (var i = 0; i < contato_relatorio.options.length; i++) {
      		if (contato_relatorio.options[i].selected){
      			filtroContato 	 = filtroContato + separadorContato + contato_relatorio.options[i].value;
      			separadorContato = ",";
        	}
      	} 

      	if (filtroContato == ""){
      		filtroContato = "0";
        }

        var filtroEmpresa	  = "";
        var separadorEmpresa  = "";
        for (var i = 0; i < empresa_relatorio.options.length; i++) {
      		if (empresa_relatorio.options[i].selected){
      			filtroEmpresa 	 = filtroEmpresa + separadorEmpresa + empresa_relatorio.options[i].value;
      			separadorEmpresa = ",";
        	}
      	} 

      	if (filtroEmpresa == ""){
      		filtroEmpresa = "0";
        }

        if (document.getElementById('ordenacao_codigo').checked){
        	orderBy = " ORDER BY hel_pk_seq_con";
        }else {
        	orderBy = " ORDER BY hel_nome_con";
        }
       
       	window.open('relatorio_contato_empresa/relatorio/' + filtroContato + '/' + filtroEmpresa + '/' + orderBy , '_blank');

    }
    
</script>