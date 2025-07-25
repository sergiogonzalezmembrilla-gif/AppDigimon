<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Zona de Intercambio</title>
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
            max-width: 1000px;
            margin: auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            color: #388e3c;
            margin-bottom: 30px;
        }

        .digimon-box {
            width: 300px;
            height: auto;
            background-color: #ffe0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .digimon-img {
            max-width: 180px;
            max-height: 180px;
        }

        .btn {
            margin: 10px;
        }

        .gif-buscado {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
        }

        .gif-buscado img {
            width: 80px;
            height: 80px;
            margin-left: 10px;
        }

        form {
            margin-top: 10px;
        }
        .arrow-box {
    font-size: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 10px;
}
/* Mejora de botones */
.btn-custom {
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.btn-home {
    background-color: #6c757d;
}

.btn-home:hover {
    background-color: #5a6268;
}

.btn-search {
    background-color: #28a745;
}

.btn-search:hover {
    background-color: #218838;
}

.btn-deposit {
    background-color: #007bff;
}

.btn-deposit:hover {
    background-color: #0069d9;
}

.btn-receive {
    background-color: #17a2b8;
}

.btn-receive:hover {
    background-color: #138496;
}

.btn-cancel {
    background-color: #dc3545;
}

.btn-cancel:hover {
    background-color: #c82333;
}
 .video-oculto {
      display: none;
    }


    </style>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
        <h1>Zona de Intercambio</h1>

        <div style="margin-bottom: 30px;">
    <a href="{{ route('home') }}" class="btn-custom btn-home">Volver a Home</a>

    <a href="{{ route('intercambio.buscar') }}" class="btn-custom btn-search">Buscar Digimon para Intercambio</a>

    @if (!$digimonDepositado)
        <a href="{{ route('intercambio.depositar') }}" class="btn-custom btn-deposit">Depositar Digimon</a>
    @else
        @if ($intercambioRealizado)
            <form action="{{ route('intercambio.recibir') }}" method="POST" id="recibirForm" style="display:inline-block;">
    @csrf
    <button type="button" class="btn-custom btn-receive" onclick="abrirModalRecibir()">Recibir Digimon</button>
</form>

        @else
            <!-- Botón que activa el modal -->
<form id="cancelForm" action="{{ route('intercambio.cancelar') }}" method="POST" style="display:inline-block;">
    @csrf
    <button type="button" class="btn-custom btn-cancel" onclick="abrirModal()">Cancelar depósito</button>
</form>

        @endif
    @endif
</div>


       {{-- Mostrar Digimon o cuadro --}}
<div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap;">

    {{-- Cuadro del Digimon ofrecido --}}
    <div class="digimon-box">
        @if ($digimonDepositado && $intercambioPendiente)
            <div style="text-align: center;">
                <p><strong>{{ $digimonDepositado->nombre }}</strong></p>
                <img src="{{ $digimonDepositado->videogif }}" alt="Gif de {{ $digimonDepositado->nombre }}" class="digimon-img">

                @if ($digimonBuscado)
                    <div class="gif-buscado">
                        <p><strong>Busca: {{ $digimonBuscado->nombre }}</strong></p>
                        <img src="{{ $digimonBuscado->video_gif }}" alt="Gif de {{ $digimonBuscado->nombre }}">
                    </div>
                @endif
            </div>
        @elseif (!$digimonDepositado)
            <p>No tienes un Digimon depositado.</p>
        @else
            <p>Esperando que otro usuario complete el intercambio...</p>
        @endif
    </div>

    {{-- Flecha visual si el intercambio fue realizado --}}
    @if ($intercambioRealizado && $digimonRecibido)
        <div class="arrow-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#1976d2">
                <path d="M10 17l5-5-5-5v10z"/>
            </svg>
        </div>
    @endif

    {{-- Cuadro del Digimon recibido --}}
    <div class="digimon-box">
        @if ($intercambioRealizado && $digimonRecibido)
            <div style="text-align: center;">
                <p><strong>Intercambio Realizado</strong></p>
                <p><strong>{{ $digimonRecibido->nombre }}</strong></p>
                <img src="{{ $digimonRecibido->videogif }}" alt="Gif de {{ $digimonRecibido->nombre }}" class="digimon-img">
            </div>
        @else
            <p>Aún no has recibido un Digimon.</p>
        @endif
    </div>

</div>




        @if(session('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
    </div>

    <div class="blue-column right"></div>

   
    <script>
    function confirmarRecibir() {
        return confirm('¿Deseas recibir tu nuevo Digimon del intercambio?');
    }
</script>
<!-- Modal de confirmación -->
<div id="modalConfirmacion" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:30px; border-radius:10px; width:90%; max-width:400px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:20px;">¿Estás seguro?</h2>
        <p style="margin-bottom:30px;">¿Quieres cancelar el depósito del Digimon?</p>
        <button onclick="enviarFormulario()" class="btn-custom btn-cancel" style="margin-right:10px;">Sí, cancelar</button>
        <button onclick="cerrarModal()" class="btn-custom btn-home">No, volver</button>
    </div>
</div>
<div id="modalRecibir" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
    <div style="background:#fff; padding:30px; border-radius:10px; width:90%; max-width:400px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,0.2);">
        <h2 style="margin-bottom:20px;">¿Recibir Digimon?</h2>
        <p style="margin-bottom:30px;">¿Deseas recibir tu nuevo Digimon del intercambio?</p>
        <button onclick="enviarRecibirForm()" class="btn-custom btn-receive" style="margin-right:10px;">Sí, recibir</button>
        <button onclick="cerrarModalRecibir()" class="btn-custom btn-home">No, volver</button>
    </div>
</div>
<script>
    // Modal Cancelar
    function abrirModal() {
        document.getElementById('modalConfirmacion').style.display = 'flex';
    }

    function cerrarModal() {
        document.getElementById('modalConfirmacion').style.display = 'none';
    }

    function enviarFormulario() {
        document.getElementById('cancelForm').submit();
    }

    // Modal Recibir
    function abrirModalRecibir() {
        document.getElementById('modalRecibir').style.display = 'flex';
    }

    function cerrarModalRecibir() {
        document.getElementById('modalRecibir').style.display = 'none';
    }

    function enviarRecibirForm() {
        document.getElementById('recibirForm').submit();
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
