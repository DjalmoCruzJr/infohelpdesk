<header class="page-header">
	<h2>Empresa - {ACAO}</h2>
</header>


<div class="panel panel-default">
	<div class="panel-body">
		<form action="{ACAO_FORM}" method="post" class="form-horizontal">
			<input type="hidden" id="hel_pk_seq_emp" name="hel_pk_seq_emp" value="{hel_pk_seq_emp}"/>				
			<div class="form-group">
				<div class="{ERRO_HEL_EMPRESA_EMP}">
					<label for="hel_empresa_emp" class="col-sm-1 control-label">Empresa</label>
					<div class="col-sm-1">
						<input type="text" class="form-control mask-empresa" id="hel_empresa_emp" name="hel_empresa_emp" 
						       value="{hel_empresa_emp}" maxlength="2" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_FILIAL_EMP}">
					<label for="hel_filial_emp" class="col-sm-1 control-label">Filial</label>
					<div class="col-sm-1">
						<input type="text" class="form-control mask-empresa" id="hel_filial_emp" name="hel_filial_emp" 
						       value="{hel_filial_emp}" maxlength="2" autocomplete="off" autofocus/>
					</div>
				</div>
				<div class="{ERRO_HEL_CNPJ_EMP}">
					<label for="hel_cnpj_emp" class="col-sm-1 control-label">CNPJ</label>
					<div class="col-sm-3">
						<input type="text" class="form-control mask-cnpj" id="hel_cnpj_emp" name="hel_cnpj_emp" 
						       value="{hel_cnpj_emp}" maxlength="14" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_RAZAOSOCIAL_EMP}">
					<label for="hel_razaosocial_emp" class="col-sm-1 control-label">Razão Social</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_razaosocial_emp" name="hel_razaosocial_emp" 
						       value="{hel_razaosocial_emp}" maxlength="100" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="{ERRO_HEL_NOMEFANTASIA_EMP}">
					<label for="hel_nomefantasia_emp" class="col-sm-1 control-label">Nome Fantasia</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" id="hel_nomefantasia_emp" name="hel_nomefantasia_emp" 
						       value="{hel_nomefantasia_emp}" maxlength="100" autocomplete="off" autofocus/>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="{ERRO_HEL_CEP_EMP}">
					<label for="hel_cep_emp" class="col-sm-1 control-label">CEP</label>
					<div class="col-sm-2">
						<input type="text" class="form-control mask-cep" id="hel_cep_emp" name="hel_cep_emp" onblur="carregarCep()" 
						       value="{hel_cep_emp}" maxlength="8" autocomplete="off" autofocus/>
					</div>
				</div>
				<label for="hel_endereco_emp" class="col-sm-1 control-label">Endereço</label>
				<div class="col-sm-5">
					<input type="text" class="form-control" id="hel_endereco_emp" name="hel_endereco_emp" 
					       value="{hel_endereco_emp}" maxlength="100" autocomplete="off" autofocus/>
				</div>
				<label for="hel_numero_emp" class="col-sm-1 control-label">Número</label>
				<div class="col-sm-2">
					<input type="text" class="form-control" id="hel_numero_emp" name="hel_numero_emp" 
					       value="{hel_numero_emp}" maxlength="10" autocomplete="off" autofocus/>
				</div>
			</div>			
			<div class="form-group">
				<div class="{ERRO_HEL_SEQCID_EMP}">
					<label for="hel_seqcid_emp" class="col-sm-1 control-label">Cidade</label>
					<div class="col-sm-4">
							<select class="form-control" id="hel_seqcid_emp" name="hel_seqcid_emp" autofocus="autofocus">
								<option value="">Selecione...</option>
									{BLC_CIDADE}
								    	<option value="{hel_pk_seq_cid}" {sel_hel_seqcid_emp} title="{hel_codmun_cid}">{hel_nome_cid}</option>
								    {/BLC_CIDADE}
							</select>   
					</div>
				</div>
			<label for="hel_bairro_emp" class="col-lg-1 control-label">Bairro</label>
				<div class="col-lg-6">
					<input type="text" class="form-control" id="hel_bairro_emp"  name="hel_bairro_emp"
						   value="{hel_bairro_emp}" maxlength="60" autocomplete="off" autofocus/>
				</div>
			</div>
			
			<div class="form-group">
				<div class="{ERRO_HEL_ATIVO_EMP}">
					<div class="col-sm-offset-1 col-sm-10">
						<div class="checkbox">
							<label >
								<input type="checkbox"  id="hel_ativo_emp"name="hel_ativo_emp" value="1" 
								{hel_checkedativo_emp} autocomplete="off" autofocus/>Ativo
							</label>										
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-1 col-sm-11">
					<button type="submit" name="salvar_cidade" class="btn btn-primary"> <i class="glyphicon glyphicon-ok"></i> Salvar</button>
		        	<a type="button" href="{CONSULTA_EMPRESA}" class="btn btn-default">Cancelar</a>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		

<script type="text/javascript">
	var cidade_empresa = document.getElementById('hel_seqcid_emp');

	function carregarCep(){
		console.log('Passou Aqui');
		var cep = document.getElementById('hel_cep_emp').value;
			
	 	$.ajax({
	 		url:     '{URL_BUSCAR_CEP}/' + cep,
	    	type:    "get",
	    	dataType:"json", 	
	    	success: function( data ){	    		   	
	    		$('#hel_endereco_emp').val(data.logradouro);
	    		$('#hel_bairro_emp').val(data.bairro);
	    		for (var i = 0; i < cidade_empresa.options.length; i++) {
	          		if (cidade_empresa.options[i].title == data.codigomunicipio){
	          			cidade_empresa.options[i].selected = true;
	            	}
	          	}
	    		
	    	}
		});
	}
</script>