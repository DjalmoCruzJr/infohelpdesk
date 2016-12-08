 <?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| EMAIL CONFING
| -------------------------------------------------------------------
| Configuration of outgoing mail server.
| */

$config['useragent']	= 'CodeIgniter';
$config['mailtype']		= 'html';
$config['protocol']		= 'smtp';
$config['smtp_host']	= 'mail.inforio.com.br';
$config['smtp_port']	= 587;
$config['smtp_timeout']	= '60';
$config['smtp_user']	= 'luizmario@inforio.com.br';
$config['smtp_pass']	= 'luizMarioInforio';
$config['validate']		= TRUE;
$config['wordwrap']     = TRUE;
$config['charset']		= 'utf-8';
$config['newline']		= "\r\n";
 