<?php

namespace App\Http\Controllers;

use App\Models\CombateOnline;
use App\Models\Digimon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CombateOnlineController extends Controller
{
    public function index()
{
    $combate = CombateOnline::where('id_usuario', Auth::id())->first();

    if ($combate) {
        // Revisar si ya pasó un día desde el último reset
        if (!$combate->ultima_reset || now()->diffInHours($combate->ultima_reset) >= 24) {
            $combate->usuarios_combatidos = null;
            $combate->ultima_reset = now();
            $combate->save();
        }
    }

    return view('combate_online.index', compact('combate'));
}


    public function mostrarDeposito()
{
    $usuario = Auth::user(); // Obtener usuario autenticado
    $digimonActualId = $usuario->digimon_id; // Obtener el digimon actual

    // Excluir el digimon actual del listado
    $digimons = Digimon::where('id_usuario', $usuario->id)
        ->where('ocupado', false)
        ->when($digimonActualId, function ($query, $digimonActualId) {
            return $query->where('id', '!=', $digimonActualId);
        })
        ->get();

    return view('combate_online.depositar', compact('digimons'));
}


   public function depositar($id)
{
    $digimon = Digimon::findOrFail($id);
    $digimon->ocupado2 = true;
    $digimon->save();

    $combate = CombateOnline::where('id_usuario', Auth::id())->first();

    if ($combate) {
        // Si ya existe, solo actualizamos el digimon defensor
        $combate->id_digimon_defensor = $id;
        $combate->save();
    } else {
        // Si no existe, lo creamos
        CombateOnline::create([
            'id_usuario' => Auth::id(),
            'id_digimon_defensor' => $id,
        ]);
    }

    return redirect()->route('combate_online.index')->with('success', 'Digimon depositado para combate.');
}

    public function retirar()
{
    $combate = CombateOnline::where('id_usuario', Auth::id())->first();

    if ($combate && $combate->digimon) {
        // Liberar al digimon
        $digimon = $combate->digimon;
        $digimon->ocupado = false;
        $digimon->save();

        // Retirar del combate
$combate->id_digimon_defensor = null;
        $combate->save();
    }

    return redirect()->route('combate_online.index')->with('success', 'Digimon retirado del combate.');
}
public function buscarCombatientes()
{
    // Obtener el registro del usuario actual
    $combate = CombateOnline::where('id_usuario', Auth::id())->first();

    if (!$combate) {
        $combate = CombateOnline::create([
            'id_usuario' => Auth::id(),
            'id_digimon_defensor' => null,
            'victorias' => 0,
            'derrotas' => 0,
            'empates' => 0,
            'clasificacion' => 0,
            'puntos' => 0,
        ]);
    }

    // Convertir la lista de usuarios combatidos en array
    $idsCombatidos = [];
    if ($combate->usuarios_combatidos) {
        $idsCombatidos = explode(',', $combate->usuarios_combatidos);
    }

    // Obtener combatientes disponibles
    $combatientes = CombateOnline::with('digimon', 'usuario')
        ->whereNotNull('id_digimon_defensor')
        ->where('id_usuario', '!=', Auth::id())
        ->whereNotIn('id_usuario', $idsCombatidos) // excluir usuarios combatidos
        ->orderByDesc('puntos')
        ->get();

    return view('combate_online.buscar', compact('combatientes'));
}




}
