<header class="page-header">
 	<h2>Dados adicionais do contato- {ACAO}</h2>
 </header>
 
 
 <div class="panel panel-default">
 	<div class="panel-body">
 		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
 			<input type="hidden" id="hel_pk_seq_cco" name="hel_pk_seq_cco" value="{hel_pk_seq_cco}"/>
 			<input type="hidden" id="hel_seqcon_cco" name="hel_seqcon_cco" value="{hel_seqcon_cco}"/>				
 			
 			<div class="form-group">
 				<div class="{ERRO_HEL_TIPO_CCO}">
 					<label for="hel_tipo_sis" class="col-sm-1 control-label">Tipo</label>
 					<div class="col-sm-3">
 						<div class="col-sm-11">
 							<div class="radio-inline">
 								<label>
 									<input type="radio" id="hel_tipotelefone_cco" {hel_checktelefone_cco} onclick="mudarMascara()"
 										   name="hel_tipo_cco" value="0" />Telefone
 								</label>
 							</div>
 							<div class="radio-inline">
 								<label>
 									<input type="radio" id="hel_tipocelular_cco" {hel_checkcelular_cco} onclick="mudarMascara()"
 										   name="hel_tipo_cco" value="1"/>Celular
 								</label>
 							</div>
 						</div>
 					</div>
 				</div>
 			
 				<div class="{ERRO_HEL_TELEFONE_CCO}">
 					<label for="hel_lbtelefone_cco" id="hel_lbtelefone_cco" class="col-sm-1 control-label">{hel_lbtelefone_cco}</label>
 					<div class="col-sm-3">
 						<input type="text" class="form-control {hel_maskphone_cco}" id="hel_telefone_cco" name="hel_telefone_cco" 
 						       value="{hel_telefone_cco}" maxlength="14" autocomplete="off" autofocus/>
 					</div>
 				</div>
 				
 				<div class="{ERRO_HEL_RAMAL_CCO}">
	 				<label for="hel_ramal_cco" class="col-sm-1 control-label">Ramal</label>
	 					<div class="col-sm-2">
	 						<input type="text" class="form-control" id="hel_ramal_cco" name="hel_ramal_cco" {hel_disabledramal_cco}
	 						       value="{hel_ramal_cco}" maxlength="5" autocomplete="off" autofocus/>
	 					</div>
	 			</div>
 				
 			</div>
 				<label for="hel_skype_cco" class="col-sm-1 control-label">Skype</label>
 					<div class="col-sm-7">
 						<input type="text" class="form-control" id="hel_skype_cco" name="hel_skype_cco" 
 						       value="{hel_skype_cco}" maxlength="60" autocomplete="off" autofocus/>
 					</div>
 							
 			<div class="form-group">
 					<div class="col-sm-offset-1 col-sm-10">
 						<div class="checkbox">
 							<label >
 								<input type="checkbox"  id="hel_whatsapp_cco"name="hel_whatsapp_cco" value="1" 
 								{hel_checkedwhatsapp_cco} autocomplete="off" autofocus/>Whatsapp
 							</label>										      
 						</div>
 					</div>
 			</div>
 
 			<div class="form-group">
 				<div class="col-sm-offset-1 col-sm-11">
 					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
 		        	<a type="button" href="{CONSULTA_CONTATOS_CONTATO}" class="btn btn-default">Cancelar</a>
 				</div>
 			</div>
 		</form>
 		</div>
 	</div>
 </div>		
 
 <script type="text/javascript">
 
 	function mudarMascara(){
 		$("#hel_telefone_cco").unmask();
 			
 		if (document.getElementById('hel_tipotelefone_cco').checked){
 			 document.getElementById('hel_lbtelefone_cco').innerHTML = 'Telefone';
 			$("#hel_telefone_cco").mask("(dd) dddd-dddd");
 			document.getElementById('hel_ramal_cco').disabled 	 = false;
 		}else {
 			document.getElementById('hel_lbtelefone_cco').innerHTML = 'Celular';
 			$("#hel_telefone_cco").mask("(dd) 9dddd-dddd");
 			document.getElementById('hel_ramal_cco').disabled 	 = true;
 		}
 				
 	}
 
 </script> 