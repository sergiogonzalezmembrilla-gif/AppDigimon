<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Intercambio</title>
</head>
<body>
    <h1>Resultados de la búsqueda</h1>

    @if($digimons->isEmpty())
        <p>No se encontraron resultados.</p>
    @else
        @foreach($digimons as $digimon)
            <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
                <h2>{{ $digimon->nombre }}</h2>
                <p>Nivel: {{ $digimon->nivel }}</p>
                <img src="{{ $digimon->videogif }}" alt="Gif" width="100">
                <form action="{{ route('intercambio.intercambiar.form', $digimon->id) }}" method="GET">
                    <button type="submit">Seleccionar este para intercambiar</button>
                </form>
            </div>
        @endforeach
    @endif
</body>
</html>
