<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class M_pdf {

	function __construct() {
		$CI = &get_instance();
		log_message('Debug', 'mPDF class is loaded.');
	}

	function load($param = NULL) {

		include_once APPPATH . '/third_party/mpdf/mpdf.php';

		if ($params == NULL) {
			$param = '"en-GB-x","A4","","",8,8,8,8,6,3';
		}

		return new mPDF($param);
	}

}