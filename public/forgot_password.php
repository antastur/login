<?php
session_start();
require_once __DIR__ . '/../app/auth.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./login.css">
</head>
<body>

<div class="login-container">
<img src="./assets/imagenes/logo-lapuente.png" alt="Logo" class="login-logo"> <!-- Imagen en la parte superior -->
<div class="login-form">    
    <h1>¿Olvidaste la contraseña?</h1>
    <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.</p>
    <p>Si no recibes el correo, revisa tu carpeta de spam.</p>

    <?php if ($error): ?>
    <div class="error-popup">
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <button onclick="document.querySelector('.error-popup').style.display='none';">Cerrar</button>
    </div>
    <?php endif; 
     unset($_SESSION['error']);
    ?>

<form action="send_reset.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <input name="email" type="email" required>
    <button>Enviar enlace</button>
</form>

</div>
</div>