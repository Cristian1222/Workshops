<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit;
}

$fullName = trim($_POST['full_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (
    $fullName === '' ||
    strlen($fullName) > 100 ||
    $username === '' ||
    strlen($username) > 50 ||
    $email === '' ||
    strlen($email) > 100 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    !is_string($password) ||
    $password === ''
) {
    header('Location: ../pages/register.php?error=1');
    exit;
}

require_once '../utils/database.php';

try {
    $stmt = $conn->prepare(
        "SELECT id FROM users WHERE username = :username LIMIT 1"
    );
    $stmt->execute(['username' => $username]);

    if ($stmt->fetch()) {
        header('Location: ../pages/register.php?error=1');
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users
                (full_name, username, email, password_hash)
            VALUES
                (:full_name, :username, :email, :password_hash)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'full_name' => $fullName,
        'username' => $username,
        'email' => $email,
        'password_hash' => $passwordHash
    ]);

    header('Location: ../index.php?registered=1');
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());

    header('Location: ../pages/register.php?error=1');
    exit;
}