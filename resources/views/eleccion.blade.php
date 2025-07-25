<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elige tu Digimon</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #388e3c;
        }

        .digimon-container {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .digimon-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            width: 250px;
            text-align: center;
        }

        .digimon-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .digimon-card h3 {
    font-size: 1.5rem;
    margin: 0;
    color: #388e3c;
}

.digimon-card img {
    width: 100%;
    border-radius: 10px;
    margin-top: 0;
}


        /* Voltear la imagen de Coronamon */
        .coronamon-img {
            transform: rotateY(180deg);
        }

        button {
            padding: 10px 20px;
            background-color: #66bb6a;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #388e3c;
        }

        audio {
            margin-top: 30px;
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <h2>Elige tu compañero Digimon</h2>

    <div class="digimon-container">

         <!-- Lopmon -->
         <div class="digimon-card">
            <h3>{{ $lopmon->nombre }}</h3>
            <img src="https://imgur.com/v3VBPlw.gif" 
                 alt="Lopmon" referrerpolicy="no-referrer-when-downgrade">
            <form action="{{ route('seleccionar.digimon', $lopmon->nombre) }}" method="POST">
                @csrf
                <button type="submit">Elegir {{ $lopmon->nombre }}</button>
            </form>
        </div>
        <!-- Coronamon -->
        <div class="digimon-card">
            <h3>{{ $coronamon->nombre }}</h3>
            <img class="coronamon-img" src="https://imgur.com/tFGX40r.gif" 
                 alt="Coronamon" referrerpolicy="no-referrer">
            <form action="{{ route('seleccionar.digimon', $coronamon->nombre) }}" method="POST">
                @csrf
                <button type="submit">Elegir {{ $coronamon->nombre }}</button>
            </form>
        </div>
        
       

    </div>

    @php
        // Buscar el enlace de la canción "Eleccion" en la base de datos
        $cancion = \App\Models\ListaCancion::where('nombre', 'Eleccion')->first();
    @endphp

    @if($cancion)
    <!-- Música oculta -->
<div style="display: none;">
    <iframe width="0" height="0"
        src="https://www.youtube.com/embed/{{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}?autoplay=1&loop=1&playlist={{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}&mute=0"
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen>
    </iframe>
</div>
    @else
    <!-- Mensaje si no se encuentra la canción -->
    <p>No se encontró la canción "Eleccion".</p>
    @endif

</body>
</html>
