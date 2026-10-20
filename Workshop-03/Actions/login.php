<?php

require_once __DIR__ . '/../utils/auth.php';
startAppSession();
require_once __DIR__ . '/../utils/database.php';

// Solo permitir solicitudes POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php?error=invalid_request');
    exit;
}

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

// Validar los datos recibidos.
if (
    !is_string($username) ||
    !is_string($password) ||
    trim($username) === '' ||
    strlen($username) > 50 ||
    $password === ''
) {
    header('Location: ../index.php?error=invalid_input');
    exit;
}

try {
    $statement = $conn->prepare(
        'SELECT id, username, password_hash
         FROM users
         WHERE username = :username
         LIMIT 1'
    );

    $statement->execute([
        'username' => trim($username)
    ]);

    $user = $statement->fetch();

} catch (PDOException $exception) {
    error_log('Authentication error: ' . $exception->getMessage());

    header('Location: ../index.php?error=server_error');
    exit;
}

// Comprobar el usuario y su contraseña.
if (
    !$user ||
    !password_verify($password, $user['password_hash'])
) {
    header('Location: ../index.php?error=invalid_credentials');
    exit;
}

// Regenerar el identificador para proteger la sesión.
session_regenerate_id(true);

// Guardar los datos necesarios en la sesión.
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];

// Redirigir al Dashboard.
header('Location: ../pages/dashboard.php');
exit;