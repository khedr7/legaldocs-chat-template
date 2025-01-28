<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'prefix' => '/users',
    'controller' => UserController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/conversations',
    'controller' => ConversationController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

Route::group([
    'prefix' => '/messages',
    'controller' => MessageController::class,
    // 'middleware' => ''
], function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'find');
    Route::post('/', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
