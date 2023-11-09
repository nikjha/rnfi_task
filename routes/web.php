<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SlotController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserController::class, 'index']);
Route::get('/index', [UserController::class, 'index']);
Route::get('/add', [UserController::class, 'showForm']);
Route::post('/add', [UserController::class, 'addData']);
Route::get('/edit/{id}', [UserController::class, 'editForm']);
Route::post('/update/{id}', [UserController::class, 'updateData']);
Route::get('/delete/{id}', [UserController::class, 'deleteData']);
Route::get('/final-submit', [UserController::class, 'finalSubmit']);
Route::get('/slots', [SlotController::class, 'index']);
Route::post('/slots/add', [SlotController::class, 'add']);
Route::post('/slots/update/{id}', [SlotController::class, 'update']);


