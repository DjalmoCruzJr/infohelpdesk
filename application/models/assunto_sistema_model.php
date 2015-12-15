<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class assunto_sistema_model extends CI_Model {
	
	public function get($hel_pk_seq_asu) {
		$this->db->from('heltbasu');
		$this->db->where('hel_pk_seq_asu', $hel_pk_seq_asu, FALSE);
		return $this->db->get()->first_row();
	}
	
	// 	Por favor não apague esse métado por que ele está sendo usado por cadastro de sistema.
	public function getAssuntoSistema($hel_pk_seq_sis) {
		$this->db->from('heltbasu');
		$this->db->where('hel_seqsis_asu', $hel_pk_seq_sis, FALSE);
		return $this->db->get()->first_row();
	}
	
// 	public function getEmpresaAssuntoSistema($hel_seqcid_asu) {
// 		$this->db->from('heltbasu');
// 		$this->db->where('hel_seqsis_asu', $hel_seqcid_asu, FALSE);
// 		return $this->db->get()->result();
// 	}
	
// 	public function getAssuntoSistema($hel_pk_seq_sis) {
// 		$this->db->from('heltbasu');
// 		$this->db->join('heltbasu','hel_pk_seq_asu = hel_seq_emp','left');
// 		$this->db->order_by("hel_nomefantasia_emp", "asc");
// 		return $this->db->get()->result();
// 	}
	
	public function getEmpresaCadastrada($hel_cnpj_emp, $hel_pk_seq_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_pk_seq_emp <> ', $hel_pk_seq_emp, FALSE);
		$this->db->where('hel_cnpj_emp', $hel_cnpj_emp, FALSE);
		return $this->db->get()->result();
	}
	
// 	public function getAssuntoSistema($hel_pk_seq_sis) {
// 		$this->db->where('hel_seqsis_asu', $hel_pk_seq_sis);
// 		$this->db->from('heltbasu');
// 		$this->db->join('heltbasu', 'hel_pk_seq_sis = hel_seqsis_asu', 'LEFT');
// 		return $this->db->get()->result();
// 	}
	
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