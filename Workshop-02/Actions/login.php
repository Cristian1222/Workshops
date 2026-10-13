<?php
session_start();

require_once __DIR__ . '/../utils/database.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
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
    http_response_code(500);
    exit('No fue posible iniciar sesión.');
}

if (
    !$user ||
    !password_verify($password, $user['password_hash'])
) {
    header('Location: ../index.php?error=invalid_credentials');
    exit;
}

// Evitar reutilizar el identificador de sesión anterior.
session_regenerate_id(true);

$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];

header('Location: ../pages/dashboard.php');
exit;