<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Cargar los mensajes
require_once __DIR__ . '/../utils/messages.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workshop 03</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"
    >
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/pages/courses.php">
        Workshop 03
    </a>

    <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#mainMenu"
        aria-controls="mainMenu"
        aria-expanded="false"
        aria-label="Mostrar navegación"
    >
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainMenu">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/pages/profile.php">
                    Perfil
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/pages/courses.php">
                    Cursos
                </a>
            </li>
        </ul>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="/actions/logout.php" method="POST">
                <button type="submit" class="btn btn-outline-light">
                    Cerrar sesión
                </button>
            </form>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-4">

    <?php
    // 2. Mostrar los mensajes de éxito o error
    renderAlert();
    ?>