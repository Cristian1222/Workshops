
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Matrícula</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #ccc;
        }

        h1 {
            text-align: center;
            color: #243b64;
        }

        .exito {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .dato {
            padding: 12px 0;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            color: #243b64;
        }

        a {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background: #243b64;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Matrícula registrada</h1>

    <div class="exito">
        {{ session('success', 'La matrícula se registró correctamente.') }}
    </div>

    <h2>Detalles de la matrícula</h2>

    <div class="dato">
        <strong>Número de matrícula:</strong>
        {{ $matricula->id }}
    </div>

    <div class="dato">
        <strong>Estudiante:</strong>
        {{ $matricula->estudiante }}
    </div>

    <div class="dato">
        <strong>Identificación:</strong>
        {{ $matricula->identificacion }}
    </div>

    <div class="dato">
        <strong>Correo:</strong>
        {{ $matricula->correo }}
    </div>

    <div class="dato">
        <strong>Curso:</strong>
        {{ $matricula->curso->nombre }}
    </div>

    <div class="dato">
        <strong>Código:</strong>
        {{ $matricula->curso->codigo }}
    </div>

    <div class="dato">
        <strong>Créditos:</strong>
        {{ $matricula->curso->creditos }}
    </div>

    <div class="dato">
        <strong>Carrera:</strong>
        {{ $matricula->curso->carrera->nombre }}
    </div>

    <div class="dato">
        <strong>Fecha de matrícula:</strong>
        {{ $matricula->fecha->format('d/m/Y') }}
    </div>

    <a href="{{ route('matriculas.create') }}">
        Registrar otra matrícula
    </a>

</div>

</body>
</html>
