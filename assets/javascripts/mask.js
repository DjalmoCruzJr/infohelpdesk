$(document).ready(function() {
	
	/**
	 * 
	 */
	$.mask.definitions['9'] = '';
	$.mask.definitions['d'] = '[0-9]';
	
	$('.mask-cpf').mask('ddd.ddd.ddd-dd');
	$('.mask-cep').mask('ddddd-ddd');
	$('.mask-phone').mask('(dd) dddd-dddd');
	$('.mask-cel').mask('(dd) 9dddd-dddd');
	$('.mask-date').mask('dd/dd/dddd');
	$('.mask-day').mask('d?d');
	$('.mask-month').mask('d?d');
	$('.mask-cod-mun').mask('dddddd?d');
	
});


 