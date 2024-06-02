<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\SMTP.php';

$sender_email = 'evandavidwhite16@gmail.com';

$recipient_email = $_POST['email'];
$macList = $_POST['macList'];  // Convert the string back to an array


$mail = new PHPMailer(true);

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $sender_email;             // SMTP username (your Google email)
$mail->Password = 'ztoh zvix wgug iopg';         // SMTP password (your Google App Password)
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom($sender_email, 'Inventory Managment');
$mail->addAddress($recipient_email, 'Recipient');     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'InvMan';
$mail->Body = '<b>IMPORTANT!</b><br>Items Added To Your Inventory:<br><br>';
$mail->AltBody = 'Important!\nItems Added To Your Inventory:';

foreach ($macList as $macAddress) {
    $mail->Body .= $macAddress . "<br>";
    $mail->AltBody .= $macAddress . "\n";

    error_log($macAddress);  // Log each MAC address to the error log
}   


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>

