<?php

session_start();

require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/auth.php';
require_once __DIR__ . '/../app/emailer.php';

// Validar el token CSRF
if (!validateCsrfToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Intenta nuevamente.";
    header('Location: forgot_password.php');
    exit;
}


$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Validar que el email sea válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El correo electrónico proporcionado no es válido.";
    exit;
}

$token = bin2hex(random_bytes(32));
$expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

$stmt = db()->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
$stmt->execute([$token, $expiry, $email]);

sendResetEmail($email, $token);

$_SESSION['correo'] = "Revisa tu correo electrónico para restablecer la contraseña.";
header('Location: login.php');
exit;



?>