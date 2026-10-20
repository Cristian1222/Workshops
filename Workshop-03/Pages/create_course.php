<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';

try {
    $stmt = $conn->prepare(
        "SELECT id, name FROM careers ORDER BY name"
    );
    $stmt->execute();

    $careers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    error_log('Careers query error: ' . $exception->getMessage());
    header('Location: courses.php?error=server_error');
    exit;
}

require_once __DIR__ . '/../common/header.php';
?>

<h2>Crear curso</h2>

<p>Complete los datos para registrar un nuevo curso.</p>

<?php if (count($careers) === 0): ?>
    <div class="alert alert-warning">
        No hay carreras registradas. Debe agregar carreras
        en la tabla careers antes de crear cursos.
    </div>

    <a href="courses.php" class="btn btn-secondary">
        Volver a cursos
    </a>

<?php else: ?>

    <form action="../actions/save_course.php" method="POST">

        <input type="hidden" name="operation" value="create">

        <div class="form-group">
            <label for="name">Nombre del curso</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                maxlength="150"
                required
            >
        </div>

        <div class="form-group">
            <label for="course_code">Código de curso</label>
            <input
                type="text"
                class="form-control"
                id="course_code"
                name="course_code"
                maxlength="30"
                required
            >
        </div>

        <div class="form-group">
            <label for="career_id">Carrera</label>
            <select
                class="form-control"
                id="career_id"
                name="career_id"
                required
            >
                <option value="">Seleccione una carrera</option>

                <?php foreach ($careers as $career): ?>
                    <option value="<?= (int) $career['id'] ?>">
                        <?= htmlspecialchars(
                            $career['name'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="credits">Créditos</label>
            <input
                type="number"
                class="form-control"
                id="credits"
                name="credits"
                min="0"
                max="255"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Descripción del curso</label>
            <textarea
                class="form-control"
                id="description"
                name="description"
                rows="4"
                required
            ></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar curso
        </button>

        <a href="courses.php" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

<?php endif; ?>

<?php require_once __DIR__ . '/../common/footer.php'; ?>