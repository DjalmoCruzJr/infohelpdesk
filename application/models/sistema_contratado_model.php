<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema_Contratado_Model extends CI_Model {
	
	public function get($hel_pk_seq_sco) {
		$this->db->from('heltbsco');
		$this->db->where('hel_pk_seq_sco', $hel_pk_seq_sco, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaSistemaContratado($hel_pk_seq_emp) {
		$this->db->from('heltbsco');
		$this->db->where('hel_seqemp_sco', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getSistemaContratadoCadastrado($hel_pk_seq_sco, $hel_seqemp_sco, $hel_seqsis_sco) {
		$this->db->from('heltbsco');
		$this->db->where('hel_pk_seq_sco <> ', $hel_pk_seq_sco, FALSE);
		$this->db->where('hel_seqemp_sco', $hel_seqemp_sco, FALSE);
		$this->db->where('hel_seqsis_sco', $hel_seqsis_sco, FALSE);
		return $this->db->get()->result();
	}
	
	public function getSistemasContratados($hel_pk_seq_emp) {
		$this->db->from('heltbsco');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_sco','INNER');
		$this->db->where('hel_seqemp_sco', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getSistemaContratadoEmpresa($hel_pk_seq_emp) {
		$this->db->from('heltbsco');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_sco','INNER');
		$this->db->where('hel_seqemp_sco', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function insert($sistema_contratado) {
		$res = $this->db->insert('heltbsco', $sistema_contratado);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($sistema_contratado, $hel_pk_seq_sco) {
		$this->db->where('hel_pk_seq_sco', $hel_pk_seq_sco, FALSE);
		$res = $this->db->update('heltbsco', $sistema_contratado);
	
		if ($res) {
			return $hel_pk_seq_sco;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_sco) {
		$this->db->where('hel_pk_seq_sco', $hel_pk_seq_sco, FALSE);
		return $this->db->delete('heltbsco');
	}
		
}