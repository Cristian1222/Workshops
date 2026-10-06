<?php

$servidor = "localhost";
$usuario = "root";
$password = "";
$baseDatos = "login";

$conn = new mysqli(
    $servidor,
    $usuario,
    $password,
    $baseDatos
);

if ($conn->connect_error) {

    die("Error de conexión: " . $conn->connect_error);

}

?>