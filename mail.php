<?php
//error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(TRUE);
//$mail = new PHPMailer; // the true param means it will throw exceptions on errors


 try {


$mail->IsSMTP(); // telling the class to use SMTP


$mail->Host       = "dal-shared-7.hostwindsdns.com";
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)

$mail->SMTPAuth   = true;  
               // enable SMTP authentication
$mail -> SMTPSecure = 'tls';

$mail->Port       = 25;                    // set the SMTP port for the GMAIL server

$mail->Username   = "testing@worldeco.org"; // SMTP account username

$mail->Password   = "admin@123.com";        // SMTP account password

$mail->AddReplyTo('developer.l4logics@gmail.com', 'First Last');

$mail->AddAddress('developer.l4logics@gmail.com', 'John Doe');

$mail->SetFrom('testing@worldeco.org', 'First Last');


$mail->Subject = 'Forgotten Password on Worldeco';

$mail->AltBody = 'Your Password: abc'; // optional - MsgHTML will create an alternate automatically

$mail->MsgHTML('test');


$mail->Send();

echo "Message Sent OK<p></p>\n";

} catch (phpmailerException $e) {
echo $e->errorMessage(); //Pretty error messages from PHPMailer

} catch (Exception $e) {

echo $e->getMessage(); //Boring error messages from anything else!

}

?>
