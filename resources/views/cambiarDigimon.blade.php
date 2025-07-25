<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Digimon</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            height: 100vh;
        }

        .blue-column {
    width: 10%;
    background-color: #2196f3;
    position: fixed;
    top: 0;
    bottom: 0;
    z-index: 0;
}

.left {
    left: 0;
    border-right: 5px solid #1976d2;
}

.right {
    right: 0;
    border-left: 5px solid #1976d2;
}


        .container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2,
        h3 {
            color: #388e3c;
        }

        h2 {
            margin-top: 20px;
        }

        .fixed-left-column {
            position: fixed;
            top: 20px;
            left: 200px;
            width: 500px;
            margin-left: 110px;
            
        }

        .right-column {
            margin-left: 300px;
            text-align: center; 
        }
        .right-column h3 {
    margin-left: 70px; 
}
        

        .digimon-card {
            width: 220px;
            padding: 15px;
            background-color: #388e3c;
            border-radius: 12px;
            margin: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            margin-left: 100px;
        }

        .digimon-card img {
            width: 100%;
            border-radius: 10px;
        }

        .main-digimon .digimon-card {
            background-image: url('https://i.imgur.com/qN00ZvO.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px;
            color: white;
            border-radius: 15px;
            text-align: center;
            border: 5px solid #66bb6a;
            z-index: 1; 

        }

        .btn-confirm,
        .btn-back,
        .btn-details {
            margin-top: 15px;
            padding: 12px 25px;
            background-color: #66bb6a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .btn-confirm:hover {
            background-color: #4caf50;
        }

        .btn-back {
            background-color: #2196f3;
            margin-top: 30px;
            width: 200px;
        }

        .btn-back:hover {
            background-color: #1976d2;
        }

        .video-oculto {
            display: none;
        }

        .unused-digimons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .unused-digimons .digimon-card {
            width: 45%;
            min-width: 200px;
        }

        @media (max-width: 600px) {
            .unused-digimons .digimon-card {
                width: 100%;
            }
        }
         /* Estilos para el modal */
         .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
    background-color: #fefefe;
    margin: 5% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 90%; 
    max-width: 830px;
    border-radius: 10px;
}


        .modal-header,
        .modal-body {
            margin-bottom: 15px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-delete {
    background-color: #e53935;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    margin-top: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-delete:hover {
    background-color: #c62828;
}

/* Colores por elemento */
.element-light {
    color: rgb(0, 0, 0);
    background-color: yellow;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-night {
    color: #fff;
    background-color: purple;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-machine {
    color: #fff;
    background-color: silver;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-bird {
    color: #fff;
    background-color: #87cefa;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-beast {
    color: #fff;
    background-color: orange;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-dragon {
    color: #fff;
    background-color: red;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-insect {
    color: #fff;
    background-color: green;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.element-water {
    color: #fff;
    background-color: blue;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.boolean-true {
    color: white;
    background-color: green;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.boolean-false {
    color: white;
    background-color: red;
    font-weight: bold;
    padding: 2px 6px;
    border-radius: 5px;
}
.fondo-gris {
    background-color: #e0e0e0;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: bold;
}

.verde {
    color: green;
}


    </style>
</head>

<body>

    <div class="blue-column left"></div>

    <div class="container">

        <div class="fixed-left-column">
            <h2>Selecciona tu Digimon Activo:</h2>

            <h3>Digimon Principal</h3>

            <div class="digimon-info">
                <p><strong>{{ $usuario->digimon->nombre }}</strong> | <strong>Nivel:</strong> {{ $usuario->digimon->nivel }}</p>
@php
    $claseElemento = 'element-' . strtolower($usuario->digimon->elemento);
@endphp

<p>
    <strong>Etapa:</strong> {{ $usuario->digimon->etapa }} |
    <strong>Elemento:</strong> <span class="{{ $claseElemento }}">{{ $usuario->digimon->elemento }}</span>
</p>

            </div>

            <div class="main-digimon">
                @if($usuario->digimon)
                    <div class="digimon-card">
                        <img src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $usuario->digimon->videogif) }}" alt="{{ $usuario->digimon->nombre }}">
                    </div>
                @else
                    <p>No tienes un Digimon principal asignado.</p>
                @endif
            </div>

            <div class="digimon-info">
                <p>
                    <strong>Vida:</strong> {{ $usuario->digimon->vidaActual() }} |
                    <strong>Ataque:</strong> {{ $usuario->digimon->ataqueActual() }} |
                    <strong>Defensa:</strong> {{ $usuario->digimon->defensaActual() }} |
                    <strong>Experiencia:</strong> {{ $usuario->digimon->experienciaPorcentaje() }}%
                </p>
            </div>
        </a>
        <button class="btn-details" id="btn-details">Detalles</button>
            <a href="{{ route('home') }}">
            
                <button class="btn-back">Volver al Inicio</button>
            </a>
        </div>

        <div class="right-column">
            <h3>Digimons en desuso</h3>

            <div class="unused-digimons">
                @foreach($digimons as $digimon)
                    @if($digimon->id !== $usuario->digimon_id)
                        <div class="digimon-card" data-id="{{ $digimon->id }}">
                            <img src="{{ str_replace('https://imgur.com/', 'https://i.imgur.com/', $digimon->videogif) }}" alt="{{ $digimon->nombre }}">
                            <p>{{ $digimon->nombre }}</p>
                            <button class="btn-confirm" data-id="{{ $digimon->id }}">Hacer Principal</button>
                            <button class="btn-delete" data-id="{{ $digimon->id }}">Eliminar</button>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="blue-column right"></div>
     <!-- Modal para mostrar detalles del Digimon -->
     <div id="digimonModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
<h2 id="modal-title">Detalles de {{ $usuario->digimon->nombre }}</h2>
            <div id="digimon-details">
                <!-- Aquí se mostrarán los detalles del Digimon -->
            </div>
        </div>
    </div>
    <script>
        // Obtener el modal
        var modal = document.getElementById("digimonModal");

        // Obtener el botón que abre el modal
        var btn = document.getElementById("btn-details");

        // Obtener el elemento <span> que cierra el modal
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario haga clic en el botón, abrir el modal
        btn.onclick = function () {
    fetch(`/digimon/{{ $usuario->digimon->id }}/detalles`)
        .then(response => response.json())
        .then(data => {
            const afinidadesFase = (fase) => {
    const tipos = ['night', 'light', 'machine', 'beast', 'bird', 'water', 'dragon', 'insect'];
    return tipos
        .map(tipo => {
            const clase = `element-${tipo}`;
            const estado = data[`${tipo}${fase}`]
                ? `<span class="estado fondo-gris verde">✔️</span>`
                : `<span class="estado fondo-gris">❌</span>`;
            return `<span class="${clase}">${tipo.charAt(0).toUpperCase() + tipo.slice(1)}: ${estado}</span>`;
        })
        .join(' | ');
};


    const claseElemento = `element-${data.elemento.toLowerCase()}`;
const clasePotencial = data.potencial_maximo ? 'boolean-true' : 'boolean-false';
const claseEntrenamiento = data.puede_entrenar ? 'boolean-true' : 'boolean-false';

const details = `
    <p><strong>${data.nombre}</strong> | Nivel: ${data.nivel} | Etapa: ${data.etapa} |
    <span class="${claseElemento}">${data.elemento}</span></p>
    <p><strong>Vida:</strong> ${data.vida_calculada} | <strong>Ataque:</strong> ${data.ataque_calculado} | <strong>Defensa:</strong> ${data.defensa_calculada}</p>
    <p><strong>Entrenamientos:</strong> ${data.numentrenamientos} / ${data.entrenamientos_maximos} |
    <strong>Puede entrenar:</strong> <span class="${claseEntrenamiento}">${data.puede_entrenar ? 'Sí' : 'No'}</span></p>
    <p><strong>Bonos:</strong> Evoluciones: ${data.num_evoluciones},Involuciones: ${data.bonoinvolucion}, Ataque Ent.: ${data.ataqueentrenamiento}, Defensa Ent.: ${data.defensaentrenamiento}, Vida Max Ent.: ${data.vidamaxentrenamiento}</p>
    <p><strong>Potencial máximo alcanzado:</strong>
    <span class="${clasePotencial}">${data.potencial_maximo ? 'Sí' : 'No'}</span></p>
    <p><strong>Afinidades Fase 1:</strong><br>${afinidadesFase(1)}</p>
    <p><strong>Afinidades Fase 2:</strong><br>${afinidadesFase(2)}</p>
`;


    document.getElementById('digimon-details').innerHTML = details;
    modal.style.display = "block";
})

        .catch(error => console.error("Error al cargar los detalles:", error));
};


        // Cuando el usuario haga clic en <span> (x), cerrar el modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // Cuando el usuario haga clic en cualquier lugar fuera del modal, cerrarlo
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    @php
        $cancion = \App\Models\ListaCancion::where('nombre', 'Cambiar')->first();
    @endphp

    @if($cancion)
    <div class="video-oculto">
        <iframe id="music-player" width="560" height="315"
            src="https://www.youtube.com/embed/{{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}?autoplay=1&loop=1&playlist={{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}&mute=0"
            frameborder="0"
            allow="autoplay; encrypted-media"
            allowfullscreen>
        </iframe>
    </div>
    
    @endif
    <script>
        // Verificar si ya hay un reproductor de música en ejecución
        if (!localStorage.getItem('musicPlaying')) {
            localStorage.setItem('musicPlaying', 'true');
    
            @php
                $cancion = \App\Models\ListaCancion::where('nombre', 'Cambiar')->first();
            @endphp
    
            @if($cancion)
            document.querySelector('.video-oculto').innerHTML = `<iframe id="music-player" width="560" height="315"
                src="https://www.youtube.com/embed/{{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}?autoplay=1&loop=1&playlist={{ substr(parse_url($cancion->enlace, PHP_URL_QUERY), 2) }}&mute=0"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen>
            </iframe>`;
            @endif
        }
    </script>
    
    

    <script>
        document.querySelectorAll('.btn-confirm').forEach(button => {
            button.addEventListener('click', function() {
                const digimonId = this.getAttribute('data-id');
                fetch('/cambiar-digimon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        digimon_id: digimonId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                      
    
                        // Recargar la página después de cambiar el Digimon
                        location.reload();
                    } else {
                        alert(data.message || 'Hubo un error al cambiar el Digimon');
                    }
                })
                .catch(error => console.error('Error al cambiar el Digimon:', error));
            });
        });
    </script>
  <script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const digimonId = this.getAttribute('data-id');

            if (confirm('¿Estás seguro de que deseas eliminar este Digimon? Esta acción no se puede deshacer.')) {
                fetch(`/eliminar-digimon/${digimonId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Digimon eliminado correctamente.');
                        location.reload();
                    } else {
                        alert(data.message || 'Error al eliminar el Digimon.');
                    }
                })
                .catch(error => console.error('Error al eliminar el Digimon:', error));
            }
        });
    });
</script>


    

</body>

</html>