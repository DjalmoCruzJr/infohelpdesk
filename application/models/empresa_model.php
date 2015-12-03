<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Model extends CI_Model {
	
	public function get($hel_pk_seq_cid) {
		$this->db->from('heltbcid');
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaCidade($hel_seqcid_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_seqcid_emp', $hel_seqcid_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getCidade() {
		$this->db->from('heltbcid');
		$this->db->order_by("hel_nome_cid", "asc");
		return $this->db->get()->result();
	}
	
	public function getServicoCadastrado($gab_pk_seq_cid) {
		$this->db->where('gab_seqcid_sec', $gab_pk_seq_cid);
		$this->db->from('gabtbsec');
		$this->db->join('gabtbcid', 'gab_pk_seq_cid = gab_seqcid_sec', 'LEFT');
		return $this->db->get()->result();
	}
	
	public function getComunicacaoCadastrada($gab_pk_seq_cid) {
		$this->db->where('gab_seqcid_coc', $gab_pk_seq_cid);
		$this->db->from('gabtbcoc');
		$this->db->join('gabtbcid', 'gab_pk_seq_cid = gab_seqcid_coc', 'LEFT');
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
	
	public function delete($gab_pk_seq_cid) {
		$this->db->where('gab_pk_seq_cid', $gab_pk_seq_cid, FALSE);
		return $this->db->delete('gabtbcid');
	}
		
}