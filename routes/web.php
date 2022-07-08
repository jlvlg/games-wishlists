<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;

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
    return view('welcome');
});

require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/wishlists', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/wishlists/create', [WishlistController::class, 'create'])->name('wishlists.create');
    Route::get('/wishlists/edit/{id}', [WishlistController::class, 'edit'])->name('wishlists.edit');
    Route::post('/wishlists/store', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::post('/wishlists/update', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::get('/wishlists/delete/{id}', [WishlistController::class, 'delete'])->name('wishlists.delete');
    Route::get('/wishlists/add/{id}', [WishlistController::class, 'add'])->name('wishlists.add');
    Route::get('/wishlists/{id}', [WishlistController::class, 'show'])->name('wishlists.show');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::get('/games/bought/{id}', [GameController::class, 'bought'])->name('games.bought');
    Route::get('/games/edit/{id}', [GameController::class, 'edit'])->name('games.edit');
    Route::get('/games/delete/{id}', [GameController::class, 'delete'])->name('games.delete');
    Route::post('/games/store', [GameController::class, 'store'])->name('games.store');
    Route::post('/games/update', [GameController::class, 'update'])->name('games.update');
    Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');
});


