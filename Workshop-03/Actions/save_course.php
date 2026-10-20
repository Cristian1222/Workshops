<?php
require_once __DIR__ . '/../utils/auth.php';
startAppSession();
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/courses.php?error=invalid_request');
    exit;
}

$operation = $_POST['operation'] ?? null;
$name = $_POST['name'] ?? null;
$courseCode = $_POST['course_code'] ?? null;
$description = $_POST['description'] ?? null;
$careerId = filter_input(INPUT_POST, 'career_id', FILTER_VALIDATE_INT);
$credits = filter_input(INPUT_POST, 'credits', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

// Validar tipos y contenido de los datos recibidos.
if (
    !is_string($operation) ||
    !in_array($operation, ['create', 'update'], true) ||
    !is_string($name) ||
    !is_string($courseCode) ||
    !is_string($description) ||
    $careerId === false ||
    $careerId === null ||
    $careerId < 1 ||
    $credits === false ||
    $credits === null ||
    $credits < 0 ||
    $credits > 255 ||
    ($operation === 'update' && ($id === false || $id === null || $id < 1))
) {
    header('Location: ../pages/courses.php?error=invalid_input');
    exit;
}

$name = trim($name);
$courseCode = trim($courseCode);
$description = trim($description);

if (
    $name === '' ||
    strlen($name) > 150 ||
    $courseCode === '' ||
    strlen($courseCode) > 30 ||
    $description === ''
) {
    header('Location: ../pages/courses.php?error=invalid_input');
    exit;
}

require_once __DIR__ . '/../utils/database.php';

try {
    // Comprobar que la carrera seleccionada exista.
    $stmt = $conn->prepare(
        'SELECT id FROM careers WHERE id = :id LIMIT 1'
    );
    $stmt->execute(['id' => $careerId]);

    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        header('Location: ../pages/courses.php?error=invalid_input');
        exit;
    }

    if ($operation === 'create') {
        $sql = "INSERT INTO courses
                    (name, course_code, career_id, credits, description)
                VALUES
                    (:name, :code, :career, :credits, :description)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'code' => $courseCode,
            'career' => $careerId,
            'credits' => $credits,
            'description' => $description
        ]);

        header('Location: ../pages/courses.php?success=course_created');
        exit;
    }

    // Comprobar que el curso exista antes de actualizarlo.
    $stmt = $conn->prepare(
        'SELECT id FROM courses WHERE id = :id LIMIT 1'
    );
    $stmt->execute(['id' => $id]);

    if (!$stmt->fetch(PDO::FETCH_ASSOC)) {
        header('Location: ../pages/courses.php?error=course_not_found');
        exit;
    }

    $sql = "UPDATE courses
            SET name = :name,
                course_code = :code,
                career_id = :career,
                credits = :credits,
                description = :description
            WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'code' => $courseCode,
        'career' => $careerId,
        'credits' => $credits,
        'description' => $description,
        'id' => $id
    ]);

    header('Location: ../pages/courses.php?success=course_updated');
    exit;

} catch (PDOException $exception) {
    error_log('Save course error: ' . $exception->getMessage());

    // MySQL error 1062: valor duplicado en un índice UNIQUE.
    if (
        isset($exception->errorInfo[1]) &&
        (int) $exception->errorInfo[1] === 1062
    ) {
        header('Location: ../pages/courses.php?error=duplicate_code');
        exit;
    }

    header('Location: ../pages/courses.php?error=server_error');
    exit;
}