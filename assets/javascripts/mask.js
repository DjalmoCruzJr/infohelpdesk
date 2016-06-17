$(document).ready(function() {
	
	/**
	 * 
	 */
	$.mask.definitions['9'] = '';
	$.mask.definitions['d'] = '[0-9]';
	
	$('.mask-cnpj').mask('dd.ddd.ddd/dddd-dd');
	$('.mask-cpf').mask('ddd.ddd.ddd-dd');
	$('.mask-cei').mask('ddddddddddd');
	$('.mask-cep').mask('ddddd-ddd');
	$('.mask-phone').mask('(dd) dddd-dddd');
	$('.mask-cel').mask('(dd) 9dddd-dddd');
	$('.mask-date').mask('dd/dd/dddd');
	$('.mask-day').mask('d?d');
	$('.mask-km').mask('?ddddddddddd');
	$('.mask-month').mask('d?d');
	$('.mask-empresa').mask('d?d');
	$('.mask-cod-mun').mask('dddddd?d');
	$('.mask-time').mask('dd:dd');
	
});


 