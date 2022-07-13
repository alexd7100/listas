<?php

use Illuminate\Support\Facades\Route;
use App\Models\Thesis;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ThesisController;
use App\Models\Articulo;

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

Route::post('/thesis/register', [ThesisController::class, 'store'])->name('thesis_register');
Route::get('/thesis/file/{id}', [ThesisController::class, 'urlfile'])->name('thesis_file');
Route::post('/thesis/update', [ThesisController::class, 'update'])->name('thesis_update');
Route::get('/thesis/delete/{id}', [ThesisController::class, 'destroy'])->name('thesis_delete');

Route::get('/articulos', function () {
    $articulos = Articulo::all();
    return view('articulos')->with('articulos',$articulos);
})->middleware('auth');

Route::post('/articulos/register', [ArticuloController::class, 'store'])->name('articulos_register');
Route::get('/articulos/file/{id}', [ArticuloController::class, 'urlfile'])->name('articulos_file');
Route::post('/articulos/update', [ArticuloController::class, 'update'])->name('articulos_update');
Route::get('/articulos/delete/{id}', [ArticuloController::class, 'destroy'])->name('articulos_delete');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('categorias', CategoriaController::class); 
    Route::resource('productos', ProductoController::class);      
});








