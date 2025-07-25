<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <style>
        body {
            background-color: #2e7d32; /* verde bonito */
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 80vh;
            margin: 0;
        }

        .logo {
            margin-bottom: 20px;
        }

        .logo img {
            width: 300px;
            filter: drop-shadow(0 0 15px rgba(0,0,0,0.7));
        }

        .container {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        input, button {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
        }

        input {
            background-color: #fff;
            color: #000;
        }

        button {
            background-color: #66bb6a;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #388e3c;
        }

        a {
            color: #a5d6a7;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .video-oculto {
            display: none;
        }
    </style>
</head>
<body>

<div class="logo">
    <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/i/80f85cfd-3501-4ffa-85dd-546959cc47cd/d9a4yb9-385621b1-131a-4bc3-80dc-cb4137047651.png" alt="Logo">
</div>

<div class="container">
    <h2>Iniciar sesión</h2>

    @if($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div>
            <input type="email" name="correousuario" placeholder="Correo electrónico" required>
        </div>
        <div>
            <input type="password" name="contraseñausuario" placeholder="Contraseña" required>
        </div>
        <div>
            <button type="submit">Iniciar sesión</button>
        </div>
    </form>

    <p>¿No tienes cuenta? <a href="{{ route('register') }}">Crear cuenta</a></p>
</div>

@php
    $cancion = \App\Models\ListaCancion::where('nombre', 'Iniciar')->first();
@endphp

@if($cancion)
<div class="video-oculto">
    <iframe width="0" height="0"
        src="https://www.youtube.com/embed/{{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}?autoplay=1&loop=1&playlist={{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}&mute=0"
        frameborder="0"
        allow="autoplay; encrypted-media"
        allowfullscreen>
    </iframe>
</div>
@endif

</body>
</html>
