<?php

require_once __DIR__ . '/db.php';

/**
 * Valida que una contraseña cumpla con los requisitos de seguridad.
 *
 * @param string $password
 * @return bool|string Retorna true si es válida, o un mensaje de error si no lo es.
 */
function validatePassword($password) {
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        return "La contraseña debe tener al menos 8 caracteres, incluir al menos 1 mayúscula, 1 minúscula, 1 número y 1 símbolo especial.";
    }
    return true;
}


/**
 * Verifica si dos contraseñas coinciden.
 *
 * @param string $password
 * @param string $confirmPassword
 * @return bool|string Retorna true si coinciden, o un mensaje de error si no lo hacen.
 */
function passwordsMatch($password, $confirmPassword) {
    if ($password !== $confirmPassword) {
        return "Las contraseñas no coinciden.";
    }
    return true;
}



/**
 * Verifica si un usuario ha excedido los intentos fallidos permitidos.
 *
 * @param string $username
 * @return bool|string Retorna true si no ha excedido el límite, o un mensaje de error si lo ha hecho.
 */
function checkFailedAttempts($username) {
    $stmt = db()->prepare("SELECT COUNT(*) AS failed_attempts FROM failed_logins WHERE username = ? AND failed_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE)");
    $stmt->execute([$username]);
    $failedAttempts = $stmt->fetchColumn();

    if ($failedAttempts >= 5) {
        return "Demasiados intentos fallidos. Intenta nuevamente en 5 minutos.";
    }
    return true;
}

/**
 * Autentica a un usuario verificando sus credenciales.
 *
 * @param string $username
 * @param string $password
 * @return bool|string Retorna true si las credenciales son válidas, o un mensaje de error si no lo son.
 */
function authenticateUser($username, $password) {
    $stmt = db()->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        return $user; // Retorna el usuario si las credenciales son válidas.
    }
    return "Credenciales inválidas.";
}




/**
 * Genera un token CSRF y lo almacena en la sesión.
 *
 * @return string El token CSRF generado.
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida el token CSRF enviado en el formulario.
 *
 * @param string $token El token CSRF enviado.
 * @return bool Retorna true si el token es válido, false en caso contrario.
 */
function validateCsrfToken($token) {
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        unset($_SESSION['csrf_token']); // Eliminar el token después de validarlo
        return true;
    }
    return false;
}




?>