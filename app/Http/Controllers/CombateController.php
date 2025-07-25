<?php

namespace App\Http\Controllers;

use App\Models\Digimon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ListaDigimon;


class CombateController extends Controller
{
    public function seleccionarRuta()
    {
        $rutas = [
            ['nombre' => 'Prado de los comienzos', 'imagen' => 'https://i.imgur.com/MiHnQIs.jpg', 'dificultad' => 'fácil'],
            ['nombre' => 'Oceano digital', 'imagen' => 'https://i.imgur.com/dNG8mHc.jpg', 'dificultad' => 'media'],
            ['nombre' => 'Isla Turquesa', 'imagen' => 'https://i.imgur.com/i4cHMBX.jpg', 'dificultad' => 'difícil'],
            ['nombre' => 'Montana citrina', 'imagen' => 'https://i.imgur.com/L8p9NeW.jpg', 'dificultad' => 'muy difícil'],
        ];

        return view('rutaseleccion', compact('rutas'));
    }

    public function iniciarCombate(Request $request)
    {
        $nombreRuta = $request->input('nombre_ruta');
        $dificultad = $request->input('dificultad');

        $usuario = Auth::user();
        $digimonUsuario = clone $usuario->digimon;

        $rutas = [
            ['nombre' => 'Prado de los comienzos', 'imagen' => 'https://i.imgur.com/MiHnQIs.jpg', 'dificultad' => 'fácil'],
            ['nombre' => 'Oceano digital', 'imagen' => 'https://i.imgur.com/dNG8mHc.jpg', 'dificultad' => 'media'],
            ['nombre' => 'Isla Turquesa', 'imagen' => 'https://i.imgur.com/i4cHMBX.jpg', 'dificultad' => 'difícil'],
            ['nombre' => 'Montana citrina', 'imagen' => 'https://i.imgur.com/L8p9NeW.jpg', 'dificultad' => 'muy difícil'],
        ];

        $rutaSeleccionada = collect($rutas)->firstWhere('nombre', $nombreRuta);
    $rutaImagen = $rutaSeleccionada['imagen'];

        $etapas = [
            'fácil' => 'Bebé',
            'media' => 'Principiante',
            'difícil' => 'Campeón',
            'muy difícil' => 'Mega-Campeón',
        ];

        $etapaEnemigo = $etapas[$dificultad] ?? 'Bebé';

        $listaBase = ListaDigimon::where('etapa', $etapaEnemigo)
    ->inRandomOrder()
    ->first();

$nivelUsuario = $digimonUsuario->nivel;
$nivelEnemigo = max(1, $nivelUsuario + rand(-2, 2)); // Nivel entre -2 y +2 del usuario (mínimo 1)

// Crear instancia "temporal" de Digimon enemigo usando los datos de ListaDigimon
$digimonEnemigo = new Digimon([
    'nombre' => $listaBase->nombre,
    'id_lista_digimon' => $listaBase->id,
    'nivel' => $nivelEnemigo,
    'ataquebase' => $listaBase->ataquebase,
    'defensabase' => $listaBase->defensabase,
    'vidabase' => $listaBase->vidabase,
    'experienciabase' => $listaBase->experienciabase,
    'etapa' => $listaBase->etapa,
    'videogif' => $listaBase->video_gif,
    'elemento' => $listaBase->elemento,

    'felicidad' => 50, // Puedes ajustar este valor
]);

$digimonUsuario->vidarestante = $digimonUsuario->vidaActual();
$digimonEnemigo->vidarestante = $digimonEnemigo->vidaActual();

$colorClase = match(strtolower($dificultad)) {
    'fácil' => 'facil',
    'media' => 'media',
    'difícil' => 'dificil',
    'muy difícil' => 'muy-dificil',
    default => 'facil', 
};

        session([
            'digimonUsuario' => $digimonUsuario,
            'digimonEnemigo' => $digimonEnemigo,
            'enemigoCurado' => false,
            'usuarioDefendiendo' => false,
            'nombreRuta' => $nombreRuta,
            'dificultad' => $dificultad,
            'rutaImagen' => $rutaImagen,
            'turno' => 1,
            'cooldownEspecial' => 0, // 0 significa listo para usar
            'usuarioDefensaCooldown' => 0,
            'colorClase' => $colorClase,

        ]);

        return redirect()->route('combate.mostrar');    }

