<h1>Detalles del Digimon</h1>

<ul>
    <li><strong>Nombre:</strong> {{ $digimon->nombre }}</li>
    <li><strong>Nivel:</strong> {{ $digimon->nivel }}</li>
    <li><strong>Etapa:</strong> {{ $digimon->etapa }}</li>
    <li><strong>Elemento:</strong> {{ $digimon->elemento }}</li>
    <li><strong>Video/Gif:</strong> <img src="{{ $digimon->videogif }}" alt="Gif de {{ $digimon->nombre }}"></li>

    <li><strong>Ataque Base:</strong> {{ $digimon->ataquebase }}</li>
    <li><strong>Defensa Base:</strong> {{ $digimon->defensabase }}</li>
    <li><strong>Vida Base:</strong> {{ $digimon->vidabase }}</li>
    <li><strong>Vida Actual:</strong> {{ $digimon->vidaActual() }}</li>
    <li><strong>Ataque Actual:</strong> {{ $digimon->ataqueActual() }}</li>
    <li><strong>Defensa Actual:</strong> {{ $digimon->defensaActual() }}</li>

    <li><strong>Experiencia Base:</strong> {{ $digimon->experienciabase }}</li>
    <li><strong>Experiencia Actual:</strong> {{ $digimon->experienciaactual }}</li>
    <li><strong>Experiencia Siguiente Nivel:</strong> {{ $digimon->experienciasiguientenivel }}</li>
    <li><strong>% Experiencia:</strong> {{ $digimon->porcentajeExperiencia() }}%</li>

    <li><strong>Felicidad:</strong> {{ $digimon->felicidad }}</li>
    <li><strong>Hambre:</strong> {{ $digimon->hambre }}</li>
    <li><strong>Salud:</strong> {{ $digimon->salud }}</li>
    <li><strong>Caca:</strong> {{ $digimon->caca }}</li>
    <li><strong>Higiene:</strong> {{ $digimon->higiene }}</li>

    <li><strong>Entrenamientos:</strong> {{ $digimon->numentrenamientos }}</li>
    <li><strong>Entrenamientos Máximos:</strong> {{ $digimon->entrenamientosMaximos() }}</li>
    <li><strong>Puede Entrenar:</strong> {{ $digimon->puedeEntrenar() ? 'Sí' : 'No' }}</li>

    <li><strong>Número de Evoluciones:</strong> {{ $digimon->num_evoluciones }}</li>
    <li><strong>Bono por Involución:</strong> {{ $digimon->bonoinvolucion }}</li>
    <li><strong>Potencial Máximo:</strong> {{ $digimon->haAlcanzadoPotencialMaximo() ? 'Sí' : 'No' }}</li>

    <li><strong>Llaves y Evoluciones:</strong>
        <ul>
            <li>Llave 1: {{ $digimon->numllave1 }}/{{ $digimon->numllavenecesaria1 }}</li>
            <li>Llave 2: {{ $digimon->numllave2 }}/{{ $digimon->numllavenecesaria2 }}</li>
        </ul>
    </li>

    <li><strong>Tipos/Genéticas:</strong>
        <ul>
            <li>Night: {{ $digimon->night1 }}, {{ $digimon->night2 }}, {{ $digimon->night3 }}</li>
            <li>Light: {{ $digimon->light1 }}, {{ $digimon->light2 }}, {{ $digimon->light3 }}</li>
            <li>Machine: {{ $digimon->machine1 }}, {{ $digimon->machine2 }}, {{ $digimon->machine3 }}</li>
            <li>Beast: {{ $digimon->beast1 }}, {{ $digimon->beast2 }}, {{ $digimon->beast3 }}</li>
            <li>Bird: {{ $digimon->bird1 }}, {{ $digimon->bird2 }}, {{ $digimon->bird3 }}</li>
            <li>Water: {{ $digimon->water1 }}, {{ $digimon->water2 }}, {{ $digimon->water3 }}</li>
            <li>Dragon: {{ $digimon->dragon1 }}, {{ $digimon->dragon2 }}, {{ $digimon->dragon3 }}</li>
            <li>Insect: {{ $digimon->insect1 }}, {{ $digimon->insect2 }}, {{ $digimon->insect3 }}</li>
        </ul>
    </li>

    <li><strong>Ocupado:</strong> {{ $digimon->ocupado ? 'Sí' : 'No' }}</li>
    <li><strong>Ocupado2:</strong> {{ $digimon->ocupado2 ? 'Sí' : 'No' }}</li>
</ul>
