<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Model extends CI_Model {
	
	public function get($hel_pk_seq_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_pk_seq_emp', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaCidade($hel_seqcid_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_seqcid_emp', $hel_seqcid_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresa() {
		$this->db->from('heltbemp');
		$this->db->join('heltbcid','hel_pk_seq_cid = hel_seqcid_emp','left');
		$this->db->order_by("hel_nomefantasia_emp", "asc");
		return $this->db->get()->result();
	}
	
	public function getEmpresaCadastrada($hel_cnpj_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_cnpj_emp', $hel_cnpj_emp, FALSE);
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
	
	
	public function insert($empresa) {
		$res = $this->db->insert('heltbemp', $empresa);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($empresa, $hel_pk_seq_emp) {
		$this->db->where('hel_pk_seq_emp', $hel_pk_seq_emp, FALSE);
		$res = $this->db->update('heltbemp', $empresa);
	
		if ($res) {
			return $hel_pk_seq_emp;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_emp) {
		$this->db->where('hel_pk_seq_emp', $hel_pk_seq_emp, FALSE);
		return $this->db->delete('heltbemp');
	}
		
}