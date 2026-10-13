<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?error=login_required');
    exit;
}

require_once __DIR__ . '/../common/header.php';
?>

<body>
<div class="container mt-5">
    <h1 class="text-center">Welcome to My Website</h1>

    <div class="card mt-4">
        <div class="card-header text-center">
            <h4>Dashboard</h4>
        </div>

        <div class="card-body text-center">
            <p>
                Has iniciado sesión como
                <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>.
            </p>

            <a href="profile.php" class="btn btn-primary">
                Mi perfil
            </a>

            <form action="../actions/logout.php"
                  method="POST"
                  class="mt-3">
                <button type="submit" class="btn btn-danger">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
