<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Digimon;
use App\Models\CombateOnline;

class CombateDefensorOnlineController extends Controller
{
    public function iniciarCombateContraDefensor($idCombate)
    {

        $combate = CombateOnline::findOrFail($idCombate);
        session(['combateOnlineId' => $combate->id]);

        // Obtenemos el Digimon defensor desde su ID
$digimonOriginal = Digimon::findOrFail($combate->id_digimon_defensor);

        // Clonamos al Digimon defensor como enemigo temporal
        $digimonEnemigo = new Digimon($digimonOriginal->toArray());
        $digimonEnemigo->vidarestante = $digimonEnemigo->vidaActual();

        // Obtener el Digimon del usuario autenticado
        $digimonUsuario = clone Auth::user()->digimon;
        $digimonUsuario->vidarestante = $digimonUsuario->vidaActual();

        session([
            'digimonUsuario' => $digimonUsuario,
            'digimonEnemigo' => $digimonEnemigo,
            'enemigoCurado' => false,
            'usuarioDefendiendo' => false,
            'nombreRuta' => 'Desafío Online',
            'dificultad' => 'online',
            'rutaImagen' => 'https://i.imgur.com/tTQSAYw.jpg', // Imagen directa para combates online
            'turno' => 1,
            'cooldownEspecial' => 0,
            'usuarioDefensaCooldown' => 0,
            'colorClase' => 'online'
        ]);

        return redirect()->route('combate.mostrar2');
    }



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
    $combate = CombateOnline::find(session('combateOnlineId'));

    // Usuario gana
    $combateGanador = CombateOnline::where('id_usuario', Auth::id())->first();
    if ($combateGanador) {
        $combateGanador->victorias += 1;
        $combateGanador->puntos += 10;
        $combateGanador->save();
    }
    if ($combateGanador) {
    $idEnemigo = $combate->id_usuario;
    $usuariosCombatidos = explode(',', $combateGanador->usuarios_combatidos);
    if (!in_array($idEnemigo, $usuariosCombatidos)) {
        $usuariosCombatidos[] = $idEnemigo;
        $combateGanador->usuarios_combatidos = implode(',', array_filter($usuariosCombatidos));
        $combateGanador->save();
    }
}


    // Penalizar al defensor
    $combateEnemigo = CombateOnline::where('id_usuario', $combate->id_usuario)->first();
    if ($combateEnemigo) {
        $combateEnemigo->puntos = max(0, $combateEnemigo->puntos - 3);
        $combateEnemigo->save();
    }

    $this->actualizarClasificaciones();
    session()->flash('finCombate', 'Has ganado el combate');
    session()->flash('redireccionar', true);
   
    return view('combate_online/combate2', [
                'nombreRuta' => session('nombreRuta'),
                'dificultad' => session('dificultad'),
                'digimonUsuario' => $digimonUsuario,
                'digimonEnemigo' => $digimonEnemigo,
                'mensaje' => 'Has ganado el combate',
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
       // Usuario pierde
       $combate = CombateOnline::find(session('combateOnlineId'));

$combatePerdedor = CombateOnline::where('id_usuario', Auth::id())->first();
if ($combatePerdedor) {
    $combatePerdedor->derrotas += 1;
    $combatePerdedor->puntos = max(0, $combatePerdedor->puntos - 5);
    $combatePerdedor->save();
}
if ($combatePerdedor) {
    $idEnemigo = $combate->id_usuario;
    $usuariosCombatidos = explode(',', $combatePerdedor->usuarios_combatidos);
    if (!in_array($idEnemigo, $usuariosCombatidos)) {
        $usuariosCombatidos[] = $idEnemigo;
        $combatePerdedor->usuarios_combatidos = implode(',', array_filter($usuariosCombatidos));
        $combatePerdedor->save();
    }
}


// Premiar al defensor
$combateEnemigo = CombateOnline::where('id_usuario', $combate->id_usuario)->first();
if ($combateEnemigo) {
    $combateEnemigo->puntos += 6;
    $combateEnemigo->save();
}



// Recalcular clasificación
$this->actualizarClasificaciones();

            session()->flash('finCombate', 'Tu Digimon fue derrotado.');
            session()->flash('redireccionar', true);

            return view('combate_online/combate2', [
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

    return view('combate_online/combate2', [
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

    return view('combate_online/combate2', compact(
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
private function actualizarClasificaciones()
{
    $usuarios = CombateOnline::orderByDesc('puntos')->get();

    foreach ($usuarios as $index => $usuario) {
        $usuario->clasificacion = $index + 1;
        $usuario->save();
    }
}

}
