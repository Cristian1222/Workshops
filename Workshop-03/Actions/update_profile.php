<?php

require_once __DIR__ . '/../utils/auth.php';

startAppSession();

// Verificar que el usuario haya iniciado sesión.
requireLogin();

// Solo permitir solicitudes POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/profile.php?error=invalid_request');
    exit;
}

// Recibir y validar los datos.
$fullName = $_POST['full_name'] ?? null;
$username = $_POST['username'] ?? null;
$email = $_POST['email'] ?? null;

if (
    !is_string($fullName) ||
    !is_string($username) ||
    !is_string($email)
) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

$fullName = trim($fullName);
$username = trim($username);
$email = trim($email);

if (
    $fullName === '' ||
    strlen($fullName) > 100 ||
    $username === '' ||
    strlen($username) > 50 ||
    $email === '' ||
    strlen($email) > 100 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL)
) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

try {
    // Comprobar que el nombre de usuario no pertenezca a otra persona.
    $stmt = $conn->prepare(
        'SELECT id
         FROM users
         WHERE username = :username
           AND id <> :id
         LIMIT 1'
    );

    $stmt->execute([
        'username' => $username,
        'id' => $_SESSION['user_id']
    ]);

    if ($stmt->fetch()) {
        header('Location: ../pages/profile.php?error=invalid_input');
        exit;
    }

    // Actualizar el perfil.
    $stmt = $conn->prepare(
        'UPDATE users
         SET full_name = :full_name,
             username = :username,
             email = :email
         WHERE id = :id'
    );

    $stmt->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'id' => $_SESSION['user_id']
    ]);

    // Mantener actualizado el nombre en la sesión.
    $_SESSION['username'] = $username;

    header('Location: ../pages/profile.php?success=profile_updated');
    exit;

} catch (PDOException $exception) {
    error_log('Profile update error: ' . $exception->getMessage());

    header('Location: ../pages/profile.php?error=server_error');
    exit;
}