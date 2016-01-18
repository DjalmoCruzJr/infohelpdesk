<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Servico_Model extends CI_Model {
	
	public function get($hel_pk_seq_ser) {
		$this->db->from ( 'heltbser' );
		$this->db->where ( 'hel_pk_seq_ser', $hel_pk_seq_ser, FALSE );
		return $this->db->get ()->first_row ();
	}
	
	public function getServico() {
		$this->db->from ( 'heltbser' );
		$this->db->order_by ( "hel_desc_ser", "asc" );
		return $this->db->get ()->result ();
	}

	public function insert($servico) {
		$res = $this->db->insert ( 'heltbser', $servico );
		
		if ($res) {
			return $this->db->insert_id ();
		} else {
			return FALSE;
		}
	}
	
	public function update($servico, $hel_pk_seq_ser) {
		$this->db->where ( 'hel_pk_seq_ser', $hel_pk_seq_ser, FALSE );
		$res = $this->db->update ( 'heltbser', $servico );
		
		if ($res) {
			return $hel_pk_seq_ser;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_ser) {
		$this->db->where ( 'hel_pk_seq_ser', $hel_pk_seq_ser, FALSE );
		return $this->db->delete ( 'heltbser' );
	}
}