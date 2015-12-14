<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Model extends CI_Model {
	
	public function get($hel_pk_seq_men) {
		$this->db->from('heltbmen');
		$this->db->where('hel_pk_seq_men', $hel_pk_seq_men, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getMenu(){
		$this->db->from('heltbmen');
		$this->db->order_by("hel_desc_men", "asc");
		return $this->db->get()->result();
	}

	public function insert($menu) {
		$res = $this->db->insert('heltbmen', $menu);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($menu, $hel_pk_seq_men) {
		$this->db->where('hel_pk_seq_men', $hel_pk_seq_men, FALSE);
		$res = $this->db->update('heltbmen', $menu);
	
		if ($res) {
			return $hel_pk_seq_men;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_men) {
		$this->db->where('hel_pk_seq_men', $hel_pk_seq_men, FALSE);
		return $this->db->delete('heltbmen');
	}
		
}