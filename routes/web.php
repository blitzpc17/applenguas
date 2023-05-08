<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Cms\LoginController;
use App\Http\Controllers\Frontend\FrontendController;

use App\Http\Controllers\Frontend\CategoriasController;
use App\Http\Controllers\Frontend\FrasesController as FCFrases;
use App\Http\Controllers\Frontend\BlogController as FCBlog;
use App\Http\Controllers\Cms\HomeController;
use App\Http\Controllers\Cms\CategoriasController as CatCms;
use App\Http\Controllers\Cms\FrasesController;
use App\Http\Controllers\Cms\BlogController;

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

Route::get('login', function () {
    return view('cms.login');
})->name('login')->middleware('guest');;


Route::post('auth', [LoginController::class, 'authenticate'])->name('us.auth');
Route::get('logauth', [LoginController::class, 'logout'])->name('us.logout');


Route::prefix('admin')->group(function(){

    Route::get('/', [HomeController::class, 'home'])->name('home');

    /*usuarios*/
    Route::get('us', [HomeController::class, 'usuarios'])->name('us');
    Route::get('us/listar', [HomeController::class, 'listar'])->name('us.listar');
    Route::get('us/obtener', [HomeController::class, 'obtener'])->name('us.data');
    Route::post('us/save', [HomeController::class, 'save'])->name('us.save');

    /* categorias */
    Route::get('cat', [CatCms::class, 'categorias'])->name('cat');
    Route::get('cat/listar', [CatCms::class, 'listar'])->name('cat.listar');
    Route::get('cat/obtener', [CatCms::class, 'obtener'])->name('cat.data');
    Route::post('cat/save', [CatCms::class, 'save'])->name('cat.save');

    /** items */
    Route::get('cat/items', [CatCms::class, 'items'])->name('cat.items');
    Route::get('cat/items/listar', [CatCms::class, 'listaritemscategorias'])->name('cat.items.listar');
    Route::get('cat/item/obtener', [CatCms::class, 'obteneritem'])->name('cat.item.data');
    Route::post('cat/item/save', [CatCms::class, 'saveitem'])->name('cat.item.save');

    /* frases */
    Route::get('frases', [FrasesController::class, 'index'])->name('frases');
    Route::get('frases/listar', [FrasesController::class, 'listar'])->name('frases.listar');
    Route::get('frases/obtener', [FrasesController::class, 'obtener'])->name('frases.data');
    Route::post('frases/save', [FrasesController::class, 'save'])->name('frases.save');

    /* blog */
    Route::get('blog', [BlogController::class, 'index'])->name('blog');
    Route::get('blog/listar', [BlogController::class, 'listar'])->name('blog.listar');
    Route::get('blog/obtener', [BlogController::class, 'obtener'])->name('blog.data');
    Route::post('blog/save', [BlogController::class, 'save'])->name('blog.save');

    
})->middleware('auth');





/*frontend */

Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('categorias', [CategoriasController::class, 'index'])->name('categorias.index');
Route::get('categorias/items', [CategoriasController::class, 'mostraritemcategoria'])->name('categorias.item');
Route::get('fras', [FCFrases::class, 'index'])->name('front.fras');
Route::get('bg', [FCBlog::class, 'index'])->name('front.bg');
