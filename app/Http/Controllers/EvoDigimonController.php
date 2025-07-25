<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Digimon;
use App\Models\ListaDigimon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EvoDigimonController extends Controller
{
    public function mostrarevo()
    {
        $usuario = Auth::user();
        $digimon = $usuario->digimon;

        if ($digimon) {
            $evoluciones = [
                'evolucion1' => $digimon->evolucion1,
                'evolucion2' => $digimon->evolucion2,
                'evolucion3' => $digimon->evolucion3,
            ];

            $involuciones = [
                'involucion1' => $digimon->involucion1,
                'involucion2' => $digimon->involucion2,
                'involucion3' => $digimon->involucion3,
            ];

            return view('evolucionar', compact('digimon', 'evoluciones', 'involuciones'));
        }

        return redirect()->route('home')->with('error', 'No tienes un Digimon activo.');
    }

  public function evolucionar(Request $request, $id)
{
    Log::info('Llamada al método evolucionar con ID Digimon actual: ' . $id);
    Log::info('Datos del request: ', $request->all());

    $usuario = Auth::user();
    $digimon = $usuario->digimon;

    if (!$digimon || $digimon->id != $id) {
        return redirect()->route('home')->with('error', 'No tienes un Digimon activo válido.');
    }

    $evolucionId = $request->input('evolucion_id');
    $evolucion = ListaDigimon::find($evolucionId);

    if (!$evolucion) {
        return back()->with('error', 'Evolución no válida.');
    }

    // Validaciones
    $nivelesMinimos = [
        'Bebé' => 5,
        'Principiante' => 10,
        'Campeón' => 15,
    ];

    if (isset($nivelesMinimos[$digimon->etapa]) && $digimon->nivel < $nivelesMinimos[$digimon->etapa]) {
        return back()->with('error', "Tu Digimon necesita nivel {$nivelesMinimos[$digimon->etapa]} para evolucionar.");
    }

    

    
   // Validación de elementos
$elementoActual = strtolower($digimon->elemento);
$elementoFuturo = strtolower($evolucion->elemento);

// Comprobación de llaves actuales y futuras
$actualKey1 = $elementoActual . '1';
$actualKey2 = $elementoActual . '2';
$futuroKey1 = $elementoFuturo . '1';
$futuroKey2 = $elementoFuturo . '2';

$errores = [];

if (in_array($evolucionId, [$digimon->idevolucion2, $digimon->idevolucion3])) {
    $actualTiene = $digimon->$actualKey1 && $digimon->$actualKey2;
    $futuroTiene = $digimon->$futuroKey1 && $digimon->$futuroKey2;

    if (!$actualTiene && !$futuroTiene) {
        $faltantes = [];

        if (!$digimon->$actualKey1) $faltantes[] = strtoupper($actualKey1);
        if (!$digimon->$actualKey2) $faltantes[] = strtoupper($actualKey2);
        if (!$digimon->$futuroKey1) $faltantes[] = strtoupper($futuroKey1);
        if (!$digimon->$futuroKey2) $faltantes[] = strtoupper($futuroKey2);

        return back()->with('error', 'Faltan las siguientes llaves elementales: ' . implode(', ', $faltantes));
    }

    // Mensaje opcional si tiene todas
    $llaves = [];
    if ($actualTiene) {
        $llaves[] = "Actuales: " . strtoupper($actualKey1) . ", " . strtoupper($actualKey2);
    }
    if ($futuroTiene) {
        $llaves[] = "Futuras: " . strtoupper($futuroKey1) . ", " . strtoupper($futuroKey2);
    }

    session()->flash('success', 'Tienes las llaves necesarias para evolucionar. ' . implode(' | ', $llaves));
}


    // Aplicar evolución
    $digimon->nombre = $evolucion->nombre;
    $digimon->nivel = $evolucion->nivel;
    $digimon->ataquebase = $evolucion->ataquebase;
    $digimon->defensabase = $evolucion->defensabase;
    $digimon->vidabase = $evolucion->vidabase;
    $digimon->experienciabase = $evolucion->experienciabase;
    $digimon->experienciasiguientenivel = $evolucion->experienciasiguientenivel;
    $digimon->experienciaactual = 0;
    $digimon->etapa = $evolucion->etapa;
    $digimon->videogif = $evolucion->video_gif;
    $digimon->elemento = $evolucion->elemento;

    // IDs de evolución/involución
    $digimon->idevolucion = $evolucion->idevolucion;
    $digimon->idinvolucion = $evolucion->idinvolucion;
    $digimon->idevolucion2 = $evolucion->idevolucion2;
    $digimon->idinvolucion2 = $evolucion->idinvolucion2;
    $digimon->idevolucion3 = $evolucion->idevolucion3;
    $digimon->idinvolucion3 = $evolucion->idinvolucion3;

    $digimon->id_lista_digimon = $evolucion->id;
    $digimon->num_evoluciones += 1;
    $digimon->save();
    // Guardar la nueva involución
                $digimon->save();
                // Obtener la lista de Digimones adquiridos
        $adquiridos = $usuario->digimones_adquiridos;

        // Convertir la lista de Digimones adquiridos en un array
        $adquiridosArray = explode(',', $adquiridos);

        // Verificar si el ID del nuevo Digimon ya está en la lista
        if (!in_array($digimon->id_lista_digimon, $adquiridosArray)) {
            // Si no está en la lista, añadirlo
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $digimon->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $digimon->id_lista_digimon;
            }
            $usuario->save();

    return redirect()->route('mostrarevo')->with('success', '¡Tu Digimon ha evolucionado!');
    }
}





