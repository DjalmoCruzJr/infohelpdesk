<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Sistemas_Contratados_Model extends CI_Model {
	
	public function get($hel_pk_seq_msc) {
		$this->db->from('heltbmsc');
		$this->db->where('hel_pk_seq_msc', $hel_pk_seq_msc, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getMenuContratadosCadastrado($hel_pk_seq_msc, $hel_seqsco_msc, $hel_seqmen_msc) {
		$this->db->from('heltbmsc');
		$this->db->where('hel_pk_seq_msc <> ', $hel_pk_seq_msc, FALSE);
		$this->db->where('hel_seqsco_msc = ', $hel_seqsco_msc, FALSE);
		$this->db->where('hel_seqmen_msc = ', $hel_seqmen_msc, FALSE);
		return $this->db->get()->result();
	}
	
	public function getMenuContratados($hel_seqsco_msc) {
		$this->db->from('heltbmsc');
		$this->db->join('heltbmen', 'hel_pk_seq_men = hel_seqmen_msc', 'LEFT');
		$this->db->where('hel_seqsco_msc = ', $hel_seqsco_msc, FALSE);
		return $this->db->get()->result();
	}
	
	public function insert($menu_contratado) {
		$res = $this->db->insert('heltbmsc', $menu_contratado);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($menu_contratado, $hel_pk_seq_msc) {
		$this->db->where('hel_pk_seq_msc', $hel_pk_seq_msc, FALSE);
		$res = $this->db->update('heltbmsc', $menu_contratado);
	
		if ($res) {
			return $hel_pk_seq_msc;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_msc) {
		$this->db->where('hel_pk_seq_msc', $hel_pk_seq_msc, FALSE);
		return $this->db->delete('heltbmsc');
	}
}