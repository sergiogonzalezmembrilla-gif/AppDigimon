<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Depositar Digimon</title>
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


       .left {
    left: 0;
    border-right: 5px solid #1976d2;
}

.right {
    right: 0;
    border-left: 5px solid #1976d2;
}

        .container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
            padding: 40px 20px;
            background-color: #f5f7fa;
            text-align: center;
        }

        h2 {
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

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .grid-digimons {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }

        .digimon-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 48%;
            box-sizing: border-box;
        }

        .digimon-content {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .digimon-img, .placeholder-img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            border-radius: 10px;
            background-color: #f8f8f8;
        }

        .placeholder-img {
            background-color: #f8d7da;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #721c24;
        }

        .digimon-info {
            text-align: left;
            font-size: 0.95rem;
        }

        .digimon-info p {
            margin: 6px 0;
        }

        @media (max-width: 768px) {
            .digimon-card {
                width: 100%;
            }

            .blue-column {
                display: none;
            }
        }
        /* Colores por elemento */
.element-light {
    color: rgb(0, 0, 0);
    background-color: yellow;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-night {
    color: #fff;
    background-color: purple;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-machine {
    color: #fff;
    background-color: silver;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-bird {
    color: #fff;
    background-color: #87cefa;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-beast {
    color: #fff;
    background-color: orange;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-dragon {
    color: #fff;
    background-color: red;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-insect {
    color: #fff;
    background-color: green;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-water {
    color: #fff;
    background-color: blue;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.boolean-true {
    color: white;
    background-color: green;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.boolean-false {
    color: white;
    background-color: red;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.fondo-gris {
    background-color: #e0e0e0;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: bold;
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
        <h2>Selecciona un Digimon para Depositar</h2>
        <a href="{{ route('intercambio.index') }}" class="btn-custom btn-secondary">← Volver a Intercambio</a>

        <div class="grid-digimons">
            @foreach ($digimons as $digimon)
                <div class="digimon-card">
                    <p><strong>{{ $digimon->nombre }}</strong></p>
                    <div class="digimon-content">
                        @if ($digimon->videogif)
                            <img src="{{ $digimon->videogif }}" alt="Gif de {{ $digimon->nombre }}" class="digimon-img">
                        @else
                            <div class="placeholder-img">Sin imagen</div>
                        @endif

                        <div class="digimon-info">
                            <p><strong>Nivel:</strong> {{ $digimon->nivel }}</p>
                            <p><strong>Etapa:</strong> {{ ucfirst($digimon->etapa) }}</p>
@php
    $elemento = strtolower($digimon->elemento);
@endphp
<p><strong>Elemento:</strong>
    <span class="element-{{ $elemento }}">{{ ucfirst($elemento) }}</span>
</p>
                        </div>
                    </div>
                    <a href="{{ route('intercambio.seleccionar', $digimon->id) }}" class="btn-custom btn-success">Seleccionar</a>
                </div>
            @endforeach
        </div>
    </div>
 @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Deposito')->first();
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
