<?php

use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\DepartmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('/user')->group(function() {
//     Route::get('/', [UserController::class, 'index']);
//     Route::get('/profile/{id}', [UserController::class, 'show']);
// });

// Route::post('test', function(Request $request) {
//     return $request->all();
// });

Route::prefix('/v1')->group(function() {
    Route::apiResource('user', UserController::class);
    Route::apiResource('department', DepartmentController::class);
});
