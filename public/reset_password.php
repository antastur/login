
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
    <h1>Cambiar contraseña</h1>
    <p>Por favor, ingresa tu nueva contraseña</p>


<?php $token = $_GET['token']; ?>
<form action="reset_process.php" method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <input name="new_password" type="password" required>
    <button>Actualizar contraseña</button>
</form>

</div>
</div>

</body>
</html>