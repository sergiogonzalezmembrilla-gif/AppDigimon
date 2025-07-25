<?php

namespace App\Http\Controllers;

use App\Models\Digimon;
use App\Models\Intercambio;
use App\Models\ListaDigimon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Usuario;


class IntercambioController extends Controller
{
  public function index()
{
    $digimonDepositado = Digimon::where('id_usuario', Auth::id())
                                ->where('ocupado', true)
                                ->first();

    $intercambioPendiente = null;
    $digimonBuscado = null;

    $intercambioRealizado = null;
    $digimonRecibido = null;

    if ($digimonDepositado) {
        // Intercambio pendiente
        $intercambioPendiente = Intercambio::where('id_usuario', Auth::id())
                                           ->where('realizado', false)
                                           ->where('id_digimon_ofrecido', $digimonDepositado->id)
                                           ->first();

        if ($intercambioPendiente && $intercambioPendiente->digimonBuscado) {
            $digimonBuscado = $intercambioPendiente->digimonBuscado;
        }

        // Intercambio ya realizado
        $intercambioRealizado = Intercambio::where('id_usuario', Auth::id())
                                           ->where('realizado', true)
                                           ->where('id_digimon_recibido', $digimonDepositado->id)
                                           ->first();

        if ($intercambioRealizado && $intercambioRealizado->digimonRecibido) {
            $digimonRecibido = $intercambioRealizado->digimonRecibido;
        }
    }

    return view('intercambio.index', compact('digimonDepositado', 'digimonBuscado', 'intercambioRealizado', 'digimonRecibido','intercambioPendiente'));
}




    public function mostrarDeposito()
    {    $usuario = Auth::user(); // Obtener usuario autenticado

            $digimonActualId = $usuario->digimon_id; // Obtener el digimon actual

        $digimons = Digimon::where('id_usuario', Auth::id())
                                            ->where('ocupado', false)    
                                            ->where('ocupado2', false)   
                                            ->when($digimonActualId, function ($query, $digimonActualId) {
            return $query->where('id', '!=', $digimonActualId);
        })   
                                            ->get();
        return view('intercambio.depositar', compact('digimons'));
    }

    public function seleccionarIntercambio($digimonId)
    {
        $digimon = Digimon::findOrFail($digimonId);
        $listaDigimon = ListaDigimon::all();

        return view('intercambio.seleccionar', compact('digimon', 'listaDigimon'));
    }

