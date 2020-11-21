<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semail{
    public function __construct() {
        
    }

public function send($toemail,$title,$Subject,$noidung,$image=""){


$xnoidung = str_replace("%26", "&",$noidung);
$xnoidung = str_replace("%40", "@",$xnoidung);

//die("mail");
//return $this->sv_send_mail($title,$xnoidung,$toemail,$fromemail,$fromname);//tat gui mail bang sv phu
  if (filter_var($toemail, FILTER_VALIDATE_EMAIL)) {
            
    if(!class_exists("PHPMailer"))
require_once("include/PHPMailerAutoload.php");
$mail = new PHPMailer();
//die("mail");
ini_set ( 'max_execution_time', 1200);
date_default_timezone_set('Etc/UTC');
$user=array();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->CharSet = 'UTF-8';
$mail->Debugoutput = 'html';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->IsHTML(true);

$from ='doanvanhieu.info@gmail.com';
$mail->Username = $from;
$mail->Password = "matkhaumoi";

$mail->SetFrom($from,$title);

$mail->Subject = $Subject;

$mail->msgHTML($xnoidung);
$mail->AddAddress($toemail);

if(!$mail->Send())
{
return false;
}
else
{
return true;
}
    }
    
}
}