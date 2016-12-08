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
	
	public function getEmpresaAtivo() {
		$this->db->from('heltbemp');
		$this->db->where('hel_ativo_emp', EMPRESA_ATIVO, FALSE);
		$this->db->order_by("hel_nomefantasia_emp", "asc");
		return $this->db->get()->result();
	}
	
	public function getEmpresaCadastrada($hel_cpfcnpj_emp, $hel_pk_seq_emp, $hel_tipo_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_pk_seq_emp <> ', $hel_pk_seq_emp, FALSE);
		$this->db->where('hel_cpfcnpj_emp', $hel_cpfcnpj_emp, FALSE);
		$this->db->where('hel_tipo_emp', $hel_tipo_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresaNaoSistemaContratado() {
		$this->db->select(' * FROM heltbemp WHERE NOT EXISTS (SELECT * FROM heltbsco WHERE hel_seqemp_sco = hel_pk_seq_emp)  ', FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresaSegmento($hel_pk_seq_seg) {
		$this->db->from('heltbemp');
		$this->db->where('hel_seqseg_emp ', $hel_pk_seq_seg, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaSegmento2($hel_pk_seq_seg) {
		$this->db->from('heltbemp');
		$this->db->where('hel_seqseg_emp ', $hel_pk_seq_seg, FALSE);
		$this->db->where('hel_ativo_emp', EMPRESA_ATIVO, FALSE);
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