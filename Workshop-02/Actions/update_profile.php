<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?error=login_required');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/profile.php');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$provinciaId = filter_var(
    $_POST['provincia_id'] ?? null,
    FILTER_VALIDATE_INT
);

if (
    $fullName === '' ||
    strlen($fullName) > 100 ||
    $username === '' ||
    strlen($username) > 50 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    strlen($email) > 100 ||
    $provinciaId === false ||
    $provinciaId === null ||
    $provinciaId < 1
) {
    header('Location: ../pages/profile.php?error=invalid_input');
    exit;
}

try {
    // Verificar que el nombre no pertenezca a otro usuario.
    $statement = $conn->prepare(
        'SELECT id FROM users
         WHERE username = :username AND id <> :id
         LIMIT 1'
    );

    $statement->execute([
        'username' => $username,
        'id' => $_SESSION['user_id']
    ]);

    if ($statement->fetch()) {
        header('Location: ../pages/profile.php?error=username_exists');
        exit;
    }

    // Confirmar que la provincia exista.
    $statement = $conn->prepare(
        'SELECT id FROM provincias WHERE id = :id'
    );
    $statement->execute(['id' => $provinciaId]);

    if (!$statement->fetch()) {
        header('Location: ../pages/profile.php?error=invalid_province');
        exit;
    }

    // Actualizar solamente al usuario autenticado.
    $statement = $conn->prepare(
        'UPDATE users
         SET full_name = :full_name,
             username = :username,
             email = :email,
             provincia_id = :provincia_id
         WHERE id = :id'
    );

    $statement->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'provincia_id' => $provinciaId,
        'id' => $_SESSION['user_id']
    ]);

    $_SESSION['username'] = $username;

    header('Location: ../pages/profile.php?updated=1');
    exit;

} catch (PDOException $exception) {
    error_log('Profile update error: ' . $exception->getMessage());

    header('Location: ../pages/profile.php?error=update_failed');
    exit;
}