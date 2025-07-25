<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListaDigimon;
use App\Models\Digimon;
use Illuminate\Support\Facades\Auth;


class DigimonController extends Controller
{
    // Mostrar vista de elección de Digimon
    public function showEleccion()
    {
        $lopmon = ListaDigimon::where('nombre', 'Lopmon')->first();
        $coronamon = ListaDigimon::where('nombre', 'Coronamon')->first();

        return view('eleccion', compact('lopmon', 'coronamon'));
    }

    public function seleccionarDigimonPrimeravez($nombre)
    {
        $usuario = Auth::user();
    $digimonBase = ListaDigimon::where('nombre', $nombre)->first();

    if ($digimonBase) {
        // Mapeo de elemento => atributo correspondiente
        $elementoMap = [
            'night' => 'night1',
            'light' => 'light1',
            'machine' => 'machine1',
            'beast' => 'beast1',
            'bird' => 'bird1',
            'water' => 'water1',
            'dragon' => 'dragon1',
            'insect' => 'insect1',
        ];

        // Por defecto, todo en false
        $atributosElementos = [
            'night1' => false,
            'light1' => false,
            'machine1' => false,
            'beast1' => false,
            'bird1' => false,
            'water1' => false,
            'dragon1' => false,
            'insect1' => false,
        ];

        // Activar el atributo correcto según el elemento
        $elemento = $digimonBase->elemento ?? 'Desconocido';
        if (isset($elementoMap[$elemento])) {
            $atributosElementos[$elementoMap[$elemento]] = true;
        }

        $digimon = Digimon::create(array_merge([
            'id_usuario' => $usuario->id,
            'id_lista_digimon' => $digimonBase->id,
            'nombre' => $digimonBase->nombre,
            'nivel' => $digimonBase->nivel ?? 0,
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
            'elemento' => $elemento,
            'idevolucion2' => $digimonBase->idevolucion2,
            'idinvolucion2' => $digimonBase->idinvolucion2,
            'idevolucion3' => $digimonBase->idevolucion3,
            'idinvolucion3' => $digimonBase->idinvolucion3,

            'hambre' => 100,
            'salud' => 100,
            'caca' => 100,
            'higiene' => 100,
            'felicidad' => 100,

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

            'numllave1' => 1,
            'numllave2' => 0,
            'numllavenecesaria1' => 1,
            'numllavenecesaria2' => 1,

            'num_evoluciones' => 0,
        ], $atributosElementos)); // Aquí añadimos los atributos del elemento correctamente
        

        // Actualizar el usuario
        $usuario->digimon_id = $digimon->id;

        $adquiridos = $usuario->digimones_adquiridos;
        $adquiridosArray = explode(',', $adquiridos);

        if (!in_array($digimon->id_lista_digimon, $adquiridosArray)) {
            if (empty($adquiridos)) {
                $usuario->digimones_adquiridos = (string) $digimon->id_lista_digimon;
            } else {
                $usuario->digimones_adquiridos .= ',' . $digimon->id_lista_digimon;
            }
            $usuario->save();
        }

        return redirect()->route('home');
    }

    return back()->withErrors(['message' => 'Digimon no encontrado']);
    }

