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

Route::any('/webhook', function () {

    Telegram::commandsHandler(true);
    return 'ok';
});

Route::get('/test', function () {
    \App\Jobs\SendOffers::dispatch();
});

Route::post('/page', [\App\Http\Controllers\PageController::class, 'store'])->name('page.store');
Route::get('/page', [\App\Http\Controllers\PageController::class, 'create'])->name('page.create');
