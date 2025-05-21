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
    <h1>Regístrate</h1>

    <?php if ($error): ?>
    <div class="error-popup">
        <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
        <button onclick="document.querySelector('.error-popup').style.display='none';">Cerrar</button>
    </div>
    <?php endif;
    unset($_SESSION['error']);
     ?>
    
<form action="register_process.php" method="POST">
<input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
    <input name="username" required placeholder="Usuario">
    <input name="email" type="email" required placeholder="E-mail">
    <input name="password" type="password" required placeholder="Contraseña">
    <input name="confirm_password" type="password" required placeholder="Confirmar contraseña">
        <button type="submit">Registrarse</button>
</form>

</div>
</div>
</body>
</html>


