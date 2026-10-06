<?php

require_once "conexion.php";

$username = $_POST["username"];
$password = $_POST["password"];

$sql = "SELECT * FROM usuarios WHERE username = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $username);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {

    $usuario = $resultado->fetch_assoc();

    if ($password === $usuario["password"]) {

        header("Location: usuario.php");
        exit;

    } else {

        header("Location: index.php?error=1");
        exit;
    }

} else {

    header("Location: index.php?error=1");
    exit;
}

$stmt->close();
$conn->close();

?>