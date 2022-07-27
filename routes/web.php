<?php

use Illuminate\Support\Facades\Route;
use App\Models\Thesis;
use App\Http\Controllers\ThesisController;
use App\Models\Articulos;
use App\Http\Controllers\ArticulosController;
use App\Models\Listas;
use App\Http\Controllers\ListasController;
use App\Models\Hojas;
use App\Http\Controllers\HojasController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TransitoController;


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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/thesis', function () {
    $theses = Thesis::all();
    return view('thesis')->with('theses',$theses);
})->middleware('auth');

Route::get('/articulos', function () {
    $articulos = Articulos::all();
    return view('articulos')->with('articulos',$articulos);
})->middleware('auth');

Route::get('/listas', function () {
    $listas = Listas::all();
    return view('listas')->with('listas',$listas);
})->middleware('auth');

Route::get('/hojas', function () {
    $hojas = Hojas::all();
    return view('hojas')->with('hojas',$hojas);
})->middleware('auth');

Route::post('/thesis/register', [ThesisController::class, 'store'])->name('thesis_register');
Route::get('/thesis/file/{id}', [ThesisController::class, 'urlfile'])->name('thesis_file');
Route::post('/thesis/update', [ThesisController::class, 'update'])->name('thesis_update');
Route::get('/thesis/delete/{id}', [ThesisController::class, 'destroy'])->name('thesis_delete');

Route::post('/articulos/register', [ArticulosController::class, 'store'])->name('articulos_register');
Route::get('/articulos/file/{id}', [ArticulosController::class, 'urlfile'])->name('articulos_file');
Route::post('/articulos/update', [ArticulosController::class, 'update'])->name('articulos_update');
Route::get('/articulos/delete/{id}', [ArticulosController::class, 'destroy'])->name('articulos_delete');

Route::post('/listas/register', [ListasController::class, 'store'])->name('listas_register');
Route::get('/listas/file/{id}', [ListasController::class, 'urlfile'])->name('listas_file');
Route::post('/listas/update', [ListasController::class, 'update'])->name('listas_update');
Route::get('/listas/delete/{id}', [ListasController::class, 'destroy'])->name('listas_delete');

Route::post('/hojas/register', [HojasController::class, 'store'])->name('hojas_register');
Route::get('/hojas/file/{id}', [HojasController::class, 'urlfile'])->name('hojas_file');
Route::post('/hojas/update', [HojasController::class, 'update'])->name('hojas_update');
Route::get('/hojas/delete/{id}', [HojasController::class, 'destroy'])->name('hojas_delete');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('categorias', CategoriaController::class); 
    Route::resource('productos', ProductoController::class);
    Route::resource('transitos', TransitoController::class);     
});







