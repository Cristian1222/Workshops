<?php
session_start();

require_once __DIR__ . '/../utils/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
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
    !is_string($password) ||
    $password === '' ||
    strlen($password) > 4096 ||
    $provinciaId === false ||
    $provinciaId === null ||
    $provinciaId < 1
) {
    header('Location: ../pages/register.php?error=invalid_input');
    exit;
}

try {
    // Confirmar que la provincia exista.
    $statement = $conn->prepare(
        'SELECT id FROM provincias WHERE id = :id'
    );
    $statement->execute(['id' => $provinciaId]);

    if (!$statement->fetch()) {
        header('Location: ../pages/register.php?error=invalid_province');
        exit;
    }

    // Comprobar que el nombre de usuario no esté registrado.
    $statement = $conn->prepare(
        'SELECT id FROM users WHERE username = :username LIMIT 1'
    );
    $statement->execute(['username' => $username]);

    if ($statement->fetch()) {
        header('Location: ../pages/register.php?error=username_exists');
        exit;
    }

    // Crear el hash de la contraseña.
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Guardar los datos del usuario y su provincia.
    $statement = $conn->prepare(
        'INSERT INTO users
        (full_name, username, email, password_hash, provincia_id)
        VALUES
        (:full_name, :username, :email, :password_hash, :provincia_id)'
    );

    $statement->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'password_hash' => $passwordHash,
        'provincia_id' => $provinciaId
    ]);

    header('Location: ../index.php?registered=1');
    exit;

} catch (PDOException $exception) {
    error_log('Registration error: ' . $exception->getMessage());

    header('Location: ../pages/register.php?error=registration_failed');
    exit;
}