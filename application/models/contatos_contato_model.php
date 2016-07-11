<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class contatos_contato_model extends CI_Model {
 	
 	public function get($hel_pk_seq_asu) {
 		$this->db->from('heltbasu');
 		$this->db->where('hel_pk_seq_asu', $hel_pk_seq_asu, FALSE);
 		return $this->db->get()->first_row();
 	}
 	
 	public function getContatos($hel_seqcon_cco) {
 		$this->db->from('heltbcco');
 		$this->db->where('hel_seqcon_cco', $hel_seqcon_cco, FALSE);
 		return $this->db->get()->result();
 	}
 	
 	public function getAssuntoSistema($hel_pk_seq_sis) {
 		$this->db->from('heltbasu');
 		$this->db->where('hel_seqsis_asu', $hel_pk_seq_sis, FALSE);
 		return $this->db->get()->first_row();
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