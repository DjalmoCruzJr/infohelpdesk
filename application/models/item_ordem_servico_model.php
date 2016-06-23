<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_Ordem_Servico_Model extends CI_Model {
	
	public function get($hel_pk_seq_ios) {
		$this->db->from('heltbios');
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
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
	
	public function getChamadoOrdemServico($hel_pk_seq_cha) {
		$this->db->from('heltbios');
		$this->db->where('hel_tipo_ios <> ', CHAMADO, FALSE);
		$this->db->where('hel_seqcha_ios = ', $hel_pk_seq_cha, FALSE);
		return $this->db->get()->result();
	}
	
	public function getItemOrdemServico($hel_seqose_ios) {
		$this->db->from('heltbios');
		$this->db->join('heltbser','hel_pk_seq_ser = hel_seqser_ios','LEFT');
		$this->db->join('heltbcha','hel_pk_seq_cha = hel_seqcha_ios','LEFT');
		$this->db->join('heltbsis','hel_pk_seq_sis = hel_seqsis_ios','LEFT');
		$this->db->where('hel_seqose_ios = ', $hel_seqose_ios, FALSE);
		return $this->db->get()->result();
	}

	public function insert($item_ordem_servico, $parameter_procedure = NULL) {
		$res = $this->db->insert('heltbios', $item_ordem_servico);
	
		if ($res) {
			if (!empty($parameter_procedure)){
				$store_procedure = 'CALL SP_ENCERRAR_ITEM_CHAMADO (?, ?, ?, ?)';
				array_push($parameter_procedure, $this->db->insert_id());
				$this->db->query($store_procedure, $parameter_procedure);
			}
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	public function update($item_ordem_servico, $hel_pk_seq_ios, $parameter_procedure = NULL) {
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		$res = $this->db->update('heltbios', $item_ordem_servico);
	
		if ($res) {
			if (!empty($parameter_procedure)){
				$store_procedure = 'CALL SP_ENCERRAR_ITEM_CHAMADO (?, ?, ?, ?)';
				array_push($parameter_procedure, $hel_pk_seq_ios);
				$this->db->query($store_procedure, $parameter_procedure);
			}
			return $hel_pk_seq_ios;
		} else {
			return FALSE;
		}
	}
	
	public function update_ordem_servico($update) {
		$res = $this->db->query($update);	
		if ($res) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_ios) {
		$this->db->where('hel_pk_seq_ios', $hel_pk_seq_ios, FALSE);
		return $this->db->delete('heltbios');
	}
		
}