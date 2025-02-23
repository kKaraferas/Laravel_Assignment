<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoGameController;
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

Route::post('/register', [UserController::class, 'registerUser']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logOut']);
});

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/video-games', [VideoGameController::class, 'index']);
    Route::get('/video-games/{id}', [VideoGameController::class, 'show']);
    Route::post('/video-games', [VideoGameController::class, 'gameCreation']);
    Route::put('/video-games/{id}', [VideoGameController::class,'gameUpdate']);
    Route::delete('/video-games/{id}', [VideoGameController::class, 'gameDeletion']);
});