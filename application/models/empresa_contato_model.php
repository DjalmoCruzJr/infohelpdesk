<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Contato_Model extends CI_Model {
	
	public function get($hel_pk_seq_exc) {
		$this->db->from('heltbexc');
		$this->db->where('hel_pk_seq_exc', $hel_pk_seq_exc, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaContato($hel_pk_seq_emp) {
		$this->db->from('heltbexc');
		$this->db->where('hel_seqemp_exc', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getContatoEmpresaCadastro($hel_pk_seq_exc, $hel_seqcon_exc, $hel_seqemp_exc) {
		$this->db->from('heltbexc');
		$this->db->where('hel_pk_seq_exc <>', $hel_pk_seq_exc, FALSE);
		$this->db->where('hel_seqcon_exc = ', $hel_seqcon_exc, FALSE);
		$this->db->where('hel_seqemp_exc = ', $hel_seqemp_exc, FALSE);
		return $this->db->get()->result();
	}
	
	public function getContatoEmpresaContato($hel_pk_seq_con) {
		$this->db->from('heltbexc');
		$this->db->where('hel_seqcon_exc', $hel_pk_seq_con, FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresaContato2($hel_seqemp_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbemp', 'hel_seqemp_exc = hel_pk_seq_emp', 'LEFT');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con', 'LEFT');
		$this->db->where('hel_seqemp_exc', $hel_seqemp_exc, FALSE);
		$this->db->where('hel_ativo_con', CONTATO_ATIVO);
		return $this->db->get()->result();
	}
	
	public function getEmpresaContato4($hel_seqemp_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con', 'LEFT');
		$this->db->join('heltbtco', 'hel_seqtco_con = hel_pk_seq_tco', 'LEFT');
		$this->db->where('hel_seqemp_exc', $hel_seqemp_exc, FALSE);
		$this->db->where('hel_ativo_con', CONTATO_ATIVO);
		return $this->db->get()->result();
	}
	
	public function getEmpresaContatos($hel_seqemp_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con', 'LEFT');
		$this->db->where('hel_seqemp_exc', $hel_seqemp_exc, FALSE);
		$this->db->where('hel_ativo_con', CONTATO_ATIVO);
		return $this->db->get()->result();
	}

	public function getEmpresaContatoRelatorio($hel_seqemp_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbemp', 'hel_seqemp_exc = hel_pk_seq_emp', 'LEFT');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con', 'LEFT');
		$this->db->where_in('hel_seqemp_exc', $hel_seqemp_exc);
		$this->db->where('hel_ativo_con', CONTATO_ATIVO);
		$this->db->group_by('hel_pk_seq_con');
		return $this->db->get()->result();
	}
	
	public function getEmpresaContatoRelatorio2($hel_seqcon_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbemp', 'hel_seqemp_exc = hel_pk_seq_emp', 'LEFT');
		$this->db->where('hel_seqcon_exc', $hel_seqcon_exc);
		return $this->db->get()->result();
	}
	
	public function getContatoEmpresa($hel_seqcon_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbemp', 'hel_seqemp_exc = hel_pk_seq_emp', 'LEFT');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con', 'LEFT');
		$this->db->join('heltbtco', 'hel_seqtco_con = hel_pk_seq_tco', 'LEFT');
		$this->db->where('hel_seqcon_exc', $hel_seqcon_exc, FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresaContato3($hel_seqcon_exc,$hel_seqemp_exc) {
		$this->db->select('hel_pk_seq_exc');
		$this->db->from('heltbexc');
		$this->db->where('hel_seqcon_exc', $hel_seqcon_exc, FALSE);
		$this->db->where('hel_seqemp_exc', $hel_seqemp_exc, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaContatoAtivo($hel_seqcon_exc) {
		$this->db->from('heltbexc');
		$this->db->join('heltbemp', 'hel_seqemp_exc = hel_pk_seq_emp', 'LEFT');
		$this->db->where('hel_ativo_emp', EMPRESA_ATIVO, FALSE);
		$this->db->where('hel_seqcon_exc', $hel_seqcon_exc, FALSE);
		return $this->db->get()->result();
	}
	
	public function insert($empresa_contato) {
		$res = $this->db->insert('heltbexc', $empresa_contato);
	
		if ($res) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($empresa_contato, $hel_pk_seq_exc) {
		$this->db->where('hel_pk_seq_exc', $hel_pk_seq_exc, FALSE);
		$res = $this->db->update('heltbexc', $empresa_contato);
	
		if ($res) {
			return $hel_pk_seq_exc;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_exc) {
		$this->db->where('hel_pk_seq_exc', $hel_pk_seq_exc, FALSE);
		return $this->db->delete('heltbexc');
	}
}