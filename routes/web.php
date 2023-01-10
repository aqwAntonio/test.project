<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/home', [IndexController::class, 'welcome'])->name('home');
});

Route::group(['middleware' => 'permission:task-list|task-create|task-edit|task-delete'], function() {

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::post('/tasks/done', [TaskController::class, 'done'])->name('tasks.done');

});
