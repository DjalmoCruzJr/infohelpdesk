<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipo_Contato_Model extends CI_Model {
	
	public function get($hel_pk_seq_tco) {
		$this->db->from('heltbtco');
		$this->db->where('hel_pk_seq_tco', $hel_pk_seq_tco, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getTipoContato(){
		$this->db->from('heltbtco');
		$this->db->order_by("hel_desc_tco", "asc");
		return $this->db->get()->result();
	}
	
	public function getEhTecnico($hel_seqtco_con){
		$this->db->from('heltbtco');
		$this->db->where('hel_pk_seq_tco', $hel_seqtco_con, FALSE);
		$this->db->where('hel_tipo_tco', TECNICO, FALSE);
		return $this->db->get()->result();
	}

	public function insert($tipo_contato) {
		$res = $this->db->insert('heltbtco', $tipo_contato);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($tipo_contato, $hel_pk_seq_tco) {
		$this->db->where('hel_pk_seq_tco', $hel_pk_seq_tco, FALSE);
		$res = $this->db->update('heltbtco', $tipo_contato);
	
		if ($res) {
			return $hel_pk_seq_tco;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_tco) {
		$this->db->where('hel_pk_seq_tco', $hel_pk_seq_tco, FALSE);
		return $this->db->delete('heltbtco');
	}
		
}