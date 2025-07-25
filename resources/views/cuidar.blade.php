<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuidar a tu Digimon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            height: 100vh;
            overflow-y: auto;
        }

        .blue-column {
            width: 10%;
            background-color: #2196f3;
        }

        .left {
            border-right: 5px solid #1976d2;
        }

        .right {
            border-left: 5px solid #1976d2;
        }

        .container {
            flex: 1;
            max-width: 1000px;
            padding: 30px;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            margin: 30px auto;
            text-align: center;
        }

        h2 {
            color: #2e7d32;
            margin-bottom: 20px;
        }

        .digimon {
            background-color: #fafafa;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .digimon img {
            width: 180px;
            border-radius: 10px;
        }

        .stats {
            margin-top: 20px;
        }

        .inline-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
        }

        .inline-stats p {
            flex: 1;
            min-width: 130px;
            background: #e3f2fd;
            padding: 10px;
            border-radius: 10px;
            color: #333;
        }

        .inline-stats span {
            font-weight: 600;
            color: #2e7d32;
        }

        .button-row {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 15px;
            gap: 10px;
        }

        .increment-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-direction: row;
        }

        button {
            padding: 10px 16px;
            background-color: #66bb6a;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.3s ease;
        }

        button:hover:not(:disabled) {
            background-color: #388e3c;
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            color: #888;
        }

        .video-oculto {
            display: none;
        }

        .button-container {
            margin-top: 25px;
        }

        .button-container button {
            background-color: #42a5f5;
        }

        .button-container button:hover {
            background-color: #1e88e5;
        }

        .digimon-info {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .digimon-info span {
            color: #2e7d32;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="blue-column left"></div>
    <div class="container">
        @if($digimon)
        @php
            $usuario = Auth::user();
            $bono = min(50, $digimon->num_evoluciones + $digimon->bonoinvolucion);
            $costos = [
                50 => 100 + ($bono * 25),
                100 => 200 + ($bono * 50)
            ];
            $hambreFull = $digimon->hambre >= 100;
            $saludFull = $digimon->salud >= 100;
            $higieneFull = $digimon->higiene >= 100;
            $cacaFull = $digimon->caca >= 100;
        @endphp

        <div class="digimon">
            <div class="digimon-info">
                <strong>{{ $digimon->nombre }}</strong> | Felicidad: <span>{{ $digimon->felicidad }}</span> | Dinero actual: 💰 <span>{{ $usuario->dinero }}</span>
            </div>

            <div style="background: url('https://i.imgur.com/pY6nnmQ.png') center/cover no-repeat; padding: 20px; border: 4px solid #388e3c; border-radius: 10px; display: inline-block;">
                <img src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $digimon->videogif) }}" alt="GIF del Digimon">
            </div>

            <div class="stats">
                <div class="inline-stats">
                    <p>Hambre: <span>{{ $digimon->hambre }}</span></p>
                    <p>Salud: <span>{{ $digimon->salud }}</span></p>
                </div>

                <div class="button-row">
                    <div class="increment-buttons">
                        @foreach([50, 100] as $pct)
                            <form action="{{ route('incrementar.hambre', ['id' => $digimon->id, 'porcentaje' => $pct]) }}" method="POST">
                                @csrf
                                <button type="submit" {{ ($usuario->dinero < $costos[$pct] || $hambreFull) ? 'disabled' : '' }}>
                                    +{{ $pct }}% Hambre ({{ $costos[$pct] }}💰)
                                </button>
                            </form>
                        @endforeach
                    </div>

                    <div class="increment-buttons">
                        @foreach([50, 100] as $pct)
                            <form action="{{ route('incrementar.salud', ['id' => $digimon->id, 'porcentaje' => $pct]) }}" method="POST">
                                @csrf
                                <button type="submit" {{ ($usuario->dinero < $costos[$pct] || $saludFull) ? 'disabled' : '' }}>
                                    +{{ $pct }}% Salud ({{ $costos[$pct] }}💰)
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="inline-stats">
                    <p>Higiene: <span>{{ $digimon->higiene }}</span></p>
                    <p>Caca: <span>{{ $digimon->caca }}</span></p>
                </div>

                <div class="button-row">
                    <div class="increment-buttons">
                        @foreach([50, 100] as $pct)
                            <form action="{{ route('incrementar.higiene', ['id' => $digimon->id, 'porcentaje' => $pct]) }}" method="POST">
                                @csrf
                                <button type="submit" {{ ($usuario->dinero < $costos[$pct] || $higieneFull) ? 'disabled' : '' }}>
                                    +{{ $pct }}% Higiene ({{ $costos[$pct] }}💰)
                                </button>
                            </form>
                        @endforeach
                    </div>

                    <div class="increment-buttons">
                        @foreach([50, 100] as $pct)
                            <form action="{{ route('incrementar.caca', ['id' => $digimon->id, 'porcentaje' => $pct]) }}" method="POST">
                                @csrf
                                <button type="submit" {{ ($usuario->dinero < $costos[$pct] || $cacaFull) ? 'disabled' : '' }}>
                                    +{{ $pct }}% Caca ({{ $costos[$pct] }}💰)
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        @else
            <p>No tienes un Digimon activo en este momento.</p>
        @endif

        @php
            $cancion = \App\Models\ListaCancion::where('nombre', 'Cuidar')->first();
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

        <div class="button-container">
            <a href="{{ route('home') }}">
                <button>Volver a Inicio</button>
            </a>
        </div>
    </div>
    <div class="blue-column right"></div>
</body>
</html>
