<?php
require_once '../common/header.php';
?>

<h2>Crear cuenta</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        No se pudo completar el registro. Verifique los datos e inténtelo de nuevo.
    </div>
<?php endif; ?>

<form action="../actions/register.php" method="POST">
    <div class="form-group">
        <label for="full_name">Nombre completo</label>
        <input
            type="text"
            class="form-control"
            id="full_name"
            name="full_name"
            maxlength="100"
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
            required
        >
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <input
            type="password"
            class="form-control"
            id="password"
            name="password"
            required
        >
    </div>

    <button type="submit" class="btn btn-primary">
        Registrarse
    </button>

    <a href="../index.php" class="btn btn-secondary">
        Volver al inicio
    </a>
</form>

<?php require_once '../common/footer.php'; ?>