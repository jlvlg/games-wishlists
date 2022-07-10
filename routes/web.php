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
})->name('welcome');

require __DIR__.'/auth.php';
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [WishlistController::class, 'index'])->name('wishlists.index');
    Route::get('/wishlists', [WishlistController::class, 'show'])->name('wishlists.show');
    Route::get('/wishlists/create', [WishlistController::class, 'create'])->name('wishlists.create');
    Route::get('/wishlists/edit', [WishlistController::class, 'edit'])->name('wishlists.edit');
    Route::post('/wishlists/create', [WishlistController::class, 'store'])->name('wishlists.store');
    Route::post('/wishlists/edit', [WishlistController::class, 'update'])->name('wishlists.update');
    Route::get('/wishlists/delete', [WishlistController::class, 'delete'])->name('wishlists.delete');
    Route::get('/games', [GameController::class, 'show'])->name('games.show');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::get('/games/bought', [GameController::class, 'bought'])->name('games.bought');
    Route::get('/games/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::get('/games/delete', [GameController::class, 'delete'])->name('games.delete');
    Route::post('/games/create', [GameController::class, 'store'])->name('games.store');
    Route::post('/games/edit', [GameController::class, 'update'])->name('games.update');
});


