<?php

use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(UserController::class)->group(function () {
    Route::get('/iniciarSesion', 'index')->name('users.index');
    Route::get('/Registrarse', 'register')->name('users.registro');
});

Route::controller(VideoController::class)->group(function () {
    Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
        Route::get('videos/{usuario}', 'show')->name('video.misvideos');
        Route::get('videos/subirVideo/{usuario}', 'subir')->name('video.subir');
    });
    Route::get('/', 'index')->name('video.inicio');
    // Route::get('videos/{usuario}', 'show')->name('video.misvideos');
    // Route::get('videos/subirVideo/{usuario}', 'subir')->name('video.subir');
    Route::post('videos/store', 'store')->name('video.store');
    Route::get('videos/ver/{idVideo}', 'ver')->name('video.ver');
    Route::post('videos/eliminar', 'destroy')->name('videos.eliminar');
    Route::get('videos/editar/{idVideo}', 'editar')->name('video.editar');
    Route::post('videos/update/{video}', 'update')->name('video.update');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('video.inicio');
    })->name('dashboard');
});
Route::get('videos/welcome}', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('video.inicio'); // Cambia '/' por la ruta a la que deseas redireccionar después del logout
})->name('cerrarSesion');
