<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Doc extends CI_Controller {
  function __construct()
  {
    parent::__construct();
    $params = array('orientation' => 'P', 'unit' => 'mm', 'size' => array(106,106));
    $this->load->library('Pdf2', $params); // Load library
    $this->pdf->fontpath = 'font/'; // Specify font folder
  }
  public function index()
  {
    // Generate PDF by saying hello to the world
    $this->pdf->AddPage();
    $this->pdf->SetFont('courier','', 10);
    $this->pdf->Text(0, 3,'Nro 10');
    $this->pdf->Text(0, 6,'Nro 10');
    $this->pdf->Text(0, 9,'12345678901234567890123456789012345678901234567890');
    $this->pdf->Text(0, 12,'12345678901234567890123456789012345678901234567890');
    $this->pdf->Text(0, 15,'12345678901234567890123456789012345678901234567890');
    $this->pdf->Text(0, 18,'12345678901234567890123456789012345678901234567890');
    $this->pdf->Text(0, 21,'12345678901234567890123456789012345678901234567890');
    $this->pdf->AddPage();
    $this->pdf->Text(0, 3,'Nro 10');
    $this->pdf->Output();
  }
  // More methods goes here
}
?>