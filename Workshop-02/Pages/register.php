<?php
require_once __DIR__ . '/../utils/database.php';

$statement = $conn->query(
    'SELECT id, name FROM provincias ORDER BY name'
);
$provincias = $statement->fetchAll();

require_once __DIR__ . '/../common/header.php';
?>

<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Registro de usuario</h4>
                </div>

                <div class="card-body">
                    <form action="../actions/register.php" method="POST">

                        <div class="form-group">
                            <label for="full_name">Nombre completo</label>
                            <input type="text"
                                   class="form-control"
                                   id="full_name"
                                   name="full_name"
                                   maxlength="100"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="username">Nombre de usuario</label>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   maxlength="50"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email">Correo electrónico</label>
                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   maxlength="100"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="provincia_id">Provincia</label>
                            <select class="form-control"
                                    id="provincia_id"
                                    name="provincia_id"
                                    required>
                                <option value="">Seleccione una provincia</option>

                                <?php foreach ($provincias as $provincia): ?>
                                    <option value="<?= (int) $provincia['id'] ?>">
                                        <?= htmlspecialchars($provincia['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit"
                                class="btn btn-primary btn-block">
                            Registrarse
                        </button>
                    </form>

                    <p class="text-center mt-3">
                        ¿Ya tiene cuenta?
                        <a href="../index.php">Iniciar sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>