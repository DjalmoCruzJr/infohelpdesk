<?php
	class Util {
		
		public function validarData($dat){
			
			$dat = str_replace("/", "", $dat);
			$dat = substr_replace($dat, "/",2,0);
			$dat = substr_replace($dat, "/",5,0);
			
			$dat = implode("", array_reverse(explode("/", trim($dat))));
			
			$dat = substr_replace($dat, "-",4,0);
			$dat = substr_replace($dat, "-",7,0);
			
			$data = explode("-",$dat); // fatia a string $dat em pedaços, usando - como referência
			$d = $data[2];
			$m = $data[1];
			$y = $data[0];
			
			return checkdate($m,$d,$y);
		}

		function inverteData($data){
			if(count(explode("/",$data)) > 1){
				return implode("-",array_reverse(explode("/",$data)));
			}elseif(count(explode("-",$data)) > 1){
				return implode("/",array_reverse(explode("-",$data)));
			}
			return $data;
		}


		public function inverteDataPadrao($data){
			if(count(explode("-",$data)) > 1){
				return implode("",array_reverse(explode("-",$data)));
			}
		}

		public function gravar_data_banco($dat){
			$dat = implode("", array_reverse(explode("/", trim($dat))));
			$dat = substr_replace($dat, "-",4,0);
			$dat = substr_replace($dat, "-",7,0);
			return $dat;
		}


		public function autorizacao($hel_tipo_tco){
			return $hel_tipo_tco <> 0 ? TRUE : FALSE;
		}
		
		public function permissao($tecnico, $session){
			return $tecnico <> $session ? TRUE : FALSE;
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
				if ( preg_match('/([01]\d|2[0-3]):[0-5]\d/', $hora) )  {
					return FALSE;
				} else {
					return TRUE;
				}
			}
		}
		
		public function formatarDateTime($date_time){
			$date = '';
			$hora = '';
			if (!empty($date_time)){
				$data = explode(" ", $date_time);
				$date = $data[0];
				$hora = $data[1];
					
				$date = implode( "/", array_reverse( explode ( "-", trim( $date ) ) ) );
			}			
			
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
		/*Função adicionada por Ulysses */
		function validar_senha($senha) {
			$msg = "";
			if (strlen($senha) >= 8){
				if (!preg_match('/(?=.*[0-9])/', $senha)){
					$msg = $msg." - A senha deve conter, pelo menos um número.\n";
				}

				if (!preg_match('/(?=.*[A-Z].*)/', $senha)){
					$msg = $msg." - A senha deve conter, pelo menos uma letra maiúscula.\n";
				}

				if (!preg_match('/(?=.*[^A-Za-z0-9].*)/', $senha)){
					$msg = $msg." - A senha deve conter, pelo menos um caracter especial.\n";
				}

			} else {
				$msg = $msg." - A senha deve ter oito ou mais caracteres.\n";
			}

			!empty($msg) ? $msg = $msg." - Exemplo : A1#bcdeg.\n" : '';

			return $msg;
		}


		function validarLogin($login){
			$msg = "";
			if (!preg_match_all('/[^A-Za-z0-9]/', $login)){
				$msg = $msg." - O login deve conter apenas números e letras.\n";
			}
			return $msg;
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