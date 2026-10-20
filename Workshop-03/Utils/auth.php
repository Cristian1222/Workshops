<?php

require_once __DIR__ . '/messages.php';

/**
 * Inicia la sesión si todavía no está iniciada.
 */
function startAppSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/**
 * Verifica que el usuario haya iniciado sesión.
 */
function requireLogin(): void
{
    startAppSession();

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../index.php?error=login_required');
        exit;
    }
}

/**
 * Redirige al login si el usuario ya tiene una sesión activa.
 */
function redirectIfAuthenticated(): void
{
    startAppSession();

    if (isset($_SESSION['user_id'])) {
        header('Location: pages/dashboard.php');
        exit;
    }
}