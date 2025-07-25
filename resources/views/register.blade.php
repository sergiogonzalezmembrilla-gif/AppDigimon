<!-- resources/views/register.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <style>
        body {
            background: linear-gradient(135deg, #388e3c, #1b5e20);
            color: white;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 2em;
        }

        .form-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
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
            background-color: #2e7d32;
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
    </style>
</head>
<body>

<h2>Crear Cuenta</h2>

<div class="form-container">

    @if($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ url('/register') }}" method="POST">
        @csrf
        <div>
            <input type="text" name="nombreusuario" placeholder="Nombre de usuario" required>
        </div>
        <div>
            <input type="email" name="correousuario" placeholder="Correo electrónico" required>
        </div>
        <div>
            <input type="password" name="contraseñausuario" placeholder="Contraseña" required>
        </div>
        <div>
            <input type="password" name="contraseñausuario_confirmation" placeholder="Confirmar Contraseña" required>
        </div>
        <div>
            <button type="submit">Crear Cuenta</button>
        </div>
    </form>

    <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>

</div>

@php
    $cancion = \App\Models\ListaCancion::where('nombre', 'Registro')->first();
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
@endif

</body>
</html>
