<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\SMTP.php';

$sender_email = 'evandavidwhite16@gmail.com';

$user_name = $_POST['name'];
$user_email = $_POST['email'];
$IT_email = 'teslafan3261@gmail.com';
$macList = $_POST['macList'];  // Convert the string back to an array

//$SESSION_TOKEN = $_POST['token'];
$SESSION_TOKEN = '6.2.24.4.51.a';


$mail = new PHPMailer(true);

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $sender_email;             // SMTP username (my Google email)
$mail->Password = 'ztoh zvix wgug iopg';         // SMTP password (my Google App Password)
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom($sender_email, 'Inventory Managment');
$mail->addAddress($user_email, 'Recipient');     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'InvMan';
$mail->Body = '<b>IMPORTANT!</b><br>Items Added To Your Inventory:<br><br>';
//$mail->AltBody = 'Important!\nItems Added To Your Inventory:';

foreach ($macList as $macAddress) {
    $mail->Body .= $macAddress . "<br>";
    //$mail->AltBody .= $macAddress . "\n";

    error_log($macAddress);  // Log each MAC address to the error log
}   
$mail->Body .= '</b><br><br>' . $SESSION_TOKEN;

// Send the first email
if(!$mail->send()) {
    echo 'First message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'First message has been sent';
}

// Clear all addresses and attachments for next email
$mail->clearAddresses();
$mail->clearAttachments();

// Set properties for the second email
$mail->addAddress($IT_email, 'Second Recipient'); // Add a recipient for the second email

$mail->Subject = 'InvMan';
$mail->AltBody = 'Non prefered plain text\n\n';
$mail->Body = $user_name . '<br>' . $user_email . '<br><br>' . '-----------------------' . '<br><br>'; 
foreach ($macList as $macAddress) {
    $mail->Body .= $macAddress . "<br>";
    $mail->AltBody .= $macAddress . "\n";

    error_log($macAddress);  // Log each MAC address to the error log
}  
$mail->Body .= '<br><br>' . '-----------------------' . '<br><br>' . $SESSION_TOKEN;



// Send the second email
if(!$mail->send()) {
    echo 'Second message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Second message has been sent';
}
?>

