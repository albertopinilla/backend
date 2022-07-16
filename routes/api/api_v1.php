<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController,UserController,RoleController,ProductController,BuyController};


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
Route::post('/auth/logout', [AuthController::class,'logout']);

// Grupo Administrador
Route::middleware(['auth.api','role:Administrador','jwt.auth'])->group(function () {    

    // Users
    Route::get('/users', [UserController::class, 'users'])->name('users.all');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store'); 
    Route::put('/users/{id}',[UserController::class,'update'])->name('users.update');
    Route::delete('/users/{id}',[UserController::class,'delete'])->name('users.delete');

    // Permissions
    Route::get('/roles', [RoleController::class, 'roles'])->name('roles.all');
    Route::get('/roles/{id}', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store'); 
    Route::put('/roles/{id}',[RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/{id}',[RoleController::class,'delete'])->name('roles.delete');

});

Route::middleware(['auth.api','jwt.auth'])->group(function () {    

    // Product
    Route::get('/products', [ProductController::class, 'products'])->name('products.all')->middleware('permission:products.all');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show')->middleware('permission:products.show');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:products.store');
    Route::put('/products/{id}',[ProductController::class,'update'])->name('products.update')->middleware('permission:products.update');
    Route::delete('/products/{id}',[ProductController::class,'delete'])->name('products.delete')->middleware('permission:products.delete');

    // Buy
    Route::get('/shopping', [BuyController::class, 'shopping'])->name('shopping.all')->middleware('permission:shopping.all');
    Route::post('/buy', [BuyController::class, 'buy'])->name('buy')->middleware('permission:buy');
    // Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:products.store');
    // Route::put('/products/{id}',[ProductController::class,'update'])->name('products.update')->middleware('permission:products.update');
    // Route::delete('/products/{id}',[ProductController::class,'delete'])->name('products.delete')->middleware('permission:products.delete');

});

Route::fallback(function () {
    return response()->json([
        'success' => false,
        'message' => 'Recurso no encontrado',
    ], 404);
});
    
    


