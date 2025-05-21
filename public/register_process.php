
<?php

session_start();

require_once __DIR__ . '/../app/db.php';
require_once __DIR__ . '/../app/auth.php';

// Validar el token CSRF
if (!validateCsrfToken($_POST['csrf_token'])) {
    $_SESSION['error'] = "Solicitud inválida. Intenta nuevamente.";
    header('Location: register.php');
    exit;
}

// Sanitizar username
$username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');

// Sanitizar email
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "El correo electrónico proporcionado no es válido.";
    exit;
}



// Verificar que las contraseñas coincidan
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];
/*
//Generacion de mensaje de error y redireccionamiento a página registro
if ($password !== $confirmPassword) {
    $_SESSION['error'] = "Las contraseñas no coinciden.";
    header('Location: register.php');
    exit;
}
*/
$passwordMatchValidation = passwordsMatch($password, $confirmPassword);
if ($passwordMatchValidation !== true) {
    $_SESSION['error'] = $passwordMatchValidation;
    header('Location: register.php');
    exit;
}

// Validar la contraseña
$passwordValidation = validatePassword($password);
if ($passwordValidation !== true) {
    $_SESSION['error'] = $passwordValidation;
    header('Location: register.php');
    exit;
}

//Codificar la contraseña
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

//Insertar usuario en BD
$stmt = db()->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->execute([$username, $email, $hashedPassword]);

//Generación de mensaje de exito y redireccionamiento a pagina login
$_SESSION['registro'] = "Registro exitoso. Inicia sesión.";
header('Location: login.php');
exit;
//echo "Registro exitoso. <a href='login.php'>Inicia sesión</a>";




?>