    public function ejecutarAccion(Request $request)
{
    $accion = $request->input('accion');
    $digimonUsuario = session('digimonUsuario');
    $digimonEnemigo = session('digimonEnemigo');
    $enemigoCurado = session('enemigoCurado', false);
    $usuarioDefendiendo = session('usuarioDefendiendo', false);
    $mensaje = '';
    $colorClase = session('colorClase', 'facil');

    $turno = session('turno', 0);
$cooldownEspecial = session('cooldownEspecial', 0);
$elemento = strtolower($digimonUsuario->elemento);
$especialDisponible = false;
$usuarioDefensaCooldown = session('usuarioDefensaCooldown', 0);


// Comprobar si tiene el atributo especial activo (light3, water3, etc.)
// Y han pasado al menos 3 turnos (es decir, estamos en el turno 4 o más)
$atributoEspecial = $elemento . '3';
if ($digimonUsuario->$atributoEspecial && $cooldownEspecial <= 0 && $turno >= 2) {
    $especialDisponible = true;
}


if ($accion === 'defender' && $usuarioDefensaCooldown > 0) {
    $mensaje = "Tu Digimon no puede defenderse en este turno.";
} else {
    switch ($accion) {
        case 'atacar':
    $nivel = $digimonUsuario->nivel;
    $ataque = $digimonUsuario->ataqueActual();
    $defensa = $digimonEnemigo->defensaActual();
    $potencia = 300;

    $daño = (((2 * $nivel / 5 + 2) * $ataque * $potencia) / $defensa) / 50 + 2;
    $daño = max(1, intval($daño));

    $digimonEnemigo->vidarestante -= $daño;
    $mensaje = "Tu Digimon atacó e hizo $daño de daño al enemigo.";
    break;


        case 'defender':
            $usuarioDefendiendo = true;
            $mensaje = "Tu Digimon se está defendiendo.";
            $usuarioDefensaCooldown = 2; // Activa el cooldown de defensa para el próximo turno
            break;

        case 'curarse':
            $curado = intval($digimonUsuario->vidaActual() * 0.5);
            $digimonUsuario->vidarestante = min($digimonUsuario->vidaActual(), $digimonUsuario->vidarestante + $curado);
            $mensaje = "Tu Digimon se curó $curado puntos de vida.";
            break;

        case 'huir':
            session()->flash('redireccionar', true);

    $mensaje .= "Has huido del combate";

            return view('combate', [
                'nombreRuta' => session('nombreRuta'),
                'dificultad' => session('dificultad'),
                'digimonUsuario' => $digimonUsuario,
                'digimonEnemigo' => $digimonEnemigo,
                'mensaje' => $mensaje,
                'rutaImagen' => session('rutaImagen'),
                'especialDisponible' => $especialDisponible,
                'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
                'colorClase' => $colorClase,

            ]);
            return redirect()->route('home')->with('mensaje', 'Huiste del combate.');

        case 'capturar':
        $usuario = Auth::user(); 

             // Verificar si el usuario ya tiene 15 Digimon
    $cantidadDigimon = Digimon::where('id_usuario', $usuario->id)->count();
    if ($cantidadDigimon >= 15) {
        $mensaje = "¡Tu caja está llena! No puedes capturar más Digimon.";
        break;
    }
    $probabilidadesBase = [
        'Bebé' => 0.8,
        'Principiante' => 0.6,
        'Campeón' => 0.4,
        'Mega-Campeón' => 0.2,
    ];

    $porcentajeVida = $digimonEnemigo->vidarestante / $digimonEnemigo->vidaActual();
    $base = $probabilidadesBase[$digimonEnemigo->etapa] ?? 0.3;
    $probabilidadFinal = $base * (1 - $porcentajeVida); // cuanto menos vida, más posibilidad
 
    if (mt_rand() / mt_getrandmax() < $probabilidadFinal) {
$digimonBase = ListaDigimon::where('id', $digimonEnemigo->id_lista_digimon)->first();
        // Captura exitosa
        $nuevoDigimon = new Digimon([
            

            'id_usuario' => $usuario->id,
            'id_lista_digimon' => $digimonBase->id,
            'nombre' => $digimonEnemigo->nombre,
            'nivel' => $digimonEnemigo->nivel ?? 0,
            'ataquebase' => $digimonBase->ataquebase ?? 0,
            'defensabase' => $digimonBase->defensabase ?? 0,
            'vidabase' => $digimonBase->vidabase ?? 0,
            'experienciabase' => $digimonBase->experienciabase ?? 0,
            'experienciaactual' => 0,
            'experienciasiguientenivel' => $digimonBase->experienciasiguientenivel ?? 100,
            'idevolucion' => $digimonBase->idevolucion,
            'idinvolucion' => $digimonBase->idinvolucion,
            'etapa' => $digimonBase->etapa ?? 'Desconocida',
            'videogif' => $digimonBase->video_gif ?? '',
            'elemento' => $digimonBase->elemento,
            'idevolucion2' => $digimonBase->idevolucion2,
            'idinvolucion2' => $digimonBase->idinvolucion2,
            'idevolucion3' => $digimonBase->idevolucion3,
            'idinvolucion3' => $digimonBase->idinvolucion3,

            'hambre' => 50,
            'salud' => 50,
            'caca' => 50,
            'higiene' => 50,
            'felicidad' => 50,

            'numentrenamientos' => 0,
            'bono_involucion' => 0,
            'ataque_entrenamiento' => 0,
            'defensa_entrenamiento' => 0,
            'vida_max_entrenamiento' => 0,

            'night2' => false,
            'light2' => false,
            'machine2' => false,
            'beast2' => false,
            'bird2' => false,
            'water2' => false,
            'dragon2' => false,
            'insect2' => false,

            'night3' => false,
            'light3' => false,
            'machine3' => false,
            'beast3' => false,
            'bird3' => false,
            'water3' => false,
            'dragon3' => false,
            'insect3' => false,

            'numllave1' => 0,
            'numllave2' => 0,
            'numllavenecesaria1' => 1,
            'numllavenecesaria2' => 1,

            'num_evoluciones' => 0,
        ]);

        $nuevoDigimon->save();

        // Obtener la lista de Digimones adquiridos
        $adquiridos = $usuario->digimones_adquiridos;

        // Convertir la lista de Digimones adquiridos en un array
        $adquiridosArray = explode(',', $adquiridos);

        // Verificar si el ID del nuevo Digimon ya está en la lista
        if (!in_array($nuevoDigimon->id_lista_digimon, $adquiridosArray)) {
            // Si no está en la lista, añadirlo
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $nuevoDigimon->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $nuevoDigimon->id_lista_digimon;
            }
            $usuario->save();
        }
        session()->flash('redireccionar', true);

    $mensaje .= "¡Capturaste a $digimonEnemigo->nombre exitosamente!";

            return view('combate', [
                'nombreRuta' => session('nombreRuta'),
                'dificultad' => session('dificultad'),
                'digimonUsuario' => $digimonUsuario,
                'digimonEnemigo' => $digimonEnemigo,
                'mensaje' => $mensaje,
                'rutaImagen' => session('rutaImagen'),
                'especialDisponible' => $especialDisponible,
                'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
                'colorClase' => $colorClase,

            ]);
        return redirect()->route('home')->with('mensaje', '¡Capturaste a ' . $digimonEnemigo->nombre . ' exitosamente!');
    } else {
        $mensaje = "Intentaste capturar al Digimon, pero escapó.";
    }
    break;


        case 'ataque-especial':
    if ($especialDisponible) {
        $nivel = $digimonUsuario->nivel;
        $ataque = $digimonUsuario->ataqueActual();
        $defensa = $digimonEnemigo->defensaActual();
        $potencia = 480; // Más fuerte que el ataque normal

        $dañoEspecial = (((2 * $nivel / 5 + 2) * $ataque * $potencia) / $defensa) / 50 + 2;
        $dañoEspecial = max(1, intval($dañoEspecial));

        $digimonEnemigo->vidarestante -= $dañoEspecial;
        $mensaje = "¡Ataque especial activado! Tu Digimon hizo $dañoEspecial de daño.";
        $cooldownEspecial = 2;
        $especialDisponible = false;
    } else {
        $mensaje = "El ataque especial no está disponible aún.";
    }
    break;
    case 'ataque-elemental':
    $elemento = strtolower($digimonUsuario->elemento);
    $habilidad = $elemento . '1';

    // Verificar si el usuario tiene el elemento1 correspondiente
    if ($digimonUsuario->$habilidad) {
        $nivel = $digimonUsuario->nivel;
        $ataque = $digimonUsuario->ataqueActual();
        $defensa = $digimonEnemigo->defensaActual();
        $potencia = 350; // misma que ataque normal

        // Obtener modificador por tipo
        $modificador = $this->calcularMultiplicadorElemento($digimonUsuario->elemento, $digimonEnemigo->elemento);

        // Cálculo con modificador
        $daño = ((((2 * $nivel / 5 + 2) * $ataque * $potencia) / $defensa) / 50 + 2) * $modificador;
        $daño = max(1, intval($daño));

        $digimonEnemigo->vidarestante -= $daño;

        if ($modificador > 1) {
            $mensaje = "¡Ataque elemental efectivo! Tu Digimon hizo $daño de daño.";
        } elseif ($modificador < 1) {
            $mensaje = "¡Ataque poco efectivo! Tu Digimon hizo $daño de daño.";
        } else {
            $mensaje = "Tu Digimon usó ataque elemental e hizo $daño de daño.";
        }
    } else {
        $mensaje = "Tu Digimon no tiene desbloqueado el ataque elemental.";
    }
    break;


    }
    }

