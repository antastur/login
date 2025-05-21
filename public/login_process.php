<?php

session_start();
require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/auth.php';

// Validar el token CSRF
if (!validateCsrfToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Intenta nuevamente.";
    header('Location: login.php');
    exit;
}




$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

// Verificar intentos fallidos
$failedAttemptsCheck = checkFailedAttempts($username);
if ($failedAttemptsCheck !== true) {
    $_SESSION['intentos'] = $failedAttemptsCheck;
    header('Location: login.php');
    exit;
}
/*

// Verificar credenciales
$stmt = db()->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // Restablecer intentos fallidos y redirigir al usuario
    db()->prepare("DELETE FROM failed_logins WHERE username = ?")->execute([$username]);
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
} else {
    // Registrar intento fallido
    db()->prepare("INSERT INTO failed_logins (username, failed_at) VALUES (?, NOW())")->execute([$username]);
    $_SESSION['error'] = "Credenciales inválidas.";
    header('Location: login.php');
    exit;
} */

// Autenticar usuario
$authResult = authenticateUser($username, $password);
if (is_array($authResult)) {
    // Restablecer intentos fallidos y redirigir al usuario
    db()->prepare("DELETE FROM failed_logins WHERE username = ?")->execute([$username]);
    $_SESSION['user_id'] = $authResult['id'];
    header('Location: index.php');
    exit;
} else {
    // Registrar intento fallido
    db()->prepare("INSERT INTO failed_logins (username, failed_at) VALUES (?, NOW())")->execute([$username]);
    $_SESSION['error'] = $authResult;
    header('Location: login.php');
    exit;
}

?>