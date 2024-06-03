<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\vendor\phpmailer\phpmailer\src\SMTP.php';

// Load configuration
$config = require 'config.php';

function sendEmail($config, $recipient_email, $email_format, $user_email, $user_confirmation_format, $is_confirmation_email_sent) {
    echo 'this is a debug statement please print omg pleeeeaaassee';
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_username'];
    $mail->Password = $config['smtp_password'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($config['smtp_username'], 'Inventory Managment');
    $mail->addAddress($recipient_email, 'Recipient');
    $mail->isHTML(true);

    $mail->Subject = 'InvMan';
    $mail->Body = $email_format;
    //$mail->AltBody = 'Important!\nItems Added To Your Inventory:';

    // Send the emails
    if(!$mail->send()) {
        echo 'message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'message has been sent';
        if ($is_confirmation_email_sent == FALSE) {
            sendEmail($config, $user_email, $user_confirmation_format, $user_email, $user_confirmation_format, $is_confirmation_email_sent = TRUE);
        }
    }
}


// This next section is just building the format for each email

//$SESSION_TOKEN = $_POST['token']; Temperary token
$SESSION_TOKEN = '6.2.24.4.51.a';

$user_name = $_POST['name'];
$user_email = $_POST['email'];
$IT_email = $config['IT_email'];
$macList = $_POST['macList'];  // Convert the string back to an array

// format for user confirmation email
$user_confirmation_format = 
    '<b>IMPORTANT!</b><br>Items Added To Your Inventory:<br><br>';
foreach ($macList as $macAddress) {
    $user_confirmation_format .= $macAddress . "<br>";
    //$mail->AltBody .= $macAddress . "\n";

    error_log($macAddress);  // Log each MAC address to the error log
}   
$user_confirmation_format .= '</b><br><br>' . $SESSION_TOKEN;


// format for email sent to IT
$IT_email_format = $user_name . '<br>' . $user_email . '<br><br>' . '-----------------------' . '<br><br>'; ;
foreach ($macList as $macAddress) {
    $IT_email_format .= $macAddress . "<br>";
    //$mail->AltBody .= $macAddress . "\n";

    error_log($macAddress);  // Log each MAC address to the error log
}  
$IT_email_format .= '<br><br>' . '-----------------------' . '<br><br>' . $SESSION_TOKEN;


// start the email chain
sendEmail($config, $IT_email, $IT_email_format, $user_email, $user_confirmation_format, $is_confirmation_email_sent = False);
