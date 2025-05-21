<?php

session_start();

require_once __DIR__ . '/../app/db.php';

$token = $_POST['token'];
$newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

$stmt = db()->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if ($user) {
    $stmt = db()->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
    $stmt->execute([$newPassword, $user['id']]);
    $_SESSION['token'] = "Contraseña actualizada. Iniciar sesión";
    header('Location: login.php');
    exit;
   // echo "Contraseña actualizada.Inicia sesión";
} else {
    $_SESSION['errorToken'] = "Token inválido o expirado.";
    header('Location: login.php');
    exit;
    //echo "Token inválido o expirado.";
}




?>