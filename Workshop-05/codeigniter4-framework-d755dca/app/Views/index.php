<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD de productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Sistema de inventario de productos</h2>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <div class="alert alert-success">
            <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
    <?php endif; ?>

    <a href="<?= base_url('productos/crear') ?>"
       class="btn btn-primary mb-3">Agregar producto</a>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?= esc($producto['id']) ?></td>
                        <td><?= esc($producto['nombre']) ?></td>
                        <td><?= esc($producto['descripcion']) ?></td>
                        <td>₡<?= number_format($producto['precio'], 2) ?></td>
                        <td><?= esc($producto['cantidad']) ?></td>
                        <td>
                            <a href="<?= base_url('productos/editar/'.$producto['id']) ?>"
                               class="btn btn-warning btn-sm">Editar</a>

                            <form action="<?= base_url('productos/eliminar/'.$producto['id']) ?>"
                                  method="post" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                <?= csrf_field() ?>
                                <button class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($productos)): ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay productos registrados.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>