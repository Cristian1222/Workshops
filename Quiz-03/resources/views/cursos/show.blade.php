<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #263b5e;
        }

        .dato {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            background: #263b5e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Detalles del curso</h1>

    <div class="dato">
        <strong>ID:</strong> {{ $curso->id }}
    </div>

    <div class="dato">
        <strong>Nombre:</strong> {{ $curso->nombre }}
    </div>

    <div class="dato">
        <strong>Código:</strong> {{ $curso->codigo }}
    </div>

    <div class="dato">
        <strong>Créditos:</strong> {{ $curso->creditos }}
    </div>

    <div class="dato">
        <strong>Carrera:</strong> {{ $curso->carrera->nombre }}
    </div>

    <a href="{{ route('cursos.index') }}" class="boton">
        Volver al listado
    </a>

</div>

</body>
</html>