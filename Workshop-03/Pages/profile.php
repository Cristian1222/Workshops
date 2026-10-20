<?php

require_once __DIR__ . '/../utils/auth.php';

// Verificar que el usuario haya iniciado sesión.
requireLogin();

require_once __DIR__ . '/../utils/database.php';

try {
    $stmt = $conn->prepare(
        'SELECT id, full_name, username, email
         FROM users
         WHERE id = :id
         LIMIT 1'
    );

    $stmt->execute([
        'id' => $_SESSION['user_id']
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $exception) {
    error_log('Profile query error: ' . $exception->getMessage());

    header('Location: dashboard.php?error=server_error');
    exit;
}

// Si el usuario ya no existe, cerrar la sesión.
if (!$user) {
    $_SESSION = [];
    session_destroy();

    header('Location: ../index.php?error=session_expired');
    exit;
}

require_once __DIR__ . '/../common/header.php';
?>

<h2>Mi perfil</h2>

<p>Consultá y actualizá tus datos personales.</p>

<form action="../actions/update_profile.php" method="POST">

    <div class="form-group">
        <label for="full_name">Nombre completo</label>

        <input
            type="text"
            class="form-control"
            id="full_name"
            name="full_name"
            maxlength="100"
            value="<?= htmlspecialchars(
                $user['full_name'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >
    </div>

    <div class="form-group">
        <label for="username">Nombre de usuario</label>

        <input
            type="text"
            class="form-control"
            id="username"
            name="username"
            maxlength="50"
            value="<?= htmlspecialchars(
                $user['username'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >
    </div>

    <div class="form-group">
        <label for="email">Correo electrónico</label>

        <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            maxlength="100"
            value="<?= htmlspecialchars(
                $user['email'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
            required
        >
    </div>

    <button type="submit" class="btn btn-primary">
        Guardar cambios
    </button>

    <a href="courses.php" class="btn btn-secondary">
        Ir a cursos
    </a>

</form>

<?php require_once __DIR__ . '/../common/footer.php'; ?>