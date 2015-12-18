<?php
	class Util {
		
		public function validarData($dat){
			$data = explode("-",$dat); // fatia a string $dat em pedados, usando / como referência
			$d = $data[2];
			$m = $data[1];
			$y = $data[0];
			
			return checkdate($m,$d,$y);
		}
		
		public function autorizacao($hel_tipo_tco){
			return $hel_tipo_tco <> 0 ? TRUE : FALSE;
		}
		
		function to_upper($term, $tp) {
			switch($tp) {
						  //Converte uma string para minúsculas
				case '1': $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
						  break;
						  //Converte uma string para maiúsculas
				case '2': $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
						  break;
				case '3': $palavra = strtr(ucfirst($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
						  break;
						  //Converte para maiúsculas o primeiro caractere de cada palavra
				case '4': $palavra = strtr(ucwords($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
						  break;
			}
			return $palavra;
		}
		
	}
?>