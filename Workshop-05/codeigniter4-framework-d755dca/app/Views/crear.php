<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Registrar nuevo producto
        </div>

        <div class="card-body">
            <form action="<?= base_url('productos/guardar') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" name="precio" class="form-control"
                           min="0" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control"
                           min="0" required>
                </div>

                <button class="btn btn-success">Guardar producto</button>
                <a href="<?= base_url('productos') ?>" class="btn btn-secondary">
                    Volver
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</html>