    // Si el enemigo ha sido derrotado
    if ($digimonEnemigo->vidarestante <= 0) {
    $experienciaGanada = $digimonEnemigo->experienciabase * $digimonEnemigo->nivel * 0.2;

    $digimonReal = Auth::user()->digimon;
    $usuarioReal = Auth::user(); // Obtener el usuario real

    $digimonReal->experienciaactual += $experienciaGanada;

    while ($digimonReal->experienciaactual >= $digimonReal->experienciasiguientenivel) {
        $digimonReal->nivel++;
        $digimonReal->experienciaactual -= $digimonReal->experienciasiguientenivel;
        $digimonReal->experienciasiguientenivel = $this->calcularExperienciaSiguienteNivel($digimonReal);

        if ($digimonReal->etapa == 'Campeón' && $digimonReal->nivel >= 5) {
            switch (strtolower($digimonReal->elemento)) {
                case 'night': $digimonReal->night2 = true; break;
                case 'light': $digimonReal->light2 = true; break;
                case 'machine': $digimonReal->machine2 = true; break;
                case 'beast': $digimonReal->beast2 = true; break;
                case 'bird': $digimonReal->bird2 = true; break;
                case 'water': $digimonReal->water2 = true; break;
                case 'dragon': $digimonReal->dragon2 = true; break;
                case 'insect': $digimonReal->insect2 = true; break;
            }
            $digimonReal->numllave1 += 1;
        }
    }

    // Cálculo de dinero ganado
    $dineroGanado = $digimonEnemigo->nivel * 100;
    $limites = [
        'fácil' => 500,
        'media' => 1000,
        'difícil' => 1500,
        'muy difícil' => 2000,
    ];
    $maximoPermitido = $limites[strtolower(session('dificultad'))] ?? 500;
    $dineroGanado = min($dineroGanado, $maximoPermitido);

    // Sumar dinero al usuario
    $usuarioReal->dinero += $dineroGanado;

    $digimonReal->save();
    $usuarioReal->save();

    session()->flash('finCombate', 'Has ganado el combate, ganado ' . $experienciaGanada . ' de experiencia y ' . $dineroGanado . ' bits.');
    session()->flash('redireccionar', true);

    $mensaje .= "Has ganado el combate, ganado $experienciaGanada de experiencia y $dineroGanado bits.";

            return view('combate', [
                'nombreRuta' => session('nombreRuta'),
                'dificultad' => session('dificultad'),
                'digimonUsuario' => $digimonUsuario,
                'digimonEnemigo' => $digimonEnemigo,
                'mensaje' => $mensaje,
                'rutaImagen' => session('rutaImagen'),
                'especialDisponible' => $especialDisponible,
                'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
                'colorClase' => $colorClase,

            ]);
}
 else {
        // Turno del enemigo si el jugador no ganó
        $accionEnemigo = !$enemigoCurado ? ['atacar', 'curarse'][rand(0, 1)] : 'atacar';

        if ($accionEnemigo === 'curarse') {
            $curado = intval($digimonEnemigo->vidaActual() * 0.5);
            $digimonEnemigo->vidarestante = min($digimonEnemigo->vidaActual(), $digimonEnemigo->vidarestante + $curado);
            $mensaje .= " El enemigo se curó $curado puntos de vida.";
            $enemigoCurado = true;
        } else {
$dañoEnemigo = (((2 * $digimonEnemigo->nivel / 5 + 2) * $digimonEnemigo->ataqueActual() * 300) / $digimonUsuario->defensaActual()) / 50 + 2;
$dañoEnemigo = max(1, intval($dañoEnemigo));
            if (!$usuarioDefendiendo) {
                $digimonUsuario->vidarestante -= $dañoEnemigo;
                $mensaje .= " El enemigo atacó e hizo $dañoEnemigo de daño.";
            } else {
                $mensaje .= " El enemigo atacó pero tu Digimon se defendió y no recibió daño.";
                $usuarioDefendiendo = false;
            }
        }

        if ($digimonUsuario->vidarestante <= 0) {
            session()->flash('finCombate', 'Tu Digimon fue derrotado.');
            session()->flash('redireccionar', true);

            return view('combate', [
                'nombreRuta' => session('nombreRuta'),
                'dificultad' => session('dificultad'),
                'digimonUsuario' => $digimonUsuario,
                'digimonEnemigo' => $digimonEnemigo,
                'mensaje' => 'Tu Digimon fue derrotado.',
                'rutaImagen' => session('rutaImagen'),
                'especialDisponible' => $especialDisponible,
                'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
                'colorClase' => $colorClase,

            ]);
        }
    }

