<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'third_party/fpdf/fpdf.php');

class Pdf extends FPDF {
    // Extend FPDF using this class
    // More at fpdf.org -> Tutorials

    function __construct($params) {
        // Call parent constructor
        parent::__construct($params['orientation'], $params['unit'], $params['size']);
    }
}
?>
