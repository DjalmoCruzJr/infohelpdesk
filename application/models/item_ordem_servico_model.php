<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Ordem_Servico_Model extends CI_Model {
	
	public function get($hel_pk_seq_ose) {
		$this->db->from('heltbose');
		$this->db->where('hel_pk_seq_ose', $hel_pk_seq_ose, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaOrdemServico($hel_pk_seq_emp) {
		$this->db->from('heltbose');
		$this->db->where('hel_seqemp_ose', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getContatoEmpresaOrdemServico($hel_pk_seq_exc) {
		$this->db->from('heltbose');
		$this->db->where('hel_seqexc_ose', $hel_pk_seq_exc, FALSE);
		return $this->db->get()->result();
	}
	
	public function getOrdemServicoItemOrdemServico($hel_pk_seq_ose) {
		$this->db->from('heltbios');
		$this->db->where('hel_seqose_ios', $hel_pk_seq_ose, FALSE);
		$this->db->where('hel_seqcha_ios IS NOT NULL');
		return $this->db->get()->result();
	}
	
	public function getOrdemServico() {
		$this->db->from('heltbose');
		$this->db->join('heltbexc','hel_pk_seq_exc = hel_seqexc_ose','LEFT');
		$this->db->join('heltbemp','hel_pk_seq_emp = hel_seqemp_exc','LEFT');
		$this->db->join('heltbcon','hel_pk_seq_con = hel_seqcontec_ose','LEFT');
		return $this->db->get()->result();
	}
	
	public function getEmpresaCadastrada($hel_cnpj_emp, $hel_pk_seq_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_pk_seq_emp <> ', $hel_pk_seq_emp, FALSE);
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
	
	
	public function insert($ordem_servico) {
		$res = $this->db->insert('heltbose', $ordem_servico);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($ordem_servico, $hel_pk_seq_ose) {
		$this->db->where('hel_pk_seq_ose', $hel_pk_seq_ose, FALSE);
		$res = $this->db->update('heltbose', $ordem_servico);
	
		if ($res) {
			return $hel_pk_seq_ose;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_ose) {
		$this->db->where('hel_pk_seq_ose', $hel_pk_seq_ose, FALSE);
		return $this->db->delete('heltbose');
	}
		
}