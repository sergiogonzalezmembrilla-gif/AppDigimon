<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combate</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            color: #333;
            background-image: url('{{ $rutaImagen }}'); 
            background-size: cover; 
            background-position: center; 
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
            width: 80%;
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.7); 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    
        h1, h2, h3 {
            color: #ffffff;
        }
    
        .digimon-combat {
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            gap: 40px; 
            background-image: url('{{ $rutaImagen }}'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 10px;
            padding: 20px;
        }

        .digimon {
            flex: 1; /* Cada Digimon ocupa un espacio igual */
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .digimon img {
            width: 180px;
            border-radius: 10px;
            margin: 10px 0;
        }

        
        .digimon img.enemigo {
            transform: scaleX(-1); /* Invierte horizontalmente la imagen */
        }
    
        .stats {
            display: flex; 
            justify-content: center;
            gap: 20px; 
            margin: 10px 0;
        }

        .stats p {
            font-size: 16px;
            color: #000000;
            margin: 0;
        }
    
        .stats span {
            font-weight: bold;
            color: #ffffff;
        }
    
        .mensaje-combate {
    margin: 15px 0;
    padding: 10px;
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
    border-radius: 5px;
    color: #856404;
    min-height: 50px; 
    display: flex;
    align-items: center; 
}

    
        form button {
            padding: 10px 20px;
            margin: 5px;
            background-color: #66bb6a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }
    
        form button:hover {
            background-color: #388e3c;
        }

        /* Estilos para los nombres de los Digimons */
        .digimon-data {
            background-color: #4CAF50; 
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }

        .digimon-data h3 {
            margin: 0;
            color: white;
            font-size: 18px;
            padding: 0 15px;
        }
        .boton-especial-disponible {
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 16px;
}

.boton-especial-disponible:hover {
    background-color: #388e3c;
}

.boton-especial-no-disponible {
    background-color: #9e9e9e;
    color: #e0e0e0;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    margin: 5px;
    font-size: 16px;
    cursor: not-allowed;
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
    color: rgb(255, 255, 255);
    background-color: purple; 
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-machine {
    color: rgb(255, 255, 255);
    background-color: silver; 
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-bird {
    color: #ffffff;
    background-color: #87cefa; 
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-beast {
    color: rgb(255, 255, 255);
    background-color: orange;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-dragon {
    color: rgb(255, 255, 255);
    background-color: red; 
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-insect {
    color: rgb(255, 255, 255);
    background-color: green;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}

.element-water {
    color: rgb(255, 255, 255);
    background-color: blue; 
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}


    /* Caja informativa */
    .info-elementos {
        margin-top: 10px;
        background-color: #ffffff;
        padding: 15px;
        border: 2px solid #2196f3;
        border-radius: 10px;
        text-align: left;
        font-size: 14px;
        color: #333;
    }

    .info-elementos ul {
        list-style-type: none;
        padding: 0;
    }

    .info-elementos li {
        margin: 5px 0;
    }
    .rueda-elementos {
    margin-top: 10px;
    background-color: #ffffff;
    padding: 15px;
    border: 2px solid #2196f3;
    border-radius: 10px;
    text-align: center;
    font-size: 12px;
    color: #333;
}

.rueda {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    align-items: center;
    margin-top: 10px;
    font-weight: bold;
}

.rueda span {
    white-space: nowrap;
}

.facil { background-color: #4caf50 !important; }         /* Verde */
.media { background-color: #2196f3 !important; }         /* Azul */
.dificil { background-color: #ff9800 !important; }       /* Naranja */
.muy-dificil { background-color: #f44336 !important; }   /* Rojo */

  .video-oculto {
      display: none;
    }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('redireccionar'))
                setTimeout(function () {
                    window.location.href = "{{ route('home') }}";
                }, 3000);
            @endif
        });
    </script>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
<h1 class="{{ $colorClase }}">Ruta: {{ $nombreRuta }}</h1>
<h2 class="{{ $colorClase }}">Dificultad: {{ $dificultad }} || <strong>Turno actual:</strong> {{ session('turno') }}</h2>

<div class="info-elementos rueda-elementos">
    <strong>Fortalezas y Debilidades:</strong>
    <div class="rueda">
        <span class="element-light">Light</span> ➜ <span class="element-night">Night</span> ➜ <span class="element-light">Light</span> |
        <span class="element-insect">Insect</span> ➜ <span class="element-water">Water</span> ➜ <span class="element-dragon">Dragon</span> ➜ <span class="element-insect">Insect</span> |
        <span class="element-beast">Beast</span> ➜ <span class="element-machine">Machine</span> ➜ <span class="element-bird">Bird</span> ➜ <span class="element-beast">Beast</span>
    </div>
</div>

    
        <!-- Contenedor para los nombres de los Digimons con fondo verde y en la misma línea -->
        <div class="digimon-data {{ $colorClase }}">
    <h3>{{ $digimonUsuario->nombre }} 
        (<span class="element-{{ strtolower($digimonUsuario->elemento) }}">{{ $digimonUsuario->elemento }}</span>) - Tu Digimon
    </h3>
    <h3>{{ $digimonEnemigo->nombre }} 
        (<span class="element-{{ strtolower($digimonEnemigo->elemento) }}">{{ $digimonEnemigo->elemento }}</span>) - Enemigo
    </h3>
</div>
        
        <!-- Contenedor para ambos Digimons dentro de un solo cuadro -->
        <div class="digimon-combat">
            <!-- Digimon Usuario a la izquierda -->
            <div class="digimon">
                <img src="{{ $digimonUsuario->videogif }}" alt="{{ $digimonUsuario->nombre }}">
            </div>

            <!-- Digimon Enemigo a la derecha -->
            <div class="digimon">
                <img class="enemigo" src="{{ $digimonEnemigo->videogif }}" alt="{{ $digimonEnemigo->nombre }}">
            </div>
        </div>
        
        <!-- Estadísticas de ambos Digimons en una sola línea -->
        <div class="digimon-data {{ $colorClase }}">
            <div class="stats">
                <p>Nivel: <span>{{ $digimonUsuario->nivel }}</span></p>
<p>Vida: 
    <span>{{ number_format($digimonUsuario->vidarestante, 2) }}</span> / 
    <span>{{ number_format($digimonUsuario->vidaActual(), 2) }}</span>
</p>

            </div>
            <div class="stats">
                <p>Nivel: <span>{{ $digimonEnemigo->nivel }}</span></p>
<p>Vida: 
    <span>{{ number_format($digimonEnemigo->vidarestante, 2) }}</span> / 
    <span>{{ number_format($digimonEnemigo->vidaActual(), 2) }}</span>
</p>
            </div>
        </div>
    
        @if(isset($mensaje) && $mensaje != '')
    <div class="mensaje-combate">
        <p>{{ $mensaje }}</p>
    </div>
@else
    <div class="mensaje-combate">
        <p>&nbsp;</p>  <!-- Esto agrega un espacio vacío si el mensaje está vacío -->
    </div>
@endif


    
        @if(!session('redireccionar'))
        <form action="{{ route('accion.combate') }}" method="POST">
    @csrf
    <input type="hidden" name="enemigo_id" value="{{ $digimonEnemigo->id }}">
    <button type="submit" name="accion" value="atacar" class="{{ $colorClase }}">Atacar</button>
    <button type="submit" name="accion" value="ataque-elemental"
        @if(!($digimonUsuario[strtolower($digimonUsuario->elemento) . '1'])) 
            disabled class="boton-especial-no-disponible"
        @else 
            class="boton-especial-disponible {{ $colorClase }}"
        @endif>
        Ataque Elemental
    </button>
    <button
        type="submit"
        name="accion"
        value="ataque-especial"
        class="{{ ($especialDisponible ?? false) ? 'boton-especial-disponible ' . $colorClase : 'boton-especial-no-disponible' }}"
        {{ ($especialDisponible ?? false) ? '' : 'disabled' }}
    >
        Ataque Especial
    </button>
    <button type="submit" name="accion" value="defender"
        @if($usuarioDefensaCooldown > 0) disabled class="boton-especial-no-disponible"
        @else class="boton-especial-disponible {{ $colorClase }}" @endif>
        Defender
    </button>
    <button type="submit" name="accion" value="curarse" class="{{ $colorClase }}">Curarse</button>
    <button type="submit" name="accion" value="huir" class="{{ $colorClase }}">Huir</button>
    <button type="submit" name="accion" value="capturar" class="{{ $colorClase }}">Capturar</button>
</form>

        
        @endif
    </div>
    
    <div class="blue-column right"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Combate')->first();
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
