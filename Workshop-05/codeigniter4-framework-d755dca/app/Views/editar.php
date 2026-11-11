<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-warning">
            Editar producto
        </div>

        <div class="card-body">
            <form action="<?= base_url('productos/actualizar/'.$producto['id']) ?>"
                  method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control"
                           value="<?= esc($producto['nombre']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control"><?= esc($producto['descripcion']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" name="precio" class="form-control"
                           value="<?= esc($producto['precio']) ?>"
                           min="0" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control"
                           value="<?= esc($producto['cantidad']) ?>"
                           min="0" required>
                </div>

                <button class="btn btn-success">Actualizar</button>
                <a href="<?= base_url('productos') ?>" class="btn btn-secondary">
                    Cancelar
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</html>