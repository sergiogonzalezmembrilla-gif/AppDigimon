<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digidex</title>
  <style>
    body {
  margin: 0;
  padding: 0;
  display: flex;
  flex-direction: column; 
  height: 100vh;
  font-family: 'Arial', sans-serif;
  background-color: #f4f4f4;
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

    .main-content {
      width: 100%;
      max-width: 1100px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      margin-top: 10px;
    }

    .navbar {
  width: 100%;
  background-color: #002f61;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 15px 30px;
  position: relative;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  text-align: center;
}

.navbar h2 {
  margin: 0;
  font-size: 24px;
  flex: 1;
  text-align: center;
}

.navbar a {
  position: absolute;
  left: 30px;
  background-color: #28a745;
  color: #fff;
  padding: 8px 16px;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s;
}


    .navbar a:hover {
      background-color: #218838;
    }

    .container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      padding: 20px;
      justify-items: center;
    }

    .digimon-card {
      width: 150px;
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .image-container {
      position: relative;
    }

    .digimon-id {
      position: absolute;
      top: 5px;
      left: 5px;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 2px 6px;
      font-size: 12px;
      border-radius: 4px;
    }

    .digimon-id.adquirido {
      background-color: #28a745 !important;
    }

    .digimon-card img {
      width: 100%;
      border-radius: 10px;
      transition: filter 0.3s ease;
    }

    .digimon-card img.no-adquirido {
      filter: grayscale(100%) brightness(0%) !important;
    }

    .digimon-card p {
      margin-top: 10px;
      font-weight: bold;
    }

    /* Modal */
    #digimonModal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  z-index: 9999;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.3s ease-in-out;
}

#digimonModal .modal-content {
  background: #fff;
  padding: 30px 25px;
  border-radius: 16px;
  width: 90%;
  max-width: 600px;
  position: relative;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
  animation: slideUp 0.3s ease-out;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

#digimonModal .modal-content h2 {
  margin-top: 0;
  color: #002f61;
  font-size: 28px;
  text-align: center;
}

#digimonModal button {
  position: absolute;
  top: 12px;
  right: 15px;
  font-size: 26px;
  background: none;
  border: none;
  cursor: pointer;
  color: #999;
  transition: color 0.3s ease;
}

#digimonModal button:hover {
  color: #333;
}

#digimonModal .modal-content p {
  margin: 4px 0;
  font-size: 15px;
  line-height: 1.4;
}

#digimonModal .modal-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px 24px;
}

@keyframes fadeIn {
  from { opacity: 0; } 
  to { opacity: 1; }
}

@keyframes slideUp {
  from { transform: translateY(30px); opacity: 0; } 
  to { transform: translateY(0); opacity: 1; }
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

  
<div class="navbar">
      <a href="{{ route('home') }}">Volver al inicio</a>
      <h2>Digidex</h2>
    </div>
<main style="display: flex; flex: 1;">

    <div class="blue-column left"></div>
  <div class="main-content">
    

    <div class="container">
      @foreach($digimones as $digimon)
      <div class="digimon-card" onclick="{{ in_array($digimon->id, $digimonesAdquiridos) ? "obtenerInfo($digimon->id)" : '' }}" style="cursor: {{ in_array($digimon->id, $digimonesAdquiridos) ? 'pointer' : 'default' }}">
          <div class="image-container">
              <span class="digimon-id {{ in_array($digimon->id, $digimonesAdquiridos) ? 'adquirido' : '' }}">
                  #{{ $digimon->id }}
              </span>
              <img 
                  src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $digimon->video_gif) }}" 
                  alt="{{ $digimon->nombre }}"
                  class="{{ !in_array($digimon->id, $digimonesAdquiridos) ? 'no-adquirido' : '' }}"
              >
          </div>
          <p>{{ $digimon->nombre }}</p>
      </div>
      @endforeach
    </div>
  </div>

  <div class="blue-column right"></div>
</main>

  
  <<div id="digimonModal">
  <div class="modal-content">
    <button onclick="cerrarModal()">&times;</button>
    <h2 id="modalNombre"></h2>
    <div class="modal-grid">
      <p><strong>Nivel:</strong> <span id="modalNivel"></span></p>
      <p><strong>Vida Base:</strong> <span id="modalVida"></span></p>
      <p><strong>Ataque Base:</strong> <span id="modalAtaque"></span></p>
      <p><strong>Defensa Base:</strong> <span id="modalDefensa"></span></p>
      <p><strong>Elemento:</strong> <span id="modalElemento"></span></p>
      <p><strong>Etapa:</strong> <span id="modalEtapa"></span></p>
      <p><strong>Involuciona a:</strong> <span id="modalInvoluciones"></span></p>
      <p><strong>Evoluciona a:</strong> <span id="modalEvoluciones"></span></p>
    </div>
    <p><strong>Descripción:</strong> <span id="modalDescripcion"></span></p>
  </div>
</div>


  <script>
    function obtenerInfo(id) {
      fetch(`/digimon/${id}/info`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('modalNombre').textContent = data.nombre;
          document.getElementById('modalNivel').textContent = data.nivel;
          document.getElementById('modalVida').textContent = data.vidabase;
          document.getElementById('modalAtaque').textContent = data.ataquebase;
          document.getElementById('modalDefensa').textContent = data.defensabase;
            const elementoSpan = document.getElementById('modalElemento');
            const elementoNombre = data.elemento.toLowerCase();
            const claseElemento = `element-${elementoNombre}`;

            elementoSpan.textContent = data.elemento;
            elementoSpan.className = claseElemento; 
          document.getElementById('modalEtapa').textContent = data.etapa;
          document.getElementById('modalDescripcion').textContent = data.descripcion || 'Sin descripción';
          document.getElementById('modalEvoluciones').textContent = data.evoluciones || 'Ninguna';
          document.getElementById('modalInvoluciones').textContent = data.involuciones || 'Ninguna';
          document.getElementById('digimonModal').style.display = 'flex';
        });
    }

    function cerrarModal() {
      document.getElementById('digimonModal').style.display = 'none';
    }
  </script>
  @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Digidex')->first();
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