    // Guardar el Digimon elegido
    public function seleccionarDigimon($nombre)
    {
        $usuario = Auth::user();
        $digimonBase = ListaDigimon::where('nombre', $nombre)->first();

        if ($digimonBase) {
            $digimon =Digimon::create([
                'id_usuario' => $usuario->id,
                'id_lista_digimon' => $digimonBase->id,
                'nombre' => $digimonBase->nombre,
                'nivel' => $digimonBase->nivel ?? 0,
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
                'elemento' => $digimonBase->elemento ?? 'Desconocido',
                'idevolucion2' => $digimonBase->idevolucion2,
                'idinvolucion2' => $digimonBase->idinvolucion2,
                'idevolucion3' => $digimonBase->idevolucion3,
                'idinvolucion3' => $digimonBase->idinvolucion3,
            
                'hambre' => 100,
                'salud' => 100,
                'caca' => 100,
                'higiene' => 100,
                'felicidad' => 100,
            
                'numentrenamientos' => 0,
                'bono_involucion' => 0,
                'ataque_entrenamiento' => 0,
                'defensa_entrenamiento' => 0,
                'vida_max_entrenamiento' => 0,
            
                'night1' => false,
                'light1' => false,
                'machine1' => false,
                'beast1' => false,
                'bird1' => false,
                'water1' => false,
                'dragon1' => false,
                'insect1' => false,
            
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
            
// Asignar el ID del digimon al usuario
$usuario->digimon_id = $digimon->id;

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

return redirect()->route('home');
        }

        return back()->withErrors(['message' => 'Digimon no encontrado']);
    }

    public function reducirStats()
{
    $usuario = Auth::user();
    $digimon = $usuario->digimon;

    if ($digimon) {
        // Restar entre 1 y 3 a cada stat (sin bajar de 0)
        $digimon->hambre = max(0, $digimon->hambre - rand(1, 3));
        $digimon->salud = max(0, $digimon->salud - rand(1, 3));
        $digimon->caca = max(0, $digimon->caca - rand(1, 3));
        $digimon->higiene = max(0, $digimon->higiene - rand(1, 3));

        // Calcular felicidad (media)
        $digimon->felicidad = intval(($digimon->hambre + $digimon->salud + $digimon->caca + $digimon->higiene) / 4);

        // Actualizar los valores de vida, ataque y defensa
        $vidaActual = $digimon->vidaActual();
        $ataqueActual = $digimon->ataqueActual();
        $defensaActual = $digimon->defensaActual();

        $digimon->save();

        // Devolver los valores actualizados
        return response()->json([
            'hambre' => $digimon->hambre,
            'salud' => $digimon->salud,
            'caca' => $digimon->caca,
            'higiene' => $digimon->higiene,
            'felicidad' => $digimon->felicidad,
            'vidaActual' => $vidaActual,
            'ataqueActual' => $ataqueActual,
            'defensaActual' => $defensaActual
        ]);

        
    }

    return response()->json(['error' => 'No se encontró el Digimon'], 404);
}


    

    public function create()
{
    $digimones = ListaDigimon::all();
    return view('crear', compact('digimones'));
}


public function crearDigimonForm()
{
    $listaDigimon = ListaDigimon::all();
    return view('crearDigimon', compact('listaDigimon'));
}

public function crearDigimon(Request $request)
{
    return $this->seleccionarDigimon($request->nombre);
}

public function cambiarDigimonForm()
{
    $usuario = Auth::user(); // Asegúrate de que el usuario esté autenticado
    $digimons = Digimon::where('id_usuario', $usuario->id)
     ->where('ocupado', false)
     ->where('ocupado2', false) // Asegúrate de que el Digimon no esté ocupado
     ->get(); // Obtener los digimons asociados al usuario

    return view('cambiarDigimon', compact('digimons', 'usuario')); // Pasamos $usuario a la vista
}


public function cambiarDigimon(Request $request)
{
    $usuario = Auth::user();
    $nuevoDigimon = Digimon::find($request->digimon_id);

    if (!$nuevoDigimon || $nuevoDigimon->id_usuario !== $usuario->id) {
        return response()->json(['success' => false, 'message' => 'Digimon no válido']);
    }

    $usuario->digimon_id = $nuevoDigimon->id;
    $usuario->save();

    return response()->json([
        'success' => true,
        'digimon' => [
            'nombre' => $nuevoDigimon->nombre,
            'videogif' => $nuevoDigimon->videogif,
            'vida' => $nuevoDigimon->vidaActual(),
            'ataque' => $nuevoDigimon->ataqueActual(),
            'defensa' => $nuevoDigimon->defensaActual(),
            'experiencia' => $nuevoDigimon->experienciaPorcentaje()
        ]
    ]);
}

public function obtenerDetallesDigimon($digimonId)
{
    $digimon = Digimon::find($digimonId);

    if (!$digimon) {
        return response()->json(['message' => 'Digimon no encontrado'], 404);
    }

    return response()->json([
        ...$digimon->toArray(),
        'vida_calculada' => $digimon->vidaActual(),
        'ataque_calculado' => $digimon->ataqueActual(),
        'defensa_calculada' => $digimon->defensaActual(),
        'experiencia_porcentaje' => $digimon->experienciaPorcentaje(),
        'puede_entrenar' => $digimon->puedeEntrenar(),
        'potencial_maximo' => $digimon->haAlcanzadoPotencialMaximo(),
        'entrenamientos_maximos' => $digimon->entrenamientosMaximos(),
    ]);
}




public function verDigidex()
{
    $usuario = Auth::user();
    $digimonesAdquiridos = explode(',', $usuario->digimones_adquiridos);

    // Obtener todos los Digimones de la lista, ordenados por ID
    $digimones = ListaDigimon::orderBy('id')->get();

    return view('digidex', compact('digimones', 'digimonesAdquiridos'));
}
public function obtenerInfo($id)
{
    $digimon = ListaDigimon::findOrFail($id);

    // Obtener posibles evoluciones e involuciones
    $evoluciones = collect([$digimon->idevolucion, $digimon->idevolucion2, $digimon->idevolucion3])
        ->filter() // Elimina null
        ->map(fn($id) => ListaDigimon::find($id)?->nombre ?? 'Desconocido');

    $involuciones = collect([$digimon->idinvolucion, $digimon->idinvolucion2, $digimon->idinvolucion3])
        ->filter()
        ->map(fn($id) => ListaDigimon::find($id)?->nombre ?? 'Desconocido');

    return response()->json([
        'nombre' => $digimon->nombre,
        'nivel' => $digimon->nivel,
        'vidabase' => $digimon->vidabase,
        'ataquebase' => $digimon->ataquebase,
        'defensabase' => $digimon->defensabase,
        'elemento' => $digimon->elemento,
        'etapa' => $digimon->etapa,
        'descripcion' => $digimon->descripcion,
        'evoluciones' => $evoluciones->isEmpty() ? ['No puede evolucionar más'] : $evoluciones,
        'involuciones' => $involuciones->isEmpty() ? ['No puede involucionar más'] : $involuciones
    ]);
}




public function subirStat(Request $request)
{
    $usuario = Auth::user();
    $digimon = $usuario->digimon;

    // Si ya alcanzó el potencial máximo, no se entrena más
    if ($digimon->haAlcanzadoPotencialMaximo() || !$digimon->puedeEntrenar()) {
        return redirect()->route('entrenar.digimon')->with('error', 'Tu Digimon ha alcanzado su potencial máximo o ya no puede entrenar más por ahora.');
    }

    $atributo = $request->input('atributo');

    if ($digimon && in_array($atributo, ['vida', 'ataque', 'defensa', 'nivel'])) {
        switch ($atributo) {
            case 'vida':
                $digimon->vidamaxentrenamiento += 1;
                $digimon->numentrenamientos += 1;
                break;
            case 'ataque':
                $digimon->ataqueentrenamiento += 1;
                $digimon->numentrenamientos += 1;
                break;
            case 'defensa':
                $digimon->defensaentrenamiento += 1;
                $digimon->numentrenamientos += 1;
                break;
            case 'nivel':
                $digimon->nivel += 1;
                break;
        }

        $digimon->save();
    }

    return redirect()->route('entrenar.digimon');
}


public function eliminarDigimon($id)
{
    $digimon = \App\Models\Digimon::find($id);

    if (!$digimon) {
        return response()->json(['success' => false, 'message' => 'Digimon no encontrado'], 404);
    }

    // Evitar eliminar el Digimon principal del usuario actual
    if (auth()->user()->digimon_id === $digimon->id) {
        return response()->json(['success' => false, 'message' => 'No puedes eliminar tu Digimon principal'], 403);
    }

    // Verifica que el Digimon le pertenezca al usuario
    if ($digimon->id_usuario !== auth()->id()) {
        return response()->json(['success' => false, 'message' => 'Acción no autorizada'], 403);
    }

    $digimon->delete();

    return response()->json(['success' => true]);
}



}
