<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Segmento_Model extends CI_Model {
	
	public function get($hel_pk_seq_seg) {
		$this->db->from('heltbseg');
		$this->db->where('hel_pk_seq_seg', $hel_pk_seq_seg, FALSE);
		return $this->db->get()->first_row();
	}
	
	
	public function getSegmento() {
		$this->db->from('heltbseg');
		return $this->db->get()->result();
	}
	
	public function insert($segmento) {
		$res = $this->db->insert('heltbseg', $segmento);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($segmento, $hel_pk_seq_seg) {
		$this->db->where('hel_pk_seq_seg', $hel_pk_seq_seg, FALSE);
		$res = $this->db->update('heltbseg', $segmento);
	
		if ($res) {
			return $hel_pk_seq_seg;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_seg) {
		$this->db->where('hel_pk_seq_seg', $hel_pk_seq_seg, FALSE);
		return $this->db->delete('heltbseg');
	}
		
}