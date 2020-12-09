<?php

use Illuminate\Http\Request;

use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/classes/list', [ClassController::class, 'list']);
Route::get('/classes/view/{id}', [ClassController::class, 'view']);
Route::post('/classes/add', [ClassController::class, 'add']);
Route::post('/classes/edit/{id}', [ClassController::class, 'edit']);


Route::get('/students/list', [StudentController::class, 'list']);
Route::get('/students/view/{id}', [StudentController::class, 'view']);
Route::post('/students/add', [StudentController::class, 'add']);
Route::post('/students/edit/{id}', [StudentController::class, 'edit']);
