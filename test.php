<?php
require 'class.phpmailer.php';

$mail = new PHPMailer;

$mail->IsSMTP(true);                                      // Set mailer to use SMTP
$mail->SMTPDebug =3;
$mail->Host = 'dal-shared-7.hostwindsdns.com';                 // Specify main and backup server
$mail->Port = 465;                                    // Set the SMTP port
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'contact@worldeco.org';                // SMTP username
$mail->Password = 'WshDF8z71';                  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'contact@worldeco.org';
$mail->FromName = 'Test';
$mail->AddAddress('hwstechsup@outlook.com', 'Test');  // Add a recipient

$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <strong>in bold!</strong>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
