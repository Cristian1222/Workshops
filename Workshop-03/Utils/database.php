<?php

$dsn = 'mysql:host=localhost;dbname=isw613;charset=utf8mb4';
$dbUser = 'root';
$dbPassword = '';

try {
    $conn = new PDO($dsn, $dbUser, $dbPassword);

    $conn->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $conn->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $exception) {
    error_log('Database connection error: ' . $exception->getMessage());

    http_response_code(500);
    exit('No fue posible conectar con la base de datos.');
}