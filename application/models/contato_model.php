<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contato_Model extends CI_Model {

	public function get($hel_pk_seq_con) {
		$this->db->from('heltbcon');
		$this->db->where('hel_pk_seq_con', $hel_pk_seq_con, FALSE);
		return $this->db->get()->first_row();
	}

	public function getContatoCadastrado($hel_pk_seq_tco) {
		$this->db->where('hel_seqtco_con', $hel_pk_seq_tco);
		$this->db->from('heltbcon');
		$this->db->join('heltbtco', 'hel_pk_seq_tco = hel_seqtco_con', 'LEFT');
		return $this->db->get()->result();
	}

		
	public function getContato() {
		$this->db->from('heltbcon');
		$this->db->join('heltbtco', 'hel_pk_seq_tco = hel_seqtco_con', 'LEFT');
		$this->db->order_by("hel_nome_con", "asc");
		return $this->db->get()->result();
	}
	
	public function insert($contato) {
		$res = $this->db->insert('heltbcon', $contato);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($contato, $hel_pk_seq_con) {
		$this->db->where('hel_pk_seq_con', $hel_pk_seq_con, FALSE);
		$res = $this->db->update('heltbcon', $contato);
	
		if ($res) {
			return $hel_pk_seq_con;
		} else {
			return FALSE;
		}
	}
	
	public function getLoginCadastro($hel_pk_seq_con, $hel_login_con) {
		$this->db->from('heltbcon');
		$this->db->where('hel_pk_seq_con <> ', $hel_pk_seq_con, FALSE);
		$this->db->where('hel_login_con = ', $hel_login_con);
		return $this->db->get()->first_row();
	}

	public function getContatoLogin($hel_login_con, $hel_senha_con) {
		$this->db->from('heltbcon');
		$this->db->where('hel_login_con = ', $hel_login_con);
		$this->db->where('hel_senha_con = ', $hel_senha_con);
		return $this->db->get()->first_row();
	}
}