<?php

const MESSAGES = [
    'error' => [
        'invalid_input' => 'Complete los campos correctamente.',
        'invalid_credentials' => 'Usuario o contraseña incorrectos.',
        'login_required' => 'Debe iniciar sesión para acceder a esa página.',
        'session_expired' => 'La sesión expiró. Inicie sesión nuevamente.',
        'server_error' => 'Ocurrió un error. Inténtelo más tarde.',
        'course_not_found' => 'No se encontró el curso solicitado.',
        'duplicate_code' => 'Ese código de curso ya está registrado.',
        'invalid_request' => 'La solicitud no es válida.',
    ],
    'success' => [
        'course_created' => 'El curso se creó correctamente.',
        'course_updated' => 'El curso se actualizó correctamente.',
        'course_deleted' => 'El curso se eliminó correctamente.',
        'logged_out' => 'Sesión cerrada correctamente.',
        'profile_updated' => 'Tu perfil se actualizó correctamente.',
    ],
];

function renderAlert(): void
{
    foreach (['error' => 'danger', 'success' => 'success'] as $type => $style) {
        $code = $_GET[$type] ?? null;

        if (is_string($code) && isset(MESSAGES[$type][$code])) {
            echo '<div class="alert alert-' . $style . '" role="alert">'
                . htmlspecialchars(
                    MESSAGES[$type][$code],
                    ENT_QUOTES,
                    'UTF-8'
                )
                . '</div>';
        }
    }
}