public function involucionar(Request $request, $id)
{
        Log::info('Llamada al método involucionar con id: ' . $id);

    $usuario = Auth::user();
    $digimon = $usuario->digimon;

    if ($digimon) {
        // Verificar si el Digimon seleccionado está disponible para involucionar
$involucion = ListaDigimon::find($id);

        if ($involucion) {
            // Verificar si la involución está disponible para el Digimon actual
            if (
                $digimon->idinvolucion == $involucion->id ||
                $digimon->idinvolucion2 == $involucion->id ||
                $digimon->idinvolucion3 == $involucion->id
            ) {
                // Actualizar los datos del Digimon con la nueva involución
                $digimon->nombre = $involucion->nombre;
                $digimon->nivel = $involucion->nivel;
                $digimon->ataquebase = $involucion->ataquebase;
                $digimon->defensabase = $involucion->defensabase;
                $digimon->vidabase = $involucion->vidabase;
                $digimon->experienciabase = $involucion->experienciabase;
                $digimon->experienciasiguientenivel = $involucion->experienciasiguientenivel;
                $digimon->experienciaactual = 0; // Resetear experiencia
                $digimon->etapa = $involucion->etapa;
                $digimon->videogif = $involucion->video_gif;
                $digimon->elemento = $involucion->elemento;
                $digimon->idevolucion = $involucion->idevolucion;
                $digimon->idinvolucion = $involucion->idinvolucion;
                $digimon->idevolucion2 = $involucion->idevolucion2;
                $digimon->idinvolucion2 = $involucion->idinvolucion2;
                $digimon->idevolucion3 = $involucion->idevolucion3;
                $digimon->idinvolucion3 = $involucion->idinvolucion3;
                $digimon->id_lista_digimon = $involucion->id;

                $digimon->bonoinvolucion += 1;

                if ($involucion->etapa == 'Bebé') {
    $elemento = strtolower($involucion->elemento);
    $campoElemento1 = $elemento . '1';
    $digimon->$campoElemento1 = true;
}

                // Guardar la nueva involución
                $digimon->save();
                // Obtener la lista de Digimones adquiridos
        $adquiridos = $usuario->digimones_adquiridos;

        // Convertir la lista de Digimones adquiridos en un array
        $adquiridosArray = explode(',', $adquiridos);

        // Verificar si el ID del nuevo Digimon ya está en la lista
        if (!in_array($digimon->id_lista_digimon, $adquiridosArray)) {
            // Si no está en la lista, añadirlo
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $digimon->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $digimon->id_lista_digimon;
            }
            $usuario->save();
        }
        session()->flash('redireccionar', true);

                // Redirigir nuevamente a la página de evolución
                return redirect()->route('mostrarevo')->with('success', '¡Tu Digimon ha involucionado!');
            } else {
                return back()->withErrors(['message' => 'No puedes involucionar a este Digimon.']);
            }
        } else {
            return back()->withErrors(['message' => 'Involución no válida.']);
        }
    }

    return redirect()->route('mostrarevo')->with('error', 'No tienes un Digimon activo.');
}


}
