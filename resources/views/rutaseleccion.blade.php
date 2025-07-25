<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selecciona tu Ruta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            text-align: center;
            position: relative;
        }

        h2 {
            margin-top: 30px;
            color: #444;
        }

        .leyenda {
            margin-top: 10px;
        }

        .leyenda span {
            display: inline-block;
            margin: 0 10px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            color: white;
        }

        .facil { background-color: #4caf50; }         /* Verde */
        .media { background-color: #2196f3; }         /* Azul */
        .dificil { background-color: #ff9800; }       /* Naranja */
        .muy-dificil { background-color: #f44336; }   /* Rojo */

        .rutas {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
        }

        .ruta {
            margin: 20px;
            padding: 15px;
            border: 2px solid #2196f3;
            border-radius: 10px;
            background-color: #fff;
            width: 220px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }

        .ruta:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0,0,0,0.15);
        }

        .ruta img {
            width: 200px;
            height: 140px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .ruta img:hover {
            transform: scale(1.05);
        }

        .ruta h3 {
            margin: 10px 0 5px;
            color: #1976d2;
        }

        .dificultad {
            margin: 5px 0 10px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 10px;
            color: white;
            font-size: 14px;
        }

        form button {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            background-color: #4caf50;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #388e3c;
        }

        .volver-home {
            position: absolute;
            top: 20px;
            left: 30px;
        }

        .volver-home a {
            padding: 10px 20px;
            background-color: #2196f3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .volver-home a:hover {
            background-color: #1976d2;
        }
         .video-oculto {
      display: none;
    }
    </style>
</head>
<body>

<div class="volver-home">
    <a href="{{ route('home') }}">Volver a Home</a>
</div>

<h2>Selecciona tu Ruta de Aventura</h2>

<div class="leyenda">
    <span class="facil">Fácil</span>
    <span class="media">Media</span>
    <span class="dificil">Difícil</span>
    <span class="muy-dificil">Muy Difícil</span>
</div>

<div class="rutas">
    @foreach($rutas as $ruta)
        @php
            $colorClase = match($ruta['dificultad']) {
                'fácil' => 'facil',
                'media' => 'media',
                'difícil' => 'dificil',
                'muy difícil' => 'muy-dificil',
                default => '',
            };
        @endphp

        <div class="ruta">
            <h3>{{ $ruta['nombre'] }}</h3>
            <img src="{{ $ruta['imagen'] }}" alt="Imagen de la ruta">
            <div class="dificultad {{ $colorClase }}"></div>
            <form action="{{ route('combate.iniciar') }}" method="POST">
                @csrf
                <input type="hidden" name="nombre_ruta" value="{{ $ruta['nombre'] }}">
                <input type="hidden" name="dificultad" value="{{ $ruta['dificultad'] }}">
                <button type="submit">Explorar</button>
            </form>
        </div>
    @endforeach
</div>
  @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Ruta')->first();
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
