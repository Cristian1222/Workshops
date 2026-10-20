<?php

require_once __DIR__ . '/../utils/auth.php';

startAppSession();

// Solo permitir solicitudes POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?error=invalid_request');
    exit;
}

// Eliminar los datos de la sesión.
$_SESSION = [];

// Eliminar la cookie de sesión si se utilizan cookies.
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruir la sesión.
session_destroy();

// Redirigir al login mostrando el mensaje de confirmación.
header('Location: ../index.php?success=logged_out');
exit;