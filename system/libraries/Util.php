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
		
		function validarDataHora($date, $format = 'Y-m-d H:i:s') {
			if (!empty($date) && $v_date = date_create_from_format($format, $date)) {
				$v_date = date_format($v_date, $format);
				return ($v_date && $v_date == $date);
			}
			return false;
		}
		
		public function formatarDateTime($date_time){
			$data = explode(" ", $date_time);
			$date = $data[0];
			$hora = $data[1];
			
			$date = implode( "/", array_reverse( explode ( "-", trim( $date ) ) ) );
			
			return $date." ".$hora;			
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