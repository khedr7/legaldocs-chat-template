<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
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

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'login_view'])->name('login_view');
Route::get('/register', [UserController::class, 'register_view'])->name('register_view');


Route::get('/', [ConversationController::class, 'index'])->middleware('auth')->name('chat.index');
Route::get('/{conversation_id}', [ConversationController::class, 'show'])->middleware('auth')->name('chat.details');
Route::post('/send-message', [MessageController::class, 'sendMessage'])->middleware('auth')->name('chat.send');



