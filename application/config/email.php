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
$config['smtp_host']	= 'ssl://smtp.googlemail.com';
$config['smtp_port']	= 465;
$config['smtp_timeout']	= '60';
$config['smtp_user']	= 'luizmariodev@gmail.com';
$config['smtp_pass']	=  base64_decode(SENHA_EMAIL);
$config['validate']		= TRUE;
$config['wordwrap']     = TRUE;
$config['charset']		= 'utf-8';
$config['newline']		= "\r\n";
 