<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Curso</title>

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

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            background: #263b5e;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .errores {
            background: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Registrar nuevo curso</h1>

    @if($errors->any())
        <div class="errores">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cursos.store') }}" method="POST">

        @csrf

        <label for="nombre">Nombre del curso:</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="{{ old('nombre') }}"
            maxlength="150"
            required
        >

        <label for="codigo">Código:</label>
        <input
            type="text"
            id="codigo"
            name="codigo"
            value="{{ old('codigo') }}"
            maxlength="20"
            required
        >

        <label for="creditos">Créditos:</label>
        <input
            type="number"
            id="creditos"
            name="creditos"
            value="{{ old('creditos') }}"
            min="1"
            max="255"
            required
        >

        <label for="carrera_id">Carrera:</label>
        <select id="carrera_id" name="carrera_id" required>
            <option value="">Seleccione una carrera</option>

            @foreach($carreras as $carrera)
                <option
                    value="{{ $carrera->id }}"
                    {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}
                >
                    {{ $carrera->nombre }}
                </option>
            @endforeach

        </select>

        <button type="submit" class="boton">
            Guardar curso
        </button>

        <a href="{{ route('cursos.index') }}" class="boton">
            Volver
        </a>

    </form>

</div>

</body>
</html>