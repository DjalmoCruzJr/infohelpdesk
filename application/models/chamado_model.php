<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chamado_Model extends CI_Model {
	
	public function get($hel_pk_seq_cha) {
		$this->db->from('heltbcha');
		$this->db->where('hel_pk_seq_cha', $hel_pk_seq_cha, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function getContatoChamado($hel_pk_seq_con) {
		$this->db->from('heltbcha');
		$this->db->where('hel_seqconde_cha', $hel_pk_seq_con, FALSE);
		return $this->db->get()->result();
	}
	
	public function getContatoChamado2($hel_pk_seq_con) {
		$this->db->from('heltbcha');
		$this->db->where('hel_seqconpara_cha', $hel_pk_seq_con, FALSE);
		return $this->db->get()->result();
	}
	
	public function getChamadoEmpresa($hel_pk_seq_emp) {
		$this->db->from('heltbcha');
		$this->db->where('hel_seqemp_cha', $hel_pk_seq_emp, FALSE);
		return $this->db->get()->result();
	}
	
	public function getEmpresaContatoChamado($hel_pk_seq_exc) {
		$this->db->from('heltbcha');
		$this->db->where('hel_seqexc_cha', $hel_pk_seq_exc, FALSE);
		return $this->db->get()->result();
	}
	
	public function getChamado($hel_pk_seq_con = NULL) {
		$this->db->from('heltbcha');
		$this->db->join('heltbser','hel_pk_seq_ser = hel_seqser_cha','LEFT');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_cha','LEFT');
		$this->db->join('heltbexc','hel_pk_seq_exc = hel_seqexc_cha','LEFT');
		$this->db->join('heltbcon','hel_pk_seq_con = hel_seqcon_exc','LEFT');		
		$this->db->join('heltbemp','hel_pk_seq_emp = hel_seqemp_exc','LEFT');
		if (!empty($hel_pk_seq_con)){
			$this->db->where('hel_seqcon_exc', $hel_pk_seq_con, FALSE);
		}
		return $this->db->get()->result();
	}
	
	public function getChamadosAbertoEmpresa($hel_seqexc_ios, $hel_seqemp_cha) {
		$this->db->from('heltbcha');
		$this->db->where('hel_seqexc_cha', $hel_seqexc_ios, FALSE);
		$this->db->or_where('hel_seqemp_cha', $hel_seqemp_cha, FALSE);
		$this->db->where('hel_encerrado_cha <> ', CHAMADO_ATIVO, FALSE);
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
		
}