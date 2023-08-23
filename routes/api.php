<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {

    Route::get('/employees',[EmployeeController::class, 'index']);
    Route::post('/employee/create',[EmployeeController::class, 'store']);
    Route::get('/employee/{id}',[EmployeeController::class, 'show']);
    Route::put('/employee/{id}',[EmployeeController::class, 'update']);
    Route::delete('/employee/{id}',[EmployeeController::class, 'destroy']);

});