    // Final del turno: avanzar turno y reducir cooldown
    $turno++;
    if ($cooldownEspecial > 0) {
        $cooldownEspecial--;
    }
    if ($usuarioDefensaCooldown > 0) {
    $usuarioDefensaCooldown--;
}

    session([
        'turno' => $turno,
        'cooldownEspecial' => $cooldownEspecial,
        'digimonUsuario' => $digimonUsuario,
        'digimonEnemigo' => $digimonEnemigo,
        'enemigoCurado' => $enemigoCurado,
        'usuarioDefendiendo' => $usuarioDefendiendo,
        'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
        'colorClase' => $colorClase,
    
    ]);

    return view('combate', [
        'nombreRuta' => session('nombreRuta'),
        'dificultad' => session('dificultad'),
        'digimonUsuario' => $digimonUsuario,
        'digimonEnemigo' => $digimonEnemigo,
        'mensaje' => $mensaje,
        'rutaImagen' => session('rutaImagen'),
        'especialDisponible' => $especialDisponible,
        'usuarioDefensaCooldown' => $usuarioDefensaCooldown,
        'colorClase' => $colorClase,
    ]);
}


   public function mostrarCombate()
{
    // Si no hay sesión activa, redirigir al home
    if (!session()->has('digimonUsuario') || !session()->has('digimonEnemigo')) {
        return redirect()->route('home')->with('mensaje', 'No hay un combate activo.');
    }

    $digimonUsuario = session('digimonUsuario');
    $digimonEnemigo = session('digimonEnemigo');
    $nombreRuta = session('nombreRuta');
    $dificultad = session('dificultad');
    $rutaImagen = session('rutaImagen');
    $mensaje = session('mensaje', '');
    $turno = session('turno', 1);
    $cooldownEspecial = session('cooldownEspecial', 0);
    $usuarioDefensaCooldown = session('usuarioDefensaCooldown', 0);
    $colorClase= session('colorClase', 'facil');
    $elemento = strtolower($digimonUsuario->elemento);
    $atributoEspecial = $elemento . '3';

    $especialDisponible = $digimonUsuario->$atributoEspecial && $cooldownEspecial <= 0 && $turno >= 2;

    return view('combate', compact(
        'digimonUsuario',
        'digimonEnemigo',
        'nombreRuta',
        'dificultad',
        'rutaImagen',
        'mensaje',
        'turno',
        'especialDisponible',
        'usuarioDefensaCooldown',
        'colorClase',
    ));

}

    
    private function calcularExperienciaSiguienteNivel($digimon)
{
    switch ($digimon->etapa) {
        case 'Bebé':
            return $digimon->experienciasiguientenivel + 5;
        case 'Principiante':
            return $digimon->experienciasiguientenivel + 10;
        case 'Campeón':
            return $digimon->experienciasiguientenivel + 20;
        case 'Mega-Campeón':
            return $digimon->experienciasiguientenivel + 30;
        default:
            return $digimon->experienciasiguientenivel + 5;
    }
}
private function calcularMultiplicadorElemento(string $elementoAtacante, string $elementoDefensor): float
{
    $fortalezas = [
        'light' => 'night',
        'night' => 'light',
        'insect' => 'water',
        'water' => 'dragon',
        'dragon' => 'insect',
        'beast' => 'machine',
        'machine' => 'bird',
        'bird' => 'beast'
    ];

    $debilidades = [
        'insect' => 'dragon',
        'water' => 'insect',
        'dragon' => 'water',
        'beast' => 'bird',
        'machine' => 'beast',
        'bird' => 'machine'
    ];

    if (isset($fortalezas[$elementoAtacante]) && $fortalezas[$elementoAtacante] === $elementoDefensor) {
        return 1.5;
    }

    if (isset($debilidades[$elementoAtacante]) && $debilidades[$elementoAtacante] === $elementoDefensor) {
        return 0.5;
    }

    return 1.0; // Sin ventaja ni desventaja
}


    

}
