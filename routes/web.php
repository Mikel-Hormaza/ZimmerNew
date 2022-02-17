<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('cors')->group(function() {
    // HOME
    Route::get('/', function () { return view('welcome'); });
    // HOTELES
    Route::get('/hoteles', [HotelController::class, 'index'])->middleware('auth');;
    Route::get('/hoteles/{id}', [HotelController::class, 'show'])->middleware('auth');
    Route::post('/hoteles/{id}', [ComentarioController::class, 'create'])->middleware('auth');
    // ADMIN
    Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
});

// PERFIL
Route::get('/profile', [PerfilController::class, 'index'])->middleware('auth');
Route::put('/profile/{id}', [PerfilController::class, 'update'])->middleware('auth');

Route::delete('/erabiltzailea/{id}', [AdminController::class, 'delete_user'])->middleware('auth');

// COMENTARIOS
Route::post('/komentarioa/{id}', [ComentarioController::class, 'handle'])->middleware('auth');

// FAVORITOS
Route::get('/gogokoa', [FavoritoController::class, 'index'])->middleware('auth');
Route::post('/gogokoa', [FavoritoController::class, 'create'])->middleware('auth');
Route::delete('/gogokoa', [FavoritoController::class, 'delete'])->middleware('auth');