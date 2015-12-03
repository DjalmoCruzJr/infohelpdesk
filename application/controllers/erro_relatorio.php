<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Erro_Relatorio extends CI_Controller {
	public function __construct() {
		parent::__construct();
				
		$this->layout = LAYOUT_DASHBOARD;
	}
	
	public function index() {
		$dados = array();
		$this->parser->parse('erro_relatorio', $dados);
	}
	
}