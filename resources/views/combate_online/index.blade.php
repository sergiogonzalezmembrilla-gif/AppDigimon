<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona de Combate Online</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        .blue-column {
            position: fixed;
            top: 0;
            bottom: 0;
            width: 10%;
            background-color: #2196f3;
            z-index: 1;
        }

        .left { left: 0; border-right: 5px solid #1976d2; }
        .right { right: 0; border-left: 5px solid #1976d2; }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
            padding: 40px 20px;
            background-color: #f5f7fa;
            text-align: center;
            z-index: 2;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }

        .btn-custom {
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 10px 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #5a6268; }

        .btn-primary { background-color: #007bff; }
        .btn-primary:hover { background-color: #0069d9; }

        .btn-info { background-color: #17a2b8; }
        .btn-info:hover { background-color: #138496; }

        .btn-danger { background-color: #dc3545; }
        .btn-danger:hover { background-color: #c82333; }

        .digimon-box {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .digimon-img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            margin: 15px 0;
        }

        .stats {
            background-color: #e3e3e3;
            border-radius: 8px;
            padding: 10px 15px;
            font-weight: bold;
            margin-top: 15px;
            display: inline-block;
        }

        .stats p {
            margin: 0;
            display: inline;
            margin-right: 20px;
        }

        @media (max-width: 768px) {
            .blue-column { display: none; }
            .stats p { display: block; margin: 5px 0; }
        }
        .video-oculto {
      display: none;
    }
    </style>
</head>
<body>

    <div class="blue-column left"></div>
    <div class="blue-column right"></div>

    <div class="container">
        <h1>Zona de Combate Online</h1>

        <a href="{{ route('home') }}" class="btn-custom btn-secondary">← Volver a Home</a>
        <a href="{{ route('combate_online.buscar') }}" class="btn-custom btn-info">Buscar Combate</a>

        @if (!$combate || $combate->id_digimon_defensor == NULL)
            <a href="{{ route('combate_online.depositar.form') }}" class="btn-custom btn-primary">Depositar Digimon para Combatir</a>

            <div class="digimon-box">
                <p>No tienes un Digimon actualmente en combate.</p>

                @if($combate && $combate->digimon && $combate->digimon->videogif)
                    <img src="{{ $combate->digimon->videogif }}" alt="Digimon" class="digimon-img">
                @endif

                <div class="stats">
                    <p>Clasificación: {{ $combate->clasificacion ?? 'N/A' }}</p>
                    <p>Victorias: {{ $combate->victorias ?? 0 }}</p>
                    <p>Derrotas: {{ $combate->derrotas ?? 0 }}</p>
                </div>
            </div>
        @else
            <div class="digimon-box">
    <h4>{{ $combate->digimon->nombre }}</h4>

    <div>
        <img src="{{ $combate->digimon->videogif }}" alt="{{ $combate->digimon->nombre }}" class="digimon-img">
    </div>

    <div class="stats">
        <p>Clasificación: {{ $combate->clasificacion }}</p>
        <p>Victorias: {{ $combate->victorias }}</p>
        <p>Derrotas: {{ $combate->derrotas }}</p>
    </div>

    <form action="{{ route('combate_online.retirar') }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn-custom btn-danger">Retirar Digimon</button>
    </form>
</div>

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
</html>
