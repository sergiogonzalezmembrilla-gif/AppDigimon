<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Digimon Propio</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
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
            max-width: 1200px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        h1 {
            color: #1976d2;
            margin: 0;
            text-align: left;
            flex: 1;
        }

        .digimon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .digimon-card {
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f0f8ff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .digimon-card img {
            max-width: 120px;
        }

        .digimon-info {
            flex: 1;
            text-align: left;
        }

        .digimon-info h2 {
            margin: 0 0 10px;
        }

        .info-tag {
            display: block;
            margin: 6px 0;
        }

        .btn {
            padding: 10px 18px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-intercambiar {
            background-color: #28a745;
            color: white;
        }

        .btn-intercambiar:hover {
            background-color: #218838;
        }

        .btn-volver {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            margin-right: 20px;
        }

        .btn-volver:hover {
            background-color: #5a6268;
        }

        .fondo-gris {
            background-color: #e0e0e0;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Element styles */
        .element-light { color: #000; background-color: yellow; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-night { color: #fff; background-color: purple; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-machine { color: #fff; background-color: silver; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-bird { color: #fff; background-color: #87cefa; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-beast { color: #fff; background-color: orange; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-dragon { color: #fff; background-color: red; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-insect { color: #fff; background-color: green; font-weight: bold; padding: 2px 6px; border-radius: 5px; }
        .element-water { color: #fff; background-color: blue; font-weight: bold; padding: 2px 6px; border-radius: 5px; }

        @media (max-width: 768px) {
            .digimon-card {
                flex-direction: column;
                text-align: center;
            }

            .digimon-info {
                text-align: center;
            }

            .header-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-volver {
                margin-bottom: 10px;
            }

            h1 {
                text-align: center;
            }
            
        }
        .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        text-align: center;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .modal-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-around;
    }

    .modal-buttons button {
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 6px;
        border: none;
        cursor: pointer;
    }

    .btn-confirm {
        background-color: #28a745;
        color: white;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }
    .video-oculto {
      display: none;
    }
    </style>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
        <div class="header-bar">
            <a href="{{ route('intercambio.index') }}" class="btn btn-volver">← Volver a Intercambio</a>
            <h1>Selecciona uno de tus Digimon para intercambiar</h1>
        </div>

        @if($digimons->isEmpty())
            <p>No tienes ningún Digimon disponible para intercambiar.</p>
        @else
            <div class="digimon-grid">
                @foreach($digimons as $digimon)
                    <div class="digimon-card">
                        <img src="{{ $digimon->videogif ?? asset('images/default.gif') }}" alt="Gif de {{ $digimon->nombre }}">
                        <div class="digimon-info">
                            <h2>{{ $digimon->nombre }}</h2>
                            <p class="info-tag">Nivel: {{ $digimon->nivel }}</p>
                            <p class="info-tag">Etapa: <span class="fondo-gris">{{ $digimon->etapa }}</span></p>
                            <p class="info-tag">Elemento: 
                                <span class="element-{{ strtolower($digimon->elemento) }}">
                                    {{ ucfirst($digimon->elemento) }}
                                </span>
                            </p>

                            <form action="{{ route('intercambio.finalizar', $intercambio->id) }}" method="POST" class="intercambio-form">
                                @csrf
                                <input type="hidden" name="mi_digimon_id" value="{{ $digimon->id }}">
                                <button type="button" class="btn btn-intercambiar" onclick="mostrarModal(this)">Intercambiar</button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>

    <div class="blue-column right"></div>

   


<div id="modalConfirmacion" class="modal">
    <div class="modal-content">
        <p>¿Estás seguro de que quieres realizar este intercambio?</p>
        <div class="modal-buttons">
            <button class="btn-confirm" onclick="confirmarYEnviar()">Sí</button>
            <button class="btn-cancel" onclick="cerrarModal()">Cancelar</button>
        </div>
    </div>
</div>

<script>
    let formularioSeleccionado = null;

    function mostrarModal(boton) {
        formularioSeleccionado = boton.closest("form");
        document.getElementById("modalConfirmacion").style.display = "flex";
    }

    function cerrarModal() {
        document.getElementById("modalConfirmacion").style.display = "none";
    }

    function confirmarYEnviar() {
        if (formularioSeleccionado) {
            formularioSeleccionado.submit();
        }
    }
</script>
 @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Intercambio')->first();
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
