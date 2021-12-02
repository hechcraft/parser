<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/telegram_auth', [\App\Http\Controllers\AuthController::class, 'telegramAuth']);
Route::get('/user/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('user.logout');

Route::any('/webhook', function () {
    Telegram::commandsHandler(true);
    return 'ok';
});

Route::prefix('task')->group(function () {
    Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('task.index');
    Route::get('/create', [\App\Http\Controllers\PageController::class, 'create'])->name('task.create');
    Route::get('/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('task.show');
    Route::post('/', [\App\Http\Controllers\PageController::class, 'store'])->name('task.store');
    Route::delete('/{page}', [\App\Http\Controllers\PageController::class, 'destroy'])->name('task.delete');
});

