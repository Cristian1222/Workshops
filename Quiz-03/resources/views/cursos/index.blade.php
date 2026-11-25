<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #263b5e;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            background: #263b5e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #263b5e;
            color: white;
        }

        .acciones {
            display: flex;
            gap: 8px;
        }

        .editar {
            background: #198754;
        }

        .eliminar {
            background: #dc3545;
        }

        .mensaje {
            background: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Gestión de Cursos</h1>

        <p>Administración de los cursos disponibles en el sistema.</p>

        @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
        @endif

        <a href="{{ route('cursos.create') }}" class="boton">
            Registrar nuevo curso
        </a>
        
        <a href="{{ route('matriculas.create') }}" class="boton">
            Volver a Matrículas
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Créditos</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($cursos as $curso)
                <tr>
                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->nombre }}</td>
                    <td>{{ $curso->codigo }}</td>
                    <td>{{ $curso->creditos }}</td>
                    <td>{{ $curso->carrera->nombre }}</td>

                    <td>
                        <div class="acciones">

                            <a href="{{ route('cursos.show', $curso) }}" class="boton">
                                Ver
                            </a>

                            <a href="{{ route('cursos.edit', $curso) }}"
                                class="boton editar">
                                Editar
                            </a>

                            <form action="{{ route('cursos.destroy', $curso) }}"
                                method="POST"
                                onsubmit="return confirm('¿Desea eliminar este curso?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="boton eliminar">
                                    Eliminar
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">No hay cursos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</body>

</html>