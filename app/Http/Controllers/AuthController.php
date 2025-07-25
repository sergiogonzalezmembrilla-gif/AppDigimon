<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\ListaDigimon;
use App\Models\Digimon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    // Muestra la pantalla de inicio de sesión
   

public function showLogin() {
    // Verificar si el usuario ya está autenticado
    if (Auth::check()) {
        // Si ya está autenticado, redirigir al home
        return redirect()->route('home');
    }

    return view('login');
}


    // Procesa el inicio de sesión
 

public function login(Request $request)
{
    $request->validate([
        'correousuario' => 'required|email',
        'contraseñausuario' => 'required',
    ]);

    $usuario = Usuario::where('correousuario', $request->correousuario)->first();

  if ($usuario && Hash::check($request->contraseñausuario, $usuario->contraseñausuario)) {
    if ($usuario->ultima_salida && $usuario->digimon_id) {
    $digimonId = $usuario->digimon_id;
    $minutosPasados = Carbon::parse($usuario->ultima_salida)->diffInMinutes(Carbon::now());

    $bloquesReducidos = intdiv($minutosPasados, 2);

    // Inicializar las reducciones
    $hambre = 0;
    $salud = 0;
    $caca = 0;
    $higiene = 0;

    for ($i = 0; $i < $bloquesReducidos; $i++) {
        $hambre += rand(1, 3);
        $salud += rand(1, 3);
        $caca += rand(1, 3);
        $higiene += rand(1, 3);
    }

    // Obtener valores actuales
    $digimon = Digimon::find($digimonId);
    $nuevoHambre = max(0, $digimon->hambre - $hambre);
    $nuevaSalud = max(0, $digimon->salud - $salud);
    $nuevaCaca = max(0, $digimon->caca - $caca);
    $nuevaHigiene = max(0, $digimon->higiene - $higiene);

    // Calcular nueva felicidad basada en los nuevos valores
    $nuevaFelicidad = min(100, round(($nuevoHambre + $nuevaSalud + $nuevaCaca + $nuevaHigiene) / 4.0));

    // Guardar los cambios
    DB::update("
        UPDATE digimon SET
            hambre = ?,
            salud = ?,
            caca = ?,
            higiene = ?,
            felicidad = ?
        WHERE id = ?
    ", [$nuevoHambre, $nuevaSalud, $nuevaCaca, $nuevaHigiene, $nuevaFelicidad, $digimonId]);
}


    Auth::login($usuario);
    return redirect()->route('home');
}


    return back()->withErrors(['message' => 'Credenciales incorrectas']);
}


    // Muestra la pantalla de creación de usuario
    public function showRegister() {
        return view('register');
    }

    // Procesa la creación de un nuevo usuario
    public function register(Request $request) {
        $request->validate([
            'nombreusuario' => 'required',
            'correousuario' => 'required|email|unique:usuarios,correousuario',
            'contraseñausuario' => 'required|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombreusuario' => $request->nombreusuario,
            'correousuario' => $request->correousuario,
            'contraseñausuario' => Hash::make($request->contraseñausuario),
            'dinero' => 1000, // Dinero inicial
        ]);

        Auth::login($usuario);
return redirect()->route('eleccion');

    }

    public function logout(Request $request)
{
    // Guardar hora de salida
    $usuario = Auth::user();
    $usuario->ultima_salida = Carbon::now();
    $usuario->save();

    Auth::logout();
    return redirect()->route('login');
}
    
    public function home() {
        $usuario = Auth::user();
        
        // Verifica si el usuario tiene un Digimon asignado
        if (!$usuario->digimon_id) {
            // Si no tiene un Digimon asignado, redirigirlo a la página de elección
            return redirect()->route('eleccion');
        }
        
        // Si tiene un Digimon asignado, mostrar la página de inicio
        $digimon = $usuario->digimon;
        return view('home', compact('digimon'));
    }
    
public function guardarSalida(Request $request)
{
    if (Auth::check()) {
        $usuario = Auth::user();
        $usuario->ultima_salida = now();
        $usuario->save();
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false], 401);
}

   
}
