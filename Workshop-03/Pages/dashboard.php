<?php

require_once __DIR__ . '/../utils/auth.php';

// Verificar que el usuario haya iniciado sesión.
requireLogin();

require_once __DIR__ . '/../common/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card mt-4">

            <div class="card-header text-center">
                <h4>Dashboard</h4>
            </div>

            <div class="card-body text-center">

                <h2>Welcome to My Website</h2>

                <p class="mt-3">
                    Has iniciado sesión como
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['username'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </strong>.
                </p>

                <hr>

                <p>Selecciona la opción que deseas utilizar:</p>

                <div class="d-flex flex-column">

                    <a href="profile.php"
                       class="btn btn-primary mb-2">
                        Mi perfil
                    </a>

                    <a href="courses.php"
                       class="btn btn-success mb-2">
                        Administrar cursos
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
