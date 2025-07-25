<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evolucionar Digimon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
        }

        h2, h3, h4 {
            color: #343a40;
        }

        .digimon-img {
            max-width: 180px;
            max-height: 180px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .card-title {
            font-weight: bold;
        }

        .btn-success, .btn-danger {
            width: 100%;
        }

        .right-buttons {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .alert ul {
            margin: 0;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li img {
            max-width: 100px;
            margin-bottom: 10px;
        }

      .evoluciones-container {
    display: flex;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: nowrap;
    align-items: start;
}

.involucion-card, .digimon-actual-card {
    flex: 1;
    max-width: 33%;
    min-width: 300px;
    justify-content: flex-start;
}
.evolucion-card{
    flex: 1;
    max-width: 33%;
    min-width: 400px;
    justify-content: flex-start;
}

.digimon-actual-card {
    text-align: center;
}


    .container {
    max-width: 800px;
    margin-left: 11rem;
}



        .motivo-list li {
            font-size: 0.9rem;
        }
        .blue-column {
    width: 10.35%;
    background-color: #2196f3;
    position: fixed;
    top: 0;
    bottom: 0;
    z-index: -1;
}

.blue-column.left {
    left: 0;
    border-right: 5px solid #1976d2;
}

.blue-column.right {
    right: 0;
    border-left: 5px solid #1976d2;
}
.position-relative h2 {
    margin: 50;
    line-height: 38px; 
}
.btn-digidex {
    margin-left: 0px;
}
.video-oculto {
      display: none;
    }

    </style>
</head>

<body>
    <div class="blue-column left"></div>
<div class="w-100 d-flex justify-content-center mb-1 mt-5">
    <div class="d-flex align-items-center justify-content-center gap-4 flex-wrap" style="max-width: 800px;">
        <a href="{{ route('home') }}" class="btn btn-primary">Volver a Inicio</a>
        <h2 class="mb-0 text-center">¡Es momento de Digi-Evolucionar!</h2>
        <a href="{{ route('digidex') }}" class="btn btn-secondary">Ver Digidex</a>
    </div>
</div>

    <div class="container py-5">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Errores:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger"><strong>Error:</strong> {{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success"><strong>Éxito:</strong> {{ session('success') }}</div>
        @endif

      

        <div class="evoluciones-container">
            <div class="evoluciones-container">
    <!-- Involuciones -->
    <div class="card involucion-card shadow-sm">
        <div class="card-body">
            <h4 class="card-title text-center">Involuciones</h4>
            <ul class="mt-3">
                @foreach([1, 2, 3] as $num)
                    @php $involucion = $digimon->{'involucion' . $num}; @endphp
                    @if($involucion)
                        <li class="mb-3 text-center">
                            <img src="{{ $involucion->video_gif }}" class="digimon-img mb-2" alt="Involución {{ $num }}">
                            <p><strong>{{ $involucion->nombre }}</strong></p>
                            <form method="POST" action="{{ route('involucionar', $involucion->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Involucionar</button>
                            </form>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Digimon Actual -->
    <div class="card digimon-actual-card shadow-sm">
        <div class="card-body">
            <h4 class="card-title text-center">Digimon Actual</h4>
            <img src="{{ $digimon->listaDigimon->video_gif }}" class="digimon-img mb-3" alt="{{ $digimon->nombre }}">
            <p><strong>{{ $digimon->nombre }}</strong></p>
            <p><strong>Etapa:</strong> {{ $digimon->etapa }}</p>
        </div>
    </div>

    


            <!-- Evoluciones -->
            <div class="card evolucion-card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center">Evoluciones</h4>
                    <ul class="mt-3">
                        @forelse([1, 2, 3] as $num)
                            @php
                                $evolucion = $digimon->{'evolucion' . $num};
                                $motivos = [];
                                $puedeEvolucionar = true;

                                if ($evolucion) {
                                    $nivelesMinimos = ['Bebé' => 5, 'Principiante' => 10, 'Campeón' => 15];
                                    $etapa = $digimon->etapa;
                                    if (isset($nivelesMinimos[$etapa])) {
                                        $nivelRequerido = $nivelesMinimos[$etapa];
                                        if ($digimon->nivel < $nivelRequerido) {
                                            $puedeEvolucionar = false;
                                            $motivos[] = "<span class='text-danger'>Nivel mínimo: {$nivelRequerido}</span>";
                                        } else {
                                            $motivos[] = "<span class='text-success'>Nivel suficiente: {$digimon->nivel} / {$nivelRequerido}</span>";
                                        }
                                    }

                                    if ($num > 1) {
                                        $elementoActual = strtolower($digimon->elemento);
                                        $elementoFuturo = strtolower($evolucion->elemento);

                                        $actualTiene = $digimon->{$elementoActual.'1'} && $digimon->{$elementoActual.'2'};
                                        $futuroTiene = $digimon->{$elementoFuturo.'1'} && $digimon->{$elementoFuturo.'2'};

                                        if (!($actualTiene || $futuroTiene)) {
                                            $puedeEvolucionar = false;

                                            // Mostrar llaves faltantes solo si se requieren
                                            $llavesFaltantesActual = [];
                                            $llavesFaltantesFuturo = [];

                                            if (!$digimon->{$elementoActual . '1'}) $llavesFaltantesActual[] = strtoupper($elementoActual . '1');
                                            if (!$digimon->{$elementoActual . '2'}) $llavesFaltantesActual[] = strtoupper($elementoActual . '2');
                                            if (!$digimon->{$elementoFuturo . '1'}) $llavesFaltantesFuturo[] = strtoupper($elementoFuturo . '1');
                                            if (!$digimon->{$elementoFuturo . '2'}) $llavesFaltantesFuturo[] = strtoupper($elementoFuturo . '2');

                                            $mensaje = 'Necesitas las llaves: ';
                                            if (!empty($llavesFaltantesActual)) {
                                                $mensaje .= ' [' . implode(' y ', $llavesFaltantesActual) . ']';
                                            }
                                            if (!empty($llavesFaltantesFuturo)) {
                                                if (!empty($llavesFaltantesActual)) {
                                                    $mensaje .= ' o ';
                                                }
                                                $mensaje .= ' [' . implode(' y ', $llavesFaltantesFuturo) . '] ';
                                            }

                                        $motivos[] = "<span class='text-danger'>{$mensaje}</span>";
                                        } else {
                                            // Mensaje cuando sí se cumple al menos una combinación
                                        $mensajeLlaves = '<span class="text-success">Tienes las llaves necesarias: ';
                                        if ($actualTiene) {
                                            $mensajeLlaves .= '[' . strtoupper($elementoActual . '1') . ' y ' . strtoupper($elementoActual . '2') . '] ';
                                        } elseif ($futuroTiene) {
                                            $mensajeLlaves .= '[' . strtoupper($elementoFuturo . '1') . ' y ' . strtoupper($elementoFuturo . '2') . '] ';
                                        }
                                        $mensajeLlaves .= '</span>';
                                        $motivos[] = $mensajeLlaves;

                                        }
                                    }
                                }
                            @endphp

                            @if($evolucion)
                                <li class="mb-4 text-center">
                                    <li class="mb-4">
                                    <div class="d-flex align-items-start justify-content-center gap-3">
                                        <div class="text-center">
                                            <img src="{{ $evolucion->video_gif }}" class="digimon-img mb-2" alt="{{ $evolucion->nombre }}">
                                            <p><strong>{{ $evolucion->nombre }}</strong></p>
                                        </div>
                                        <div class="flex-grow-1">
                                            @if($puedeEvolucionar)
                                                <form method="POST" action="{{ route('evolucionar', ['id' => $digimon->id]) }}">
                                                    @csrf
                                                    <input type="hidden" name="evolucion_id" value="{{ $evolucion->id }}">
                                                    <button class="btn btn-success mb-2">Evolucionar</button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger mb-2" disabled>Evolución bloqueada</button>
                                                <ul class="motivo-list">
                                                    @foreach($motivos as $motivo)
                                                        <li>{!! $motivo !!}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </li>


                            @endif
                        @empty
                            <p class="text-center">No hay evoluciones disponibles para este Digimon.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

       
    </div>

    @if(session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Éxito</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">{{ session('success') }}</div>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">{{ session('error') }}</div>
                </div>
            </div>
        </div>
    @endif

    <script>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));

        @if(session('success')) successModal.show(); @endif
        @if(session('error'))
            errorModal.show();
            errorModal._element.addEventListener('hidden.bs.modal', () => location.reload());
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <div class="blue-column right"></div>
 @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Evolucionar')->first();
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
