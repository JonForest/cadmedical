<?php
/**
 * Created by PhpStorm.
 * User: jonforest
 * Date: 05/04/2014
 * Time: 15:27
 */

require_once('api/phpmailer/class.phpmailer.php');

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "mail.radiology-services.co.nz";      // SMTP server example, use smtp.live.com for Hotmail
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 25;                   // SMTP port for the GMAIL server 465 or 587
$mail->Username   = "contact@radiology-services.co.nz";  // SMTP account username example
$mail->Password   = "xxxxxx";
$mail->SetFrom('Peter@dmith.com', 'First Lastsssss'); //set from name
$mail->SetFrom('contact@radiology-services.co.nz', 'Website Enquiry'); //set from name
$mail->AddAddress('jonforest@gmail.com');
$mail->Subject = "Test subject";
$mail->MsgHTML('This is a tst body');

echo($mail->Send());
