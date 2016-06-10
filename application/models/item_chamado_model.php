<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Chamado_Model extends CI_Model {
	
	public function get($hel_pk_seq_ios) {
		$this->db->from('heltbios');
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getItemChamado($hel_seqcha_ios) {
		$this->db->select(' 	   ios.hel_pk_seq_ios as hel_pk_seq_ios,
							       hel_seqcha_ios,
								   hel_desc_ser,
							       hel_desc_sis,
							       hel_nome_con,
							       ios.hel_horaricioencerrado_ios,
							       ios.hel_encerrado_ios,
							       (SELECT ios1.hel_seqose_ios FROM heltbios ios1 WHERE ios1.hel_pk_seq_ios = ios.hel_seqioscha_ios) as hel_seqose_ios
							FROM heltbios ios
							LEFT JOIN heltbser ON ios.hel_seqser_ios    = hel_pk_seq_ser
							LEFT JOIN heltbsis ON ios.hel_seqsis_ios    = hel_pk_seq_sis
							LEFT JOIN heltbcon ON ios.hel_seqcontec_ios = hel_pk_seq_con ', FALSE);
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
	
	public function getItemChamadoEncerrado($hel_seqcha_ios) {
		$this->db->select('hel_pk_seq_ios AS hel_pk_seq1_ios, substr(hel_complemento_ios, 1, 50) AS hel_complemento1_ios', FALSE);
		$this->db->from('heltbios');
		$this->db->where('hel_seqcha_ios = ', $hel_seqcha_ios, FALSE);
		$this->db->where('hel_tipo_ios = ', CHAMADO, FALSE);
		$this->db->where('hel_encerrado_ios = 0 ');
		return $this->db->get()->result();
	}
	
	public function getItemChamdoEncerrado2($hel_seqcha_ios) {
		$this->db->select('COUNT(hel_pk_seq_ios) as hel_pk_seq_ios ', FALSE);
		$this->db->from('heltbios');
		$this->db->where('hel_seqcha_ios = ', $hel_seqcha_ios, FALSE);
		$this->db->where('hel_tipo_ios = ', CHAMADO, FALSE);
		$this->db->where('hel_encerrado_ios = 1');
		return $this->db->count_all_results();
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