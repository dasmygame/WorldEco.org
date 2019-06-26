<?php require_once 'controllers/authController.php'; ?>
<?php
error_reporting(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(TRUE);
//$mail = new PHPMailer; // the true param means it will throw exceptions on errors





if(isset($_POST['forgot-btn'])) {
    if (empty($_POST['useremail'])) {
        $_SESSION['errors'] = 'Email required';
    }
   
    $useremail = $_POST['useremail'];

    if (count($errors) === 0) {
        $query = "SELECT * FROM user WHERE email=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $useremail);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();


            if ($useremail==$user['email']) { // if password matches
         
 
$subject = "Forgot Password Request - worldeco";




		$emailbody = '<html><body><table border="0" cellpadding="0" cellspacing="0" width="100%">
					 <tbody>
					  <tr>
					   <td style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#333333; border-bottom:1px solid #1c8190; padding:5px 0 8px 15px; " align="left" valign="top">
						<span style="color:#1c8190;">Hello '.$user['username'].' !</span></td>
					  </tr>
					  <tr>
					   <td style="padding:0px 15px 10px 15px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#333333; line-height:20px;" align="left" valign="top">
						 <p><strong>Your Password is</strong> : '.$user['password'].' <p> 
						
						<p>
						 Thank You!<br>
						 <br>
<a href="worldeco.org" class="custom-logo-link" rel="home" itemprop="url"><img width="240" height="73" src="http://worldeco.org/img/logo.png" class="custom-logo" alt="Money Rewards" itemprop="logo" srcset="http://worldeco.org/img/logo.png 240w, http://worldeco.org/img/logo.png 240w" sizes="(max-width: 240px) 100vw, 240px" /></a>
<br>
<br>
						 <strong>worldeco</strong><br>
						 </p> 
					   </td>
					  </tr>  
					 </tbody>
					</table></body></html>'; 

			

 try {


$mail->IsSMTP(); // telling the class to use SMTP


$mail->Host       = "dal-shared-7.hostwindsdns.com";
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)

$mail->SMTPAuth   = true;  
               // enable SMTP authentication
$mail -> SMTPSecure = 'tls';

$mail->Port       = 25;                    // set the SMTP port for the GMAIL server

$mail->Username   = "contact@worldeco.org"; // SMTP account username

$mail->Password   = "testtest";        // SMTP account password

$mail->AddReplyTo('contact@worldeco.org', 'Worldeco');

$mail->AddAddress($user['email'], 'Worldeco');

$mail->SetFrom('contact@worldeco.org', 'Worldeco');


$mail->Subject = $subject;

$mail->AltBody = $emailbody; // optional - MsgHTML will create an alternate automatically

$mail->MsgHTML($emailbody);


$mail->Send();

 $_SESSION['success_message'] = 'We have sent your password to your email. <strong>Check your spam folder</strong>'; 

?>
				<script>window.location.href="forgot-password.php";</script>
				<?php      

} catch (phpmailerException $e) {
$e->errorMessage(); //Pretty error messages from PHPMailer

} catch (Exception $e) {

$e->getMessage(); //Boring error messages from anything else!

}



	
              //  header('Location: dashboard.php');
   $stmt->close();
                exit(0);
            } else { // if password does not match
                $_SESSION['errors'] = "Email not registered with us!";
?>
				<script>window.location.href="forgot-password.php";</script>
				<?php  
            }
        } else {
            $_SESSION['message'] = "Database error. Login failed!";
            $_SESSION['type'] = "alert-danger";
        }
    }
}

?>
