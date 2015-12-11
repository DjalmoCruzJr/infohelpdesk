<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa_Contato_Model extends CI_Model {
	
	public function get($hel_pk_seq_cid) {
		$this->db->from('heltbcid');
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getEmpresaContato($hel_pk_seq_emp) {
		$this->db->from('heltbexc');
		$this->db->where('hel_seqemp_exc', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	
	public function getCidade() {
		$this->db->from('heltbcid');
		$this->db->order_by("hel_nome_cid", "asc");
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
	
	public function delete($hel_pk_seq_cid) {
		$this->db->where('hel_pk_seq_cid', $hel_pk_seq_cid, FALSE);
		return $this->db->delete('heltbcid');
	}
	
	public function getContatoLogin($hel_login_con, $hel_senha_con) {
		$this->db->from('heltbexc');
		$this->db->join('heltbcon', 'hel_seqcon_exc = hel_pk_seq_con');
		$this->db->where('hel_login_con = ', $hel_login_con, FALSE);
		$this->db->where('hel_senha_con = ', sha1($hel_senha_con), FALSE);
		$this->db->where('hel_ativo_con = ', CONTATO_ATIVO, FALSE);
		return $this->db->get()->result();
	}
		
}