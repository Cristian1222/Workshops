
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Matrícula</title>

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

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 25px;
            background: #243b64;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #36558a;
        }

        .error {
            color: #c0392b;
            font-size: 14px;
        }

        .acciones {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Formulario de Matrícula</h1>

    <p>Complete sus datos y seleccione el curso que desea matricular.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Por favor, corrija los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('matriculas.store') }}" method="POST">
        @csrf

        <label for="estudiante">Nombre del estudiante:</label>
        <input
            type="text"
            id="estudiante"
            name="estudiante"
            value="{{ old('estudiante') }}"
            required
        >

        <label for="identificacion">Identificación:</label>
        <input
            type="text"
            id="identificacion"
            name="identificacion"
            value="{{ old('identificacion') }}"
            required
        >

        <label for="correo">Correo electrónico:</label>
        <input
            type="email"
            id="correo"
            name="correo"
            value="{{ old('correo') }}"
            required
        >

        <label for="curso_id">Seleccione un curso:</label>
        <select id="curso_id" name="curso_id" required>
            <option value="">-- Seleccione un curso --</option>

            @foreach ($cursos as $curso)
                <option
                    value="{{ $curso->id }}"
                    {{ old('curso_id') == $curso->id ? 'selected' : '' }}
                >
                    {{ $curso->codigo }} - {{ $curso->nombre }}
                    ({{ $curso->creditos }} créditos)
                    - {{ $curso->carrera->nombre }}
                </option>
            @endforeach
        </select>

        <button type="submit">Registrar matrícula</button>
    </form>

    <div class="acciones">
        <a href="{{ route('cursos.index') }}">Administrar cursos</a>
    </div>

</div>

</body>
</html>
