<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {
	
	public function buscarCEP($cep){
		$cep            = $cep;
		$chave          = CHAVE_ACESSO;
		$formato        = 'json';
		$siteaddressAPI = "http://www.devmedia.com.br/api/cep/service/?cep=".$cep."&chave=".$chave."&formato=".$formato;
	
		$data = $this->get_content($siteaddressAPI);
		echo $data;
	}
	
	private function get_content($URL){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		curl_exec($ch);
		$data = curl_exec($ch);
	
		curl_close($ch);
		return $data;
	}	

}
