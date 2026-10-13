<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?error=login_required');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

$statement = $conn->prepare(
    'SELECT
        u.id,
        u.full_name,
        u.username,
        u.email,
        u.provincia_id,
        p.name AS provincia_name
     FROM users u
     LEFT JOIN provincias p ON u.provincia_id = p.id
     WHERE u.id = :id
     LIMIT 1'
);

$statement->execute([
    'id' => $_SESSION['user_id']
]);

$user = $statement->fetch();

if (!$user) {
    $_SESSION = [];
    session_destroy();

    header('Location: ../index.php?error=user_not_found');
    exit;
}

// Mantener actualizado el nombre de usuario de la sesión.
$_SESSION['username'] = $user['username'];

$provinciaStatement = $conn->query(
    'SELECT id, name FROM provincias ORDER BY name'
);
$provincias = $provinciaStatement->fetchAll();

require_once __DIR__ . '/../common/header.php';
?>

<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>Mi perfil</h3>
        </div>

        <div class="card-body">
            <form action="../actions/update_profile.php" method="POST">

                <div class="form-group">
                    <label for="full_name">Nombre completo</label>
                    <input type="text"
                           class="form-control"
                           id="full_name"
                           name="full_name"
                           maxlength="100"
                           value="<?= htmlspecialchars($user['full_name'] ?? '') ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="username">Nombre de usuario</label>
                    <input type="text"
                           class="form-control"
                           id="username"
                           name="username"
                           maxlength="50"
                           value="<?= htmlspecialchars($user['username']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           maxlength="100"
                           value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="provincia_id">Provincia</label>
                    <select class="form-control"
                            id="provincia_id"
                            name="provincia_id"
                            required>
                        <?php foreach ($provincias as $provincia): ?>
                            <option
                                value="<?= (int) $provincia['id'] ?>"
                                <?= (int) $user['provincia_id'] === (int) $provincia['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($provincia['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    Actualizar perfil
                </button>

                <a href="dashboard.php" class="btn btn-secondary">
                    Volver
                </a>
            </form>

            <p class="mt-3">
                <strong>Provincia actual:</strong>
                <?= htmlspecialchars($user['provincia_name'] ?? 'Sin provincia') ?>
            </p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>