    public function realizarIntercambio(Request $request, $digimonId)
{
    $usuario = Auth::user();
    $request->validate([
        'lista_digimon_id' => 'required|exists:lista_digimon,id',
    ]);

    $digimon = Digimon::findOrFail($digimonId);
    $digimon->ocupado = true;
    $digimon->save();

    Intercambio::create([
        'id_usuario' => $usuario->id,
        'id_digimon_ofrecido' => $digimon->id,
        'id_digimon_buscado' => $request->lista_digimon_id,
        'realizado' => false,
    ]);

    return redirect()->route('intercambio.index')->with('success', 'Intercambio creado exitosamente.');
}
public function cancelarDeposito()
{
    $intercambio = Intercambio::where('id_usuario', Auth::id())
                              ->where('realizado', false)
                              ->first();

    if (!$intercambio) {
        return redirect()->route('intercambio.index')->with('error', 'No se puede cancelar el depósito. El intercambio ya fue realizado o no existe.');
    }

    // Liberar el Digimon
    $digimon = Digimon::find($intercambio->id_digimon_ofrecido);
    if ($digimon) {
        $digimon->ocupado = false;
        $digimon->save();
    }

    // Eliminar el intercambio
    $intercambio->delete();

    return redirect()->route('intercambio.index')->with('success', 'Depósito cancelado con éxito.');
}
// Formulario de búsqueda
public function buscarFormulario()
{
    $listaDigimons = ListaDigimon::all();
    return view('intercambio.buscar', compact('listaDigimons'));
}

// Procesar búsqueda
public function buscar(Request $request)
{
    $nombre = strtolower(trim($request->nombre));
    $usuarioId = Auth::id();

    $query = Intercambio::where('realizado', false)
        ->where('id_usuario', '!=', $usuarioId)
        ->with(['digimonOfrecido', 'digimonBuscado']);

    if (!empty($nombre)) {
        $query->whereHas('digimonOfrecido', function ($q) use ($nombre) {
            $q->whereRaw('LOWER(nombre) LIKE ?', ['%' . $nombre . '%']);
        });
    }

    $resultados = $query->get();

    return view('intercambio.buscar', compact('resultados'));
}




// Elegir tu propio Digimon para intercambiar
public function elegirPropioDigimon($intercambioId)
{
    $intercambio = Intercambio::with('digimonBuscado')->findOrFail($intercambioId);
    $usuarioId = Auth::id();

    $digimons = Digimon::where('id_usuario', $usuarioId)
        ->where('ocupado', false)
        ->where('ocupado2', false)
        ->where('id_lista_digimon', $intercambio->id_digimon_buscado)
        ->get();

    if ($digimons->isEmpty()) {
        return redirect()->route('intercambio.buscar')->with('error', 'No tienes ningún Digimon compatible para este intercambio.');
    }

    return view('intercambio.seleccionar_digimon_usuario', compact('digimons', 'intercambio'));
}



// Finalizar intercambio
public function finalizarIntercambio(Request $request, $intercambioId)
{
    $request->validate([
        'mi_digimon_id' => 'required|exists:digimon,id'
    ]);

    $intercambio = Intercambio::findOrFail($intercambioId);

    $miDigimon = Digimon::where('id', $request->mi_digimon_id)
                        ->where('id_usuario', Auth::id())
                        ->firstOrFail();

    $otroDigimon = Digimon::findOrFail($intercambio->id_digimon_ofrecido);

    if ($intercambio->realizado) {
        return redirect()->route('intercambio.index')->with('error', 'Este intercambio ya ha sido realizado.');
    }

    // Intercambiar usuarios
    $tempUsuario = $miDigimon->id_usuario;
    $miDigimon->id_usuario = $otroDigimon->id_usuario;
    $otroDigimon->id_usuario = $tempUsuario;

    // Marcar ambos como ocupados
    $miDigimon->ocupado = true;
    $otroDigimon->ocupado = false;

    // Guardar cambios
    $miDigimon->save();
    $otroDigimon->save();

    // Actualizar el intercambio
    $intercambio->realizado = true;
    $intercambio->id_digimon_recibido = $miDigimon->id;
    $intercambio->save();

         $usuario = Auth::user();

      // Obtener la lista de Digimones adquiridos
        $adquiridos = $usuario->digimones_adquiridos;

        // Convertir la lista de Digimones adquiridos en un array
        $adquiridosArray = explode(',', $adquiridos);

        // Verificar si el ID del nuevo Digimon ya está en la lista
        if (!in_array($otroDigimon->id_lista_digimon, $adquiridosArray)) {
            // Si no está en la lista, añadirlo
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $otroDigimon->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $otroDigimon->id_lista_digimon;
            }
            $usuario->save();
        }

    return redirect()->route('intercambio.index')->with('success', '¡Intercambio realizado con éxito!');
}
public function recibirDigimon(Request $request)
{
    $intercambio = Intercambio::where('id_usuario', Auth::id())
                              ->where('realizado', true)
                              ->first();

    if (!$intercambio) {
        return redirect()->route('intercambio.index')->with('error', 'No hay un intercambio para recibir.');
    }

    // Marcar el Digimon recibido como no ocupado
    $digimonRecibido = Digimon::find($intercambio->id_digimon_recibido);
    if ($digimonRecibido) {
        $digimonRecibido->ocupado = false;
        $digimonRecibido->save();
    }

            $usuario = Auth::user();

      // Obtener la lista de Digimones adquiridos
        $adquiridos = $usuario->digimones_adquiridos;

        // Convertir la lista de Digimones adquiridos en un array
        $adquiridosArray = explode(',', $adquiridos);

        // Verificar si el ID del nuevo Digimon ya está en la lista
        if (!in_array($digimonRecibido->id_lista_digimon, $adquiridosArray)) {
            // Si no está en la lista, añadirlo
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $digimonRecibido->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $digimonRecibido->id_lista_digimon;
            }
            $usuario->save();
        }

    // Eliminar el intercambio
    $intercambio->delete();

    return redirect()->route('intercambio.index')->with('success', 'Has recibido tu Digimon con éxito.');
}




}
