<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Chamado_Model extends CI_Model {
	
	public function get($hel_pk_seq_ios) {
		$this->db->from('heltbios');
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getItemChamado($hel_seqcha_ios) {
		$this->db->from('heltbios');
		$this->db->join('heltbser','hel_pk_seq_ser = hel_seqser_ios','LEFT');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_ios','LEFT');
		$this->db->where('hel_seqcha_ios = ', $hel_seqcha_ios, FALSE);
		$this->db->where('hel_tipo_ios = ', CHAMADO, FALSE);
		return $this->db->get()->result();
	}
	
	public function getChamadoItem($hel_seqcha_ios) {
		$this->db->from('heltbios');
		$this->db->where('hel_seqcha_ios = ', $hel_seqcha_ios, FALSE);
		$this->db->where('hel_tipo_ios = ', CHAMADO, FALSE);
		$this->db->where('hel_encerrado_ios =', ABERTO , FALSE);
		return $this->db->get()->result();
	}
	
	public function insert($item_chamado) {
		$res = $this->db->insert('heltbios', $item_chamado);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($item_chamado, $hel_pk_seq_ios) {
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		$res = $this->db->update('heltbios', $item_chamado);
	
		if ($res) {
			return $hel_pk_seq_ios;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_ios) {
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		return $this->db->delete('heltbios');
	}		
}