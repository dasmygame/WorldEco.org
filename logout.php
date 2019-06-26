<?php
session_start();


//require_once 'controllers/authController.php';
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['email']);
unset($_SESSION['verified']);
unset($_SESSION['message']);
unset($_SESSION['type']);
unset($_SESSION['message2']);
session_destroy();
header('Location: /login/index.php'); 
exit;

?>
