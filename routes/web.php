<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;

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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'home']);


Route::view('/template', 'template');

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::get('/login', 'login')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/login', 'doLogin')->middleware([\App\Http\Middleware\OnlyGuestMiddleware::class]);
    Route::post('/logout', 'doLogout')->middleware([\App\Http\Middleware\OnlyMemberMiddleware::class]);
});

Route::middleware('auth')->group(function () {
    Route::get('/todolist', [App\Http\Controllers\TodolistController::class, 'todoList'])->name('todolist');
    Route::post('/todolist', [App\Http\Controllers\TodolistController::class, 'addTodo']);
    Route::delete('/todolist/{id}', [TodolistController::class, 'removeTodo'])->name('removeTodo');

});