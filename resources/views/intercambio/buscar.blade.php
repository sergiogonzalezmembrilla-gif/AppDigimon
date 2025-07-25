<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Intercambio</title>
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
        }

        h1 {
            color: #388e3c;
            margin-bottom: 30px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #f1f1f1;
            margin: 10px auto;
            padding: 15px;
            border-radius: 8px;
            max-width: 600px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .btn-custom {
            padding: 10px 18px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin: 10px 5px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .btn-search {
            background-color: #28a745;
        }

        .btn-search:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 8px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
        .video-oculto {
      display: none;
    }
    </style>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
 <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
        <a href="{{ route('intercambio.index') }}" class="btn-custom btn-back">← Volver a intercambio</a>
        <h1 style="margin: 0; flex-grow: 1; text-align: center;">Buscar Digimon para Intercambio</h1>
        <div style="width: 180px;"></div> <!-- Espacio para equilibrar el botón -->
    </div>
        @if(session('error'))
            <p style="color: red;">{{ session('error') }}</p>
        @endif

        <form action="{{ route('intercambio.buscar') }}" method="GET">
            <label for="nombre">Buscar por nombre del Digimon:</label><br>
            <input type="text" name="nombre" id="nombre" value="{{ request('nombre') }}">
            <button type="submit">Buscar</button>
        </form>


        <h2>Intercambios Disponibles:</h2>

        @if(isset($resultados) && $resultados->count() > 0)
            <ul>
                @foreach($resultados as $intercambio)
                    <li>
                        <strong>{{ $intercambio->digimonOfrecido->nombre ?? 'Nombre no disponible' }}</strong> 
                        ofrecido por el usuario #{{ $intercambio->id_usuario }}<br>
                        
                        <a href="{{ route('intercambio.elegir_propio_digimon', $intercambio->id) }}" class="btn-custom btn-search">
                            Intercambiar (Buscado: {{ $intercambio->digimonBuscado->nombre }})
                        </a>
                    </li>
                @endforeach
            </ul>
        @elseif(isset($resultados))
            <p>No se encontraron intercambios para ese nombre.</p>
        @endif
    </div>

    <div class="blue-column right"></div>
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
