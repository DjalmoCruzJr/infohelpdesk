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
		
		public function validar_cnpj_cpf($cnpjcf, $tipo){
			$retorno = FALSE;
			
			switch ($tipo){
				case 0 : $retorno = $this->validar_cpf($cnpjcf);
				         break;
				case 1: $retorno = $this->validar_cnpj($cnpjcf);
				         break;
				default : $retorno = TRUE;
					      break;						          
			}
			
			return $retorno; 
		
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
		
		function validar_cpf($cpf){
			// determina um valor inicial para o digito $d1 e $d2
	        // pra manter o respeito ;)
	        $d1 = 0;
	        $d2 = 0;
	        // remove tudo que não seja número
	        $cpf = preg_replace("/[^0-9]/", "", $cpf);
	        // lista de cpf inválidos que serão ignorados
	        $ignore_list = array(
	            '00000000000',
	            '01234567890',
	            '11111111111',
	            '22222222222',
	            '33333333333',
	            '44444444444',
	            '55555555555',
	            '66666666666',
	            '77777777777',
	            '88888888888',
	            '99999999999'
	        );
	        // se o tamanho da string for dirente de 11 ou estiver
	        // na lista de cpf ignorados já retorna false
	        if (strlen($cpf) != 11 || in_array($cpf, $ignore_list)) {
	            return false;
	        } else {
	            // inicia o processo para achar o primeiro
	            // número verificador usando os primeiros 9 dígitos
	            for ($i = 0; $i < 9; $i++) {
	                // inicialmente $d1 vale zero e é somando.
	                // O loop passa por todos os 9 dígitos iniciais
	                $d1 += $cpf[$i] * (10 - $i);
	            }
	            // acha o resto da divisão da soma acima por 11
	            $r1 = $d1 % 11;
	            // se $r1 maior que 1 retorna 11 menos $r1 se não
	            // retona o valor zero para $d1
	            $d1 = ($r1 > 1) ? (11 - $r1) : 0;
	            // inicia o processo para achar o segundo
	            // número verificador usando os primeiros 9 dígitos
	            for ($i = 0; $i < 9; $i++) {
	                // inicialmente $d2 vale zero e é somando.
	                // O loop passa por todos os 9 dígitos iniciais
	                $d2 += $cpf[$i] * (11 - $i);
	            }
	            // $r2 será o resto da soma do cpf mais $d1 vezes 2
	            // dividido por 11
	            $r2 = ($d2 + ($d1 * 2)) % 11;
	            // se $r2 mair que 1 retorna 11 menos $r2 se não
	            // retorna o valor zeroa para $d2
	            $d2 = ($r2 > 1) ? (11 - $r2) : 0;
	            // retona true se os dois últimos dígitos do cpf
	            // forem igual a concatenação de $d1 e $d2 e se não
	            // deve retornar false.
	            return (substr($cpf, -2) == $d1 . $d2) ? true : false;
	        }
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