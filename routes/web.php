<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Models\Conversation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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


Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cache cleared successfully!";
});

Route::get('/test/env', function () {
    dd(config('database.connections.mysql'));
});

Route::get('/set-app-url/{new_url}', function ($new_url) {
    // URL decode the parameter since it's passed as an encoded string
    $decoded_url = urldecode($new_url);

    // Set the new APP_URL dynamically for this request
    Config::set('app.url', $decoded_url);

    return response()->json([
        'message' => 'APP_URL has been updated',
        'new_app_url' => Config::get('app.url'),
    ]);
});

Route::get('/test/db', function () {
    return DB::connection()->getPdo() ? "Connected Successfully!" : "Connection Failed";
});


Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'login_view'])->name('login_view');
Route::get('/register', [UserController::class, 'register_view'])->name('register_view');


Route::get('/', [ConversationController::class, 'index'])->middleware('auth')->name('chat.index');
Route::get('/{conversation_id}', [ConversationController::class, 'show'])->middleware('auth')->name('chat.details');
Route::post('/send-message', [MessageController::class, 'sendMessage'])->middleware('auth')->name('chat.send');
