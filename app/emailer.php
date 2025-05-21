<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../vendor/autoload.php';

function sendResetEmail($to, $token) {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['MAIL_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['MAIL_USER'];
    $mail->Password = $_ENV['MAIL_PASS'];
    $mail->SMTPSecure = 'ssl';
    $mail->Port = $_ENV['MAIL_PORT'];

    $mail->setFrom($_ENV['MAIL_USER'], 'Soporte');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = 'Recuperar contraseña';
    
    $link = $_ENV['APP_URL'] . "/public/reset_password.php?token=$token";
    $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href=\"$link\">$link</a>";

    $mail->send();
}





?>