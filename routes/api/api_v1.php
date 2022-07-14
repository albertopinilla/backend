<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController,UserController};


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth/login', [AuthController::class, 'login']);



//Route::group(['middleware' => 'jwt.auth'], function () {
Route::middleware([ 'auth.api','jwt.auth'])->group(function () {    

    Route::post('/auth/logout', [AuthController::class,'logout']);
   
    // Users
    Route::get('/users', [UserController::class, 'users']); 
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::post('/users', [UserController::class, 'store']); 
    Route::put('/users/{id}',[UserController::class,'update']);
    Route::delete('/users/{id}',[UserController::class,'delete']);

});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Recurso no encontrado',
    ], 404);
});
    
    


