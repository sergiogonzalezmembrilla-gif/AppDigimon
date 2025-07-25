<!DOCTYPE html>
<html>
<head>
    <title>Crear Digimon</title>
</head>
<body>
    <h2>Selecciona un Digimon para Crear:</h2>
    
    <form method="POST" action="{{ route('crear.digimon') }}">
        @csrf
        <select name="nombre" required>
            @foreach($listaDigimon as $dig)
                <option value="{{ $dig->nombre }}">{{ $dig->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Crear</button>
    </form>
</body>
</html>
