$(document).ready(function() {
	
	/**
	 * Java Script para utilidades no projeto IRGabinete
	 */
	
	function getSiteURL() {
		"use strict";
		return $('#siteURL').val();
	}

//	$('#gab_cepresidencial_con').focusout(function () {
//		  var cep = $(this).val();
//		  alert(getSiteURL()+"contato/buscarCEP/" + cep);
//		//  var cep = $(this).val();
//		  $.ajax({
//		   url   : getSiteURL()+"contato/buscarCEP/" + cep,
//		   dataType : 'json',
//		   type  : 'post'
//	}).done(function (data) {
//	   alert('Retorno -> ' + data.logradouro); 
//	   $('#gab_enderecoresidencial_con').val(data.logradouro);
//	  });
//		  
//	});
	
});