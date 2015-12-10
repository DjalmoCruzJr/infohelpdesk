<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato_Model extends CI_Model {
	
	public function get($hel_pk_seq_con) {
		$this->db->from('heltbcon');
		$this->db->where('hel_pk_seq_con', $hel_pk_seq_cto, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getContato(){
		$this->db->from('heltbcon');
		$this->db->order_by("hel_nome_con", "asc");
		return $this->db->get()->result;
	}

	public function getContatoCadastrado($hel_pk_seq_tco) {
		$this->db->where('hel_seqtco_con', $hel_pk_seq_tco);
		$this->db->from('heltbcon');
		$this->db->join('heltbtco', 'hel_pk_seq_tco = hel_seqtco_con', 'LEFT');
		return $this->db->get()->result();
	}



}