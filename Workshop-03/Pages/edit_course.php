<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    header('Location: courses.php?error=invalid_input');
    exit;
}

try {
    // Buscar el curso que se desea editar.
    $stmt = $conn->prepare(
        "SELECT id, name, course_code, career_id, credits, description
         FROM courses
         WHERE id = :id
         LIMIT 1"
    );

    $stmt->execute(['id' => $id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) {
        header('Location: courses.php?error=course_not_found');
        exit;
    }

    // Obtener las carreras disponibles.
    $stmt = $conn->prepare(
        "SELECT id, name FROM careers ORDER BY name"
    );

    $stmt->execute();
    $careers = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $exception) {
    error_log('Edit course query error: ' . $exception->getMessage());
    header('Location: courses.php?error=server_error');
    exit;
}

require_once __DIR__ . '/../common/header.php';
?>

<h2>Editar curso</h2>

<p>Modifique los datos del curso y guarde los cambios.</p>

<?php if (count($careers) === 0): ?>
    <div class="alert alert-warning">
        No hay carreras registradas. No es posible asignar una carrera al curso.
    </div>

    <a href="courses.php" class="btn btn-secondary">
        Volver a cursos
    </a>

<?php else: ?>

    <form action="../actions/save_course.php" method="POST">

        <input type="hidden" name="operation" value="update">

        <!-- ID del curso que se va a actualizar -->
        <input
            type="hidden"
            name="id"
            value="<?= (int) $course['id'] ?>"
        >

        <div class="form-group">
            <label for="name">Nombre del curso</label>
            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                maxlength="150"
                value="<?= htmlspecialchars($course['name'], ENT_QUOTES, 'UTF-8') ?>"
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
                value="<?= htmlspecialchars($course['course_code'], ENT_QUOTES, 'UTF-8') ?>"
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
                    <option
                        value="<?= (int) $career['id'] ?>"
                        <?= (int) $career['id'] === (int) $course['career_id']
                            ? 'selected'
                            : '' ?>
                    >
                        <?= htmlspecialchars($career['name'], ENT_QUOTES, 'UTF-8') ?>
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
                value="<?= (int) $course['credits'] ?>"
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
            ><?= htmlspecialchars($course['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar cambios
        </button>

        <a href="courses.php" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

<?php endif; ?>

<?php require_once __DIR__ . '/../common/footer.php'; ?>