<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cidade_Model extends CI_Model {
	
	public function get($hel_pk_seq_cid) {
		$this->db->from('heltbcid');
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		return $this->db->get()->first_row();
	}
	
	
	public function getCidade() {
		$this->db->from('heltbcid');
		$this->db->order_by("hel_nome_cid", "asc");
		return $this->db->get()->result();
	}
	
	public function insert($cidade) {
		$res = $this->db->insert('heltbcid', $cidade);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($cidade, $hel_pk_seq_cid) {
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		$res = $this->db->update('heltbcid', $cidade);
	
		if ($res) {
			return $hel_pk_seq_cid;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_cid) {
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		return $this->db->delete('heltbcid');
	}
		
}