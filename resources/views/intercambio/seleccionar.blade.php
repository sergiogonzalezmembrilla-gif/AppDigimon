<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Intercambio</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: #f5f7fa;
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
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 6px 16px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #2c3e50;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: left;
        }

        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

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
            margin: 10px 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .video-oculto {
      display: none;
    }
    </style>
</head>
<body>
    <div class="blue-column left"></div>

    <div class="container">
        <h2>Selecciona el Digimon que deseas recibir</h2>

        <form method="POST" action="{{ route('intercambio.realizar', $digimon->id) }}">
            @csrf
            <label for="lista_digimon_id">Digimon deseado:</label>
            <select name="lista_digimon_id" id="lista_digimon_id" required>
                @foreach ($listaDigimon as $ld)
                    <option value="{{ $ld->id }}">{{ $ld->nombre }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn-custom btn-primary">Confirmar Intercambio</button>
        </form>

        <a href="{{ route('intercambio.depositar') }}" class="btn-custom btn-secondary">← Volver</a>
    </div>

    <div class="blue-column right"></div>
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
