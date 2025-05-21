
<?php
session_start();

require_once __DIR__ . '/../app/auth.php';

$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
$correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;
$errorToken = isset($_SESSION['errorToken']) ? $_SESSION['errorToken'] : null;
$token= isset($_SESSION['token']) ? $_SESSION['token'] : null;
$intentos = isset($_SESSION['intentos']) ? $_SESSION['intentos'] : null;
$registro = isset($_SESSION['registro']) ? $_SESSION['registro'] : null;
//unset($_SESSION['error']);
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
    <h1>Iniciar sesión</h1>
    <p>Por favor, ingresa tus credenciales.</p>
    <form action="login_process.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(generateCsrfToken(), ENT_QUOTES, 'UTF-8') ?>">
        <input name="username" required placeholder="Usuario">
        <input type="password" name="password" required placeholder="Contraseña">
        <button type="submit">Iniciar sesión</button>
    </form>


<a href="register.php">Registrarse</a>
<a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
</div>
</div>

<!-- Div para mostrar el mensaje de error -->
<?php if ($error): ?>
<div class="error-popup">
    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.error-popup').style.display='none';">Cerrar</button>
</div>

<?php endif;
 unset($_SESSION['error']);
 ?>

<!-- Div para mostrar el mensaje de éxito -->
<?php if ($correo): ?>
<div class="success-popup">
    <p><?= htmlspecialchars($correo, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.success-popup').style.display='none';">Cerrar</button>
</div>
<?php endif;
 unset($_SESSION['correo']);
 ?>

<!-- Div para mostrar el mensaje de error -->
<?php if ($errorToken): ?>
<div class="error-popup">
    <p><?= htmlspecialchars($errorToken, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.error-popup').style.display='none';">Cerrar</button>
</div>
<?php endif;
 unset($_SESSION['errorToken']);
 ?>

<!-- Div para mostrar el mensaje de éxito -->
<?php if ($token): ?>
<div class="success-popup">
    <p><?= htmlspecialchars($token, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.success-popup').style.display='none';">Cerrar</button>
</div>
<?php endif;
 unset($_SESSION['token']);
 ?>

<!-- Div para mostrar el mensaje de éxito -->
<?php if ($intentos): ?>
<div class="error-popup">
    <p><?= htmlspecialchars($intentos, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.error-popup').style.display='none';">Cerrar</button>
</div>
<?php endif;
 unset($_SESSION['intentos']);
 ?>

<!-- Div para mostrar el mensaje de éxito -->
<?php if ($registro): ?>
<div class="success-popup">
    <p><?= htmlspecialchars($registro, ENT_QUOTES, 'UTF-8') ?></p>
    <button onclick="document.querySelector('.success-popup').style.display='none';">Cerrar</button>
</div>
<?php endif;
 unset($_SESSION['registro']);
 ?>


</body>
</html>


