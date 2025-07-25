<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Combate Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .blue-column {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 10.35%;
            background-color: #2196f3;
            z-index: 1;
        }

        .left { left: 0; border-right: 5px solid #1976d2; }
        .right { right: 0; border-left: 5px solid #1976d2; }

        .main-container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
            z-index: 2;
            position: relative;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn-custom {
            padding: 8px 16px;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .table img {
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }

        @media (max-width: 768px) {
            .blue-column { display: none; }
            .table-responsive { overflow-x: auto; }
        }
         .video-oculto {
      display: none;
    }
    </style>
</head>
<body>

    <div class="blue-column left"></div>
    <div class="blue-column right"></div>

    <div class="main-container mt-4">
        <h1 class="text-center">Combatientes Disponibles</h1>

        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('combate_online.index') }}" class="btn btn-custom btn-secondary">← Volver</a>
        </div>

        @if ($combatientes->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Usuario</th>
                            <th>Digimon</th>
                            <th>Nivel</th>
                            <th>Clasificación</th>
                            <th>Puntos</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($combatientes as $combate)
                            <tr>
                                <td>
                                 {{ $combate->digimon->usuario->nombreusuario ?? 'Sin Usuario' }} <br>
                                </td>
                                <td>
                                    <strong>{{ $combate->digimon->nombre ?? 'Desconocido' }}</strong>
                                    <img src="{{ $combate->digimon->videogif }}" alt="gif" width="100">
                                </td>
                                <td>{{ $combate->digimon->nivel ?? 'N/A' }}</td>
                                <td>{{ $combate->clasificacion }}</td>
                                <td>{{ $combate->puntos }}</td>
                                <td>
                                    <form action="{{ route('combate.defensor', $combate->id) }}" method="GET">
                                        <button type="submit" class="btn btn-custom btn-primary">Combatir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center mt-5">No hay digimons disponibles para combatir.</p>
        @endif
    </div>
@php
        $cancion = \App\Models\ListaCancion::where('nombre', 'AntesComb')->first();
    @endphp

    @if($cancion)
    <div class="video-oculto">
      <iframe width="560" height="315"
              src="https://www.youtube.com/embed/{{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}?autoplay=1&loop=1&playlist={{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}&mute=0&start=0"
              frameborder="0"
              allow="autoplay; encrypted-media"
              allowfullscreen>
      </iframe>
    </div>
    @endif
</body>
</body>
</html>
