<?php
/**
 * Created by PhpStorm.
 * User: jonforest
 * Date: 05/04/2014
 * Time: 15:27
 */

require_once('phpmailer/class.phpmailer.php');

$name = strip_tags(isset($_GET['nameInput']) ? $_GET['nameInput'] : '');
$email = strip_tags(isset($_GET['emailInput']) ? $_GET['emailInput'] : '');
$query = strip_tags(isset($_GET['queryText']) ? $_GET['queryText'] : '');

$message = '<p><b>From:</b> ' . $name . '</b></p>';
$message .= '<p><b>Email:</b> ' . $email . '</p>';
$message .= '<p>' . $query . '</p>';

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = 'mail.radiology-services.co.nz';      // SMTP server example, use smtp.live.com for Hotmail
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 25;                   // SMTP port for the GMAIL server 465 or 587
$mail->Username   = 'contact@radiology-services.co.nz';  // SMTP account username example
$mail->Password   = 'eNf2st96';
$mail->SetFrom('contact@radiology-services.co.nz', 'Website Enquiry'); //set from name
$mail->AddAddress('jonforest@gmail.com');
$mail->AddAddress('jamedcad@gmail.com');
$mail->Subject = "Enquiry from " . $name;
$mail->MsgHTML($message);

if ($mail->Send()) {
    header("Location: ../content.php?r=emailsuccess");
    die();
} else {
    header("Location: ../content.php?r=index");
    die();
}
