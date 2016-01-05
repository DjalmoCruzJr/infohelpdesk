<?php class Meuperfil_model extends CI_Controller{
	
	
	public function get($hel_pk_seq_con){
		$this->db->from('heltbcon');
		$this->db->where('hel_pk_seq_con', $hel_pk_seq_con, FALSE);
		return $this->db->get()->first_row();
	}
	
	public function update($novoPerfil, $hel_pk_seq_con) {
		$res = $this->db->update('heltbcon', $novoPerfil);
		$this->db->where('$hel_pk_seq_con', $hel_pk_seq_con, FALSE);
		
		if ($res) {
			return $hel_pk_seq_con;
		} else {
			return FALSE;
		}
	}
}