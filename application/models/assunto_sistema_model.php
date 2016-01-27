<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class assunto_sistema_model extends CI_Model {
	
	public function get($hel_pk_seq_asu) {
		$this->db->from('heltbasu');
		$this->db->where('hel_pk_seq_asu', $hel_pk_seq_asu, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getAssunto($hel_seqsis_asu) {
		$this->db->from('heltbasu');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_asu','LEFT');
		$this->db->where('hel_seqsis_asu', $hel_seqsis_asu, FALSE);
		return $this->db->get()->result();
	}
	
	public function getAssuntoSistema($hel_pk_seq_sis) {
		$this->db->from('heltbasu');
		$this->db->where('hel_seqsis_asu', $hel_pk_seq_sis, FALSE);
		return $this->db->get()->first_row();
	}
	
	
	public function getEmpresaCadastrada($hel_cnpj_emp, $hel_pk_seq_emp) {
		$this->db->from('heltbemp');
		$this->db->where('hel_pk_seq_emp <> ', $hel_pk_seq_emp, FALSE);
		$this->db->where('hel_cnpj_emp', $hel_cnpj_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function insert($assunto) {
		$res = $this->db->insert('heltbasu', $assunto);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($assunto, $hel_pk_seq_asu) {
		$this->db->where('hel_pk_seq_asu', $hel_pk_seq_asu, FALSE);
		$res = $this->db->update('heltbasu', $assunto);
	
		if ($res) {
			return $hel_pk_seq_asu;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_asu) {
		$this->db->where('hel_pk_seq_asu', $hel_pk_seq_asu, FALSE);
		return $this->db->delete('heltbasu');
	}
		
}