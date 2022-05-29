<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use  App\Http\Controllers\ChatController;

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

// Route::get('/', function () {
//     return Inertia::render('Home', ['test' => 'working']);
// });

// Route::get('/about-us', function () {
//     return Inertia::render('About', ['about_us' => 'working']);
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/messages', [ChatController::class, 'fetchAllMessages']);
Route::post('/messages', [ChatController::class, 'sendMessage']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/room/{room}',  [ChatController::class, 'renderChat'])->name('chat');
    Route::post('/message/room/{room}', [ChatController::class, 'sendMessage'])->name('message');
});
