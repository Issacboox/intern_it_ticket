<?php 

$rdir = str_replace("\\", "/", __DIR__);                    //Root Dir
require $rdir.'/PHPMailer/src/Exception.php';
require $rdir.'/PHPMailer/src/PHPMailer.php';
require $rdir.'/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function SendMail( $ToEmail, $MessageHTML, $MessageTEXT ) {
    // require_once ( 'class.phpmailer.php' ); // Add the path as appropriate
    // $mail = new PHPMailer\PHPMailer\PHPMailer();
  
    require 'src/Exception.php';
    require 'src/PHPMailer.php';
    require 'src/SMTP.php';

    $Mail = new PHPMailer();
    $Mail->IsSMTP(); 
    $Mail->Host        = "smtp.gmail.com"; 
    $Mail->SMTPDebug   = 2; 
    $Mail->SMTPAuth    = TRUE; 
    $Mail->SMTPSecure  = "ssl"; 
    $Mail->Port        = 456; 
    $Mail->Username    = 'patipan@bt-midland.com'; 
    $Mail->Password    = 'xDb4kI212540'; 
    $Mail->Priority    = 1;
    $Mail->CharSet     = 'UTF-8';
    $Mail->Encoding    = '8bit';
    $Mail->Subject     = 'Test Email Using Gmail';
    $Mail->ContentType = 'text/html; charset=utf-8\r\n';
    $Mail->From        = 'testsupport@bt-midland.com';
    $Mail->FromName    = 'GMail Test';
    $Mail->WordWrap    = 900; 
  
    $Mail->AddAddress( $ToEmail ); 
    $Mail->isHTML( TRUE );
    $Mail->Body    = $MessageHTML;
    $Mail->AltBody = $MessageTEXT;
    $Mail->Send();
    $Mail->SmtpClose();
  
    if ( $Mail->IsError() ) { 
      return FALSE;
    }
    else {
      return TRUE;
    }
  }
  




?>