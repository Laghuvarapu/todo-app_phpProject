<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

/*Route::get('/task', [TaskController::class, 'getAllTasks']);
Route::get('/task/{id}', [TaskController::class, 'getTaskById']);
Route::post('/task', [TaskController::class, 'createTask']);
Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);*/


Route::post('tasks' , [TaskController::class , 'createTask']);
Route::get('tasks/{id}', [TaskController::class, 'getTaskById']);
Route::get('tasks', [TaskController::class, 'getAllTasks']);
Route::patch('tasks/{id}', [TaskController::class, 'updateStatus']);
Route::delete('tasks/{id}', [TaskController::class, 'deleteTaskById']);
Route::delete('tasks', [TaskController::class, 'deleteTasksDone']);
