<?php
	class Util {
		
		public function validarData($dat){
			
			$dat = str_replace("/", "", $dat);
			$dat = substr_replace($dat, "/",2,0);
			$dat = substr_replace($dat, "/",5,0);
			
			$dat = implode("", array_reverse(explode("/", trim($dat))));
			
			$dat = substr_replace($dat, "-",4,0);
			$dat = substr_replace($dat, "-",7,0);
			
			$data = explode("-",$dat); // fatia a string $dat em pedaços, usando / como referência
			$d = $data[2];
			$m = $data[1];
			$y = $data[0];
			
			return checkdate($m,$d,$y);
		}
		
		public function autorizacao($hel_tipo_tco){
			return $hel_tipo_tco <> 0 ? TRUE : FALSE;
		}
		
		public function validar_cnpj($cnpj){
			$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
			// Valida tamanho
			if (strlen($cnpj) != 14)
				return false;
			// Valida primeiro dígito verificador
			for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++){
				$soma += $cnpj{$i} * $j;
				$j = ($j == 2) ? 9 : $j - 1;
			}
			$resto = $soma % 11;
			if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
				return false;
			// Valida segundo dígito verificador
			for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++){
				$soma += $cnpj{$i} * $j;
				$j = ($j == 2) ? 9 : $j - 1;
			}
			$resto = $soma % 11;
			return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
		}
		
		public function validarHora($hora) {
			if ( !empty($hora) ) {
				if ( preg_match('/([01]\d|2[0-3]):[0-5]\d:[0-5]\d/', $hora) )  {
					return FALSE;
				} else {
					return TRUE;
				}
			}
		}
		
		public function formatarDateTime($date_time){
			$data = explode(" ", $date_time);
			$date = $data[0];
			$hora = $data[1];
			
			$date = implode( "/", array_reverse( explode ( "-", trim( $date ) ) ) );
			
			return $date." ".$hora;			
		}
		
		public function gravarBancoDateTime($date_time, $banco = TRUE){
			
			if ($banco){
				$date_time = implode("", array_reverse(explode("/", trim($date_time))));
				
				$date_time = substr_replace($date_time, "-",4,0);
				$date_time = substr_replace($date_time, "-",7,0);
			} else {
				$date_time = implode("/", array_reverse( explode("-", trim($date_time))));
			}			
				
			return $date;
		}
		
		function validar_senha($senha) {
			$tamanho = strlen($senha);
			if ($tamanho >= 8){
				return TRUE;	
			}else{
				return FALSE;
			}
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