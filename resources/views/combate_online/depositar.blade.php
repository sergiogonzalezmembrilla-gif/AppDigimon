<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Digimon</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: auto;
            font-family: 'Arial', sans-serif;
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

        .container {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
            background-color: #f5f7fa;
            text-align: center;
            z-index: 2;
        }

        .digimon-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: left;
        }

        .digimon-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            margin-right: 20px;
        }

        .digimon-info {
            flex-grow: 1;
        }

        .digimon-info p {
            margin: 4px 0;
            font-weight: bold;
        }

        .element-light { background-color: yellow; color: #000; }
        .element-night { background-color: purple; color: #fff; }
        .element-machine { background-color: silver; color: #fff; }
        .element-bird { background-color: #87cefa; color: #fff; }
        .element-beast { background-color: orange; color: #fff; }
        .element-dragon { background-color: red; color: #fff; }
        .element-insect { background-color: green; color: #fff; }
        .element-water { background-color: blue; color: #fff; }

        .element-label {
            padding: 3px 8px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }

        .btn {
            padding: 8px 15px;
            font-weight: bold;
            border-radius: 8px;
            text-decoration: none;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        @media (max-width: 768px) {
            .digimon-card {
                flex-direction: column;
                text-align: center;
            }

            .digimon-img {
                margin-right: 0;
                margin-bottom: 15px;
            }
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
        <h2>Selecciona un Digimon para Combatir</h2>
        <a href="{{ route('combate_online.index') }}" class="btn btn-secondary mb-4">← Volver</a>

        <div class="row">
    @foreach ($digimons as $digimon)
        <div class="col-md-4">
            <div class="digimon-card">
                <img src="{{ $digimon->videogif }}" alt="{{ $digimon->nombre }}" class="digimon-img">

                <div class="digimon-info">
                    <p><strong>{{ $digimon->nombre }}</strong></p>
                    <p>Nivel: <span class="fondo-gris">{{ $digimon->nivel }}</span></p>
                    <p>Etapa: <span class="fondo-gris">{{ $digimon->etapa }}</span></p>
                    <p>Elemento:
                        <span class="element-label element-{{ strtolower($digimon->elemento) }}">
                            {{ ucfirst($digimon->elemento) }}
                        </span>
                    </p>
                    <a href="{{ route('combate_online.depositar', $digimon->id) }}" class="btn btn-success mt-2">Seleccionar</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

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
