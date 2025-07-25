<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenamiento</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f0f4f8;
        }

        .blue-column {
            width: 11.2%;
            background-color: #2196f3;
        }

        .left {
            border-right: 5px solid #1976d2;
        }

        .right {
            border-left: 5px solid #1976d2;
        }

        .container {
            width: 84%;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            color: #2e7d32;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .stats-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            background-color: #e8f5e9;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .stats-info p {
            margin: 0;
            font-weight: bold;
        }

        .video-background-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            gap: 20px;
        }

        .video-gif-container {
            background-image: url('https://i.imgur.com/qN00ZvO.jpg');
            background-size: cover;
            background-position: center;
            padding: 8px;
            border-radius: 12px;
            border: 4px solid #4caf50;
        }

        .video-gif {
            width: 200px;
            height: auto;
            border-radius: 8px;
        }

        .background-container {
            background-image: url('https://i.imgur.com/qA60r2K.jpg');
            background-size: cover;
            background-position: center;
            padding: 150px 50px;
            border-radius: 12px;
            width: 60%;
            border: 5px solid #4caf50;
            position: relative;
            overflow: hidden;
        }

        .animation-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            background-color: rgba(255, 255, 255, 0.7);
            display: none;
            z-index: 10;
        }

        .btn-container {
            margin-top: 25px;
        }

        button {
            padding: 12px 20px;
            background-color: #66bb6a;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin: 8px;
            transition: background 0.3s, transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        button:hover {
            background-color: #388e3c;
            transform: translateY(-2px);
        }

        button:disabled {
            background-color: #bdbdbd;
            cursor: not-allowed;
        }

        .alert {
            margin-top: 10px;
            font-weight: bold;
            padding: 10px;
            border-radius: 6px;
        }

        .alert-error {
            background-color: #ffcdd2;
            color: #c62828;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        a.btn-secondary {
            display: inline-block;
            margin-top: 20px;
            background-color: #90a4ae;
            padding: 10px 18px;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        a.btn-secondary:hover {
            background-color: #607d8b;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }

        @media (max-width: 768px) {
            .background-container {
                width: 100%;
            }

            .container {
                width: 100%;
                padding: 15px;
            }

            .blue-column {
                display: none;
            }
        }
         .video-oculto {
      display: none;
    }
    </style>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
        <h1>Entrenamiento de {{ $digimon->nombre }}</h1>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if($digimon->haAlcanzadoPotencialMaximo())
            <div class="alert alert-error">¡{{ $digimon->nombre }} ha alcanzado su potencial máximo!</div>
        @elseif(!$digimon->puedeEntrenar())
            <div class="alert alert-warning">{{ $digimon->nombre }} necesita madurar más. Ya entrenó al máximo permitido por ahora.</div>
        @endif

        <div class="stats-info">
            <p>| Nivel Actual: {{ $digimon->nivel }} |</p>
            <p>| Vida Actual: {{ $digimon->vidaActual() }}</p>
            <p>Ataque Actual: {{ $digimon->ataqueActual() }}</p>
            <p>Defensa Actual: {{ $digimon->defensaActual() }} |</p>
            <p>| Entrenamientos restantes: {{ $digimon->entrenamientosMaximos() - $digimon->numentrenamientos }} |</p>
        </div>

        <div class="video-background-container">
            <div class="video-gif-container">
                @if($digimon->videogif)
                    <img src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $digimon->videogif) }}" alt="{{ $digimon->nombre }}" class="video-gif">
                @else
                    <p>No se encontró el gif del Digimon.</p>
                @endif
            </div>

            <div class="background-container">
                <div id="animationOverlay" class="animation-overlay"></div>
            </div>
        </div>

        <form id="trainForm" method="POST" action="{{ route('entrenar.subir') }}">
            @csrf
            <input type="hidden" name="digimon_id" value="{{ $digimon->id }}">

            <div class="btn-container">
               

                <button type="button" onclick="playAnimation('vida', this)" {{ !$digimon->puedeEntrenar() ? 'disabled' : '' }}>
                    Entrenamiento vigoroso con Monmon
                    <img src="https://i.imgur.com/sg7a2at.png" alt="Monmon" style="height: 24px;">
                </button>

                <button type="button" onclick="playAnimation('ataque', this)" {{ !$digimon->puedeEntrenar() ? 'disabled' : '' }}>
                    Entrenamiento Ofensivo con Patamon
                    <img src="https://i.imgur.com/4ql97bd.png" alt="Patamon" style="height: 24px;">
                </button>

                <button type="button" onclick="playAnimation('defensa', this)" {{ !$digimon->puedeEntrenar() ? 'disabled' : '' }}>
                    Entrenamiento Defensivo con Kotemon
                    <img src="https://i.imgur.com/583KNDh.png" alt="Kotemon" style="height: 24px;">
                </button>
            </div>
        </form>

        <a href="{{ route('home') }}" class="btn-secondary">Volver al menú</a>
    </div>

    <div class="blue-column right"></div>

    <script>
        function playAnimation(type, btn) {
            const overlay = document.getElementById('animationOverlay');
            const form = document.getElementById('trainForm');
            const buttons = form.querySelectorAll('button');

            const animations = {
                vida: 'https://i.imgur.com/zsqH2QZ.gif',
                ataque: 'https://i.imgur.com/0Ml8siM.gif',
                defensa: 'https://i.imgur.com/1wbQTJF.gif'
            };

            if (!animations[type]) return;

            overlay.style.backgroundImage = `url('${animations[type]}')`;
            overlay.style.display = 'block';

            buttons.forEach(b => b.disabled = true);
            form.classList.add('disabled');

            setTimeout(() => {
                overlay.style.display = 'none';
                buttons.forEach(b => b.disabled = false);
                form.classList.remove('disabled');

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'atributo';
                input.value = type;
                form.appendChild(input);
                form.submit();
            }, 3000);
        }
    </script>
      @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Entrenar')->first();
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
