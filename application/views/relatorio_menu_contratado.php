<header class="page-header">
	<h2>Relatório de Menu Contratao</h2>
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
				<div class="form-group ">
					<label for="sistema_relatorio" class="col-sm-2 ">Filtro por Sistema</label>
					<div>
				         <select id="sistema_relatorio" class="js-example-basic-multiple form-control " style="width: 720px;" multiple="multiple" >
							{BLC_SISTEMA_RELATORIO}
								<option value="{hel_pk_seq_sis}" {dis_hel_sis}>{hel_codigo_sis}</option>
							{/BLC_SISTEMA_RELATORIO}
						</select>	                			
					</div>
				</div>
				<div class="form-group ">
					<label for="menu_relatorio" class="col-sm-2 ">Filtro por Menu</label>
					<div>
				         <select id="menu_relatorio" class="js-example-basic-multiple form-control " style="width: 720px;" multiple="multiple" >
							{BLC_MENU_RELATORIO}
								<option value="{hel_pk_seq_men}" {dis_hel_men}>{hel_desc_men}</option>
							{/BLC_MENU_RELATORIO}
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
        var empresa_relatorio = document.getElementById('empresa_relatorio');
        var sistema_relatorio = document.getElementById('sistema_relatorio');
        var menu_relatorio 	  = document.getElementById('menu_relatorio');
        var orderBy           = "";

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

        var filtroSistema	  = "";
        var separadorSistema  = "";
        for (var i = 0; i < sistema_relatorio.options.length; i++) {
      		if (sistema_relatorio.options[i].selected){
      			filtroSistema 	 = filtroSistema + separadorSistema + sistema_relatorio.options[i].value;
      			separadorSistema = ",";
        	}
      	} 

      	if (filtroSistema == ""){
      		filtroSistema = "0";
        }

      	var filtroMenu	  = "";
        var separadorMenu = "";
        for (var i = 0; i < menu_relatorio.options.length; i++) {
      		if (menu_relatorio.options[i].selected){
      			filtroMenu 	  = filtroMenu + separadorMenu + menu_relatorio.options[i].value;
      			separadorMenu = ",";
        	}
      	} 

      	if (filtroMenu == ""){
      		filtroMenu = "0";
        }

        if (document.getElementById('ordenacao_codigo').checked){
        	orderBy = " ORDER BY hel_pk_seq_emp";
        }else {
        	orderBy = " ORDER BY hel_nomefantasia_emp";
        }
       
       	window.open('relatorio_menu_contratado/relatorio/' + filtroEmpresa + '/' + filtroSistema + '/'  + filtroMenu + '/' + orderBy , '_blank');

    }
    
</script>