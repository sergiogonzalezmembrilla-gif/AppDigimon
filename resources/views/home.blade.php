<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Home</title>
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
      width: 100%;
      max-width: 1100px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      margin-top: 10px;
    }

    h2 {
      color: #388e3c;
    }

    button {
      padding: 10px 20px;
      background-color: #66bb6a;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 16px;
    }

    button:hover {
      background-color: #388e3c;
    }

    .digimon {
      margin: 30px 0;
      padding: 15px;
      background-color: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
      flex: 2;
    }

    .digimon p {
      margin: 10px 0;
      font-size: 16px;
    }

    .digimon img {
      width: 200px;
      margin-top: 20px;
      border-radius: 10px;
      position: relative;
      left: 0;
      transition: transform 1s ease, left 2s ease-in-out;
    }

    .video-oculto {
      display: none;
    }

    .stats p {
      font-size: 18px;
      margin: 5px 0;
      color: #555;
    }

    .stats span {
      font-weight: bold;
      color: #388e3c;
    }

    .logout-button {
      margin-top: 40px;
      background-color: #e53935 !important;
    }

    .logout-button:hover {
      background-color: #c62828 !important;
    }

    .button-sides {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      gap: 20px;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .left-buttons,
    .right-buttons {
      display: flex;
      flex-direction: column;
      gap: 50px;
      flex: 1;
      max-width: 200px;
      
    }

    .left-buttons a,
    .right-buttons a {
      text-decoration: none;
    }
     .left-buttons, .right-buttons {
      margin-top: 30px; 
    }
    button {
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn-icon {
  width: 50px;
  height: 50px;
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


  </style>
</head>
<body>
  <div class="blue-column left"></div>

  <div class="container">
    <h2>¡Bienvenido, {{ Auth::user()->nombreusuario }}!</h2>
        <!--<a href="{{ route('crear.digimon.form') }}"><button>Crear Nuevo Digimon</button></a>-->

    <div class="button-sides">
      <div class="left-buttons">
  <a href="{{ route('cambiar.digimon.form') }}">
    <button><img src="https://i.imgur.com/NXuUT5t.png" class="btn-icon"> Cambiar Digimon</button>
  </a>
  <a href="{{ route('cuidar.digimon') }}">
    <button><img src="https://i.imgur.com/9Wl7Jio.png" class="btn-icon"> Cuidar Digimon</button>
  </a>
  <a href="{{ route('intercambio.index') }}">
    <button><img src="https://i.imgur.com/weI1g9o.png" class="btn-icon"> Ir a Intercambio</button>
  </a>
  <a href="{{ route('combate_online.index') }}">
    <button><img src="https://i.imgur.com/YMpti8e.png" class="btn-icon"> Combate Online</button>
  </a>
</div>


      @if($digimon)
      <div class="digimon">
<p>
  <strong>{{ $digimon->nombre }}</strong> | 
  Nivel: {{ $digimon->nivel }} | 
  Etapa: {{ $digimon->etapa }} | 
  Elemento: 
  <span class="element-{{ strtolower($digimon->elemento) }}">
    {{ $digimon->elemento }}
  </span>
</p>

        <div style="background-image: url('https://i.imgur.com/pY6nnmQ.png'); background-size: cover; background-position: center center; border-radius: 10px; padding: 10px; display: inline-block; width: 95%; height: 300px; margin: 0 auto; border: 5px solid #388e3c;">
          <img src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $digimon->videogif) }}" alt="GIF del Digimon" id="digimon-img">
        </div>

        <p>
          Vida: <span id="vidaActual">{{ $digimon->vidaActual() }}</span> |
          Ataque: <span id="ataqueActual">{{ $digimon->ataqueActual() }}</span> |
          Defensa: <span id="defensaActual">{{ $digimon->defensaActual() }}</span> |
          Felicidad: <span class="felicidad">{{ $digimon->felicidad }}</span> |
          Experiencia: {{ $digimon->experienciaPorcentaje() }}%
        </p>
      </div>
      @else
      <p>Aún no has elegido un Digimon. Por favor, elige uno.</p>
      @endif

      <div class="right-buttons">
  <a href="{{ route('digidex') }}">
    <button>
      Ver Digidex
      <img src="https://i.imgur.com/wT9SktU.png" class="btn-icon">
    </button>
  </a>
  <a href="{{ route('entrenar.digimon') }}">
    <button>
      Entrenar
      <img src="https://i.imgur.com/0OZiV5a.png" class="btn-icon">
    </button>
  </a>
  <a href="{{ route('ruta.seleccion') }}">
    <button>
      Vamos de Aventura
      <img src="https://i.imgur.com/4yOZK48.png" class="btn-icon">
    </button>
  </a>
  <a href="{{ route('mostrarevo') }}">
    <button>
      Evolucionar
      <img src="https://i.imgur.com/fe43Ipg.png" class="btn-icon">
    </button>
  </a>
</div>

    </div>

    @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Home')->first();
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

    <div style="display: flex; justify-content: center;">
  <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="logout-button">Cerrar sesión</button>
  </form>
</div>

  </div>

  <div class="blue-column right"></div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    setInterval(function() {
      $.ajax({
        url: "{{ route('reducir.stats') }}",
        method: "GET",
        success: function(data) {
          $('.hambre').text(data.hambre);
          $('.salud').text(data.salud);
          $('.caca').text(data.caca);
          $('.higiene').text(data.higiene);
          $('.felicidad').text(data.felicidad);
          $('#vidaActual').text(data.vidaActual);
          $('#ataqueActual').text(data.ataqueActual);
          $('#defensaActual').text(data.defensaActual);
        }
      });
    }, 120000);

    let direction = 'center';
    const digimonImg = document.getElementById('digimon-img');

    function moverDigimon() {
      const random = Math.random();
      let nuevaDireccion = 'center';

      if (random < 0.33) {
        nuevaDireccion = 'left';
      } else if (random < 0.66) {
        nuevaDireccion = 'right';
      }

      if (nuevaDireccion === 'left') {
        digimonImg.style.transform = 'rotateY(180deg)';
        digimonImg.style.left = '-200px';
      } else if (nuevaDireccion === 'right') {
        digimonImg.style.transform = 'rotateY(0deg)';
        digimonImg.style.left = '200px';
      } else {
        if (direction === 'right') {
          digimonImg.style.transform = 'rotateY(180deg)';
        } else if (direction === 'left') {
          digimonImg.style.transform = 'rotateY(0deg)';
        }
        digimonImg.style.left = '0px';
      }

      direction = nuevaDireccion;

      const randomTime = Math.floor(Math.random() * 3 + 1) * 1000;
      setTimeout(moverDigimon, randomTime);
    }

    moverDigimon();
  </script>
  <script>
  window.addEventListener('beforeunload', function (e) {
    navigator.sendBeacon("{{ route('guardar.salida') }}");
  });
</script>

  
</body>
</html>
