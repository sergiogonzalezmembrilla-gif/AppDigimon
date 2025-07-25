<!-- resources/views/image_redirect.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar a la aplicación</title>
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32, #1b5e20);
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 30px;
        }

        #image-container {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        #image-container:hover {
            transform: scale(1.1);
        }

        #image-container img {
            width: 300px;
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.7));
        }

        #image-container p {
            margin-top: 15px;
            font-size: 18px;
            color: #c8e6c9;
        }
    </style>
</head>
<body>

    <h2>Bienvenido a Applimom</h2>

    <div id="image-container" onclick="redirectToLogin()">
        <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/i/80f85cfd-3501-4ffa-85dd-546959cc47cd/d9a4yb9-385621b1-131a-4bc3-80dc-cb4137047651.png" alt="Imagen de inicio">
        <p>Haz click para entrar</p>
    </div>

    <script>
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }
    </script>

</body>
</html>
