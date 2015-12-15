<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Sistema_Model extends CI_Model {
	
	public function get($hel_pk_seq_sis) {
		$this->db->from ('heltbsis' );
		$this->db->where ('hel_pk_seq_sis', $hel_pk_seq_sis, FALSE );
		return $this->db->get()->first_row();
	}
	
	public function getSistemaCadastrado($hel_pk_seq_sis, $hel_tipo_sis, $hel_codigo_sis) {
		$this->db->from ('heltbsis');
		$this->db->where('hel_pk_seq_sis <> ', $hel_pk_seq_sis);
		$this->db->where('hel_codigo_sis = ', $hel_codigo_sis);
		$this->db->where('hel_tipo_sis = ', $hel_tipo_sis);
		return $this->db->get ()->result ();
	}
	
	public function getSistema() {
		$this->db->from ('heltbsis');
		$this->db->order_by ( "hel_desc_sis", "asc" );
		return $this->db->get ()->result ();
	}
	
	public function insert($sistema) {
		$res = $this->db->insert ( 'heltbsis', $sistema);
		
		if ($res) {
			return $this->db->insert_id ();
		} else {
			return FALSE;
		}
	}
	
	public function update($sistema, $hel_pk_seq_sis) {
		$this->db->where ('hel_pk_seq_sis', $hel_pk_seq_sis, FALSE );
		$res = $this->db->update ('heltbsis', $sistema );
		
		if ($res) {
			return $hel_pk_seq_sis;
		} else {
			return FALSE;
		}
	}
	
	public function delete($hel_pk_seq_sis) {
		$this->db->where ( 'hel_pk_seq_sis', $hel_pk_seq_sis, FALSE );
		return $this->db->delete ( 'heltbsis' );
	}
}