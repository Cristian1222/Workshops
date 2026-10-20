<?php
require_once __DIR__ . '/../utils/auth.php';
requireLogin();

require_once __DIR__ . '/../utils/database.php';

$sql = "SELECT
            courses.id,
            courses.name,
            courses.course_code,
            courses.career_id,
            careers.name AS career_name,
            courses.credits,
            courses.description
        FROM courses
        INNER JOIN careers ON courses.career_id = careers.id
        ORDER BY courses.id DESC";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    error_log('Courses query error: ' . $exception->getMessage());
    header('Location: dashboard.php?error=server_error');
    exit;
}

require_once __DIR__ . '/../common/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Lista de cursos</h2>

    <a href="create_course.php" class="btn btn-primary">
        Crear curso
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Nombre</th>
                <th>Código</th>
                <th>ID carrera</th>
                <th>Carrera</th>
                <th>Créditos</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($courses) > 0): ?>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($course['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($course['course_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= (int) $course['career_id'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($course['career_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= (int) $course['credits'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($course['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <a
                                href="edit_course.php?id=<?= (int) $course['id'] ?>"
                                class="btn btn-warning btn-sm mb-1"
                            >
                                Editar
                            </a>

                            <form
                                action="../actions/delete_course.php"
                                method="POST"
                                onsubmit="return confirm('¿Desea eliminar este curso?');"
                            >
                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= (int) $course['id'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                >
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">
                        No hay cursos registrados.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>