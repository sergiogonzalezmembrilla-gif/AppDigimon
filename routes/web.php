<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DigimonController;
use App\Http\Controllers\CombateController;
use App\Http\Controllers\CombateDefensorOnlineController;
use App\Http\Controllers\EvoDigimonController;
use App\Http\Controllers\IntercambioController;
use App\Http\Controllers\CuidadoDigimonController;
use App\Http\Controllers\CombateOnlineController;
/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('image_redirect'));

Route::get('/log', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas autenticadas
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Inicio / Elección / Home
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/eleccion', [DigimonController::class, 'showEleccion'])->name('eleccion');
    Route::post('/eleccion/{nombre}', [DigimonController::class, 'seleccionarDigimonPrimeravez'])->name('seleccionar.digimon');

    // Crear / Cambiar Digimon
    Route::get('/crear-digimon', [DigimonController::class, 'crearDigimonForm'])->name('crear.digimon.form');
    Route::post('/crear-digimon', [DigimonController::class, 'crearDigimon'])->name('crear.digimon');
    Route::get('/cambiar-digimon', [DigimonController::class, 'cambiarDigimonForm'])->name('cambiar.digimon.form');
    Route::post('/cambiar-digimon', [DigimonController::class, 'cambiarDigimon'])->name('cambiar.digimon');

Route::delete('/eliminar-digimon/{id}', [DigimonController::class, 'eliminarDigimon'])->name('eliminar.digimon');

    // Entrenamiento
    Route::get('/entrenar', function () {
        $usuario = Auth::user();
        $digimon = $usuario->digimon;
        return view('entrenar', compact('digimon'));
    })->name('entrenar.digimon');
    Route::post('/entrenar/subir', [DigimonController::class, 'subirStat'])->name('entrenar.subir');

    // Digidex
    Route::get('/digidex', [DigimonController::class, 'verDigidex'])->name('digidex');

    // Combate
    Route::get('/ruta-seleccion', [CombateController::class, 'seleccionarRuta'])->name('ruta.seleccion');
    Route::post('/combate/iniciar', [CombateController::class, 'iniciarCombate'])->name('combate.iniciar');
    Route::post('/combate/accion', [CombateController::class, 'ejecutarAccion'])->name('accion.combate');
    Route::get('/combate/mostrar', [CombateController::class, 'mostrarCombate'])->name('combate.mostrar');

    // Evolución
    Route::get('/evo', [EvoDigimonController::class, 'mostrarevo'])->name('mostrarevo');
    Route::post('/evolucionar/{id}', [EvoDigimonController::class, 'evolucionar'])->name('evolucionar');
    Route::post('/involucionar/{id}', [EvoDigimonController::class, 'involucionar'])->name('involucionar');

    // Intercambio
    Route::prefix('intercambio')->name('intercambio.')->group(function () {
        Route::get('/', [IntercambioController::class, 'index'])->name('index');
        Route::get('/depositar', [IntercambioController::class, 'mostrarDeposito'])->name('depositar');
        Route::get('/seleccionar/{digimonId}', [IntercambioController::class, 'seleccionarIntercambio'])->name('seleccionar');
        Route::post('/realizar/{digimonId}', [IntercambioController::class, 'realizarIntercambio'])->name('realizar');
        Route::post('/cancelar', [IntercambioController::class, 'cancelarDeposito'])->name('cancelar');
        Route::get('/buscar', [IntercambioController::class, 'buscar'])->name('buscar');
        Route::get('/intercambiar/{intercambioId}', [IntercambioController::class, 'elegirPropioDigimon'])->name('elegir.propio');
        Route::post('/intercambiar/{intercambioId}', [IntercambioController::class, 'finalizarIntercambio'])->name('finalizar');
        Route::get('/elegir-digimon/{intercambioId}', [IntercambioController::class, 'elegirPropioDigimon'])->name('elegir_propio_digimon');
    });

    Route::post('/intercambio/recibir', [IntercambioController::class, 'recibirDigimon'])->name('intercambio.recibir');

    // Cuidado Digimon (nuevo controlador)
    Route::get('/cuidar', [CuidadoDigimonController::class, 'cuidar'])->name('cuidar.digimon');
    Route::get('/reducir-stats', [CuidadoDigimonController::class, 'reducirStats'])->name('reducir.stats');
Route::post('/incrementar-hambre/{id}/{porcentaje}', [CuidadoDigimonController::class, 'incrementarHambre'])->name('incrementar.hambre');
Route::post('/incrementar-caca/{id}/{porcentaje}', [CuidadoDigimonController::class, 'incrementarCaca'])->name('incrementar.caca');
Route::post('/incrementar-salud/{id}/{porcentaje}', [CuidadoDigimonController::class, 'incrementarSalud'])->name('incrementar.salud');
Route::post('/incrementar-higiene/{id}/{porcentaje}', [CuidadoDigimonController::class, 'incrementarHigiene'])->name('incrementar.higiene');


Route::prefix('combate')->middleware('auth')->group(function () {
    Route::get('/', [CombateOnlineController::class, 'index'])->name('combate_online.index');
    Route::get('/depositar', [CombateOnlineController::class, 'mostrarDeposito'])->name('combate_online.depositar.form');
    Route::get('/depositar/{id}', [CombateOnlineController::class, 'depositar'])->name('combate_online.depositar');
    Route::post('/retirar', [CombateOnlineController::class, 'retirar'])->name('combate_online.retirar');
Route::get('/buscar', [CombateOnlineController::class, 'buscarCombatientes'])->name('combate_online.buscar');
Route::get('/combate-online/{idCombate}', [CombateDefensorOnlineController::class, 'iniciarCombateContraDefensor'])->name('combate.defensor');
Route::get('/combate_online', [CombateDefensorOnlineController::class, 'mostrarCombate'])->name('combate.mostrar2');

    Route::post('/combate_online/accion2', [CombateDefensorOnlineController::class, 'ejecutarAccion'])->name('accion.combate2');


});
Route::get('/digimon/{id}/detalles', [DigimonController::class, 'obtenerDetallesDigimon'])->name('digimon.detalles');
Route::get('/digimon/{digimonId}/detalles', [DigimonController::class, 'obtenerDetallesDigimon']);


Route::post('/guardar-salida', [AuthController::class, 'guardarSalida'])->name('guardar.salida');
Route::get('/digimon/{id}/info', [DigimonController::class, 'obtenerInfo'])->name('digimon.info');

});

