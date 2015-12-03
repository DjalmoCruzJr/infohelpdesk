<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasper {
   
    public function gerar_relatorio($name, $select, $arrayNoSubSelect = NULL, $select_sub = NULL) {
    	include_once('class/tcpdf/tcpdf.php');
    	include_once("class/PHPJasperXML.inc.php");
    	include_once ('setting.php');
    	
    	$PHPJasperXML = new PHPJasperXML();
    	$PHPJasperXML->select_sub = $select_sub;
    	$PHPJasperXML->load_xml_file($name, $select);
    	 
    	 
    	$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    	$PHPJasperXML->outpage("I", $arrayNoSubSelect);    	
    }
}

?>