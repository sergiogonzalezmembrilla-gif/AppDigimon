<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Digimon;
use Illuminate\Support\Facades\Auth;

class CuidadoDigimonController extends Controller
{
    public function cuidar()
    {
        $usuario = Auth::user();
        $digimon = Digimon::find($usuario->digimon_id);

        if ($digimon) {
            return view('cuidar', compact('digimon'));
        }

        return redirect()->route('home')->with('error', 'No tienes un Digimon activo.');
    }

    public function reducirStats()
    {
        $usuario = Auth::user();
        $digimon = $usuario->digimon;

        if ($digimon) {
            $digimon->hambre = max(0, $digimon->hambre - rand(1, 3));
            $digimon->salud = max(0, $digimon->salud - rand(1, 3));
            $digimon->caca = max(0, $digimon->caca - rand(1, 3));
            $digimon->higiene = max(0, $digimon->higiene - rand(1, 3));
            $this->actualizarFelicidad($digimon);
            $digimon->save();

            return response()->json([
                'hambre' => $digimon->hambre,
                'salud' => $digimon->salud,
                'caca' => $digimon->caca,
                'higiene' => $digimon->higiene,
                'felicidad' => $digimon->felicidad,
                'vidaActual' => $digimon->vidaActual(),
                'ataqueActual' => $digimon->ataqueActual(),
                'defensaActual' => $digimon->defensaActual()
            ]);
        }

        return response()->json(['error' => 'No se encontró el Digimon'], 404);
    }

    public function incrementarHambre($digimonId, $porcentaje)
{
    return $this->restaurarStat(Digimon::find($digimonId), $porcentaje, 'hambre');
}

public function incrementarCaca($digimonId, $porcentaje)
{
    return $this->restaurarStat(Digimon::find($digimonId), $porcentaje, 'caca');
}

public function incrementarSalud($digimonId, $porcentaje)
{
    return $this->restaurarStat(Digimon::find($digimonId), $porcentaje, 'salud');
}

public function incrementarHigiene($digimonId, $porcentaje)
{
    return $this->restaurarStat(Digimon::find($digimonId), $porcentaje, 'higiene');
}


    private function restaurarStat($digimon, $porcentaje, $atributo)
{
    $usuario = Auth::user();
    $bonoTotal = min(50, $digimon->num_evoluciones + $digimon->bonoinvolucion);
    $costo = $porcentaje == 50
        ? 100 + ($bonoTotal * 25)
        : 200 + ($bonoTotal * 50);

    if ($usuario->dinero < $costo) {
        return redirect()->route('cuidar.digimon')->with('error', 'No tienes suficiente dinero.');
    }

    $incremento = $porcentaje == 50 ? 50 : 100;
    $digimon->$atributo = min(100, $digimon->$atributo + $incremento);
    $this->actualizarFelicidad($digimon);
    $digimon->save();

    $usuario->dinero -= $costo;
    $usuario->save();

    return redirect()->route('cuidar.digimon');
}


    private function actualizarFelicidad($digimon)
    {
        $digimon->felicidad = min(100, round(($digimon->hambre + $digimon->caca + $digimon->salud + $digimon->higiene) / 4));
    }
}
