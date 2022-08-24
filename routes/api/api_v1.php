<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\{AuthController,UserController,RoleController,ProductController,BuyController,SaleController};

class Api{

    private static $products_id;
    private static $users_id;
    private static $roles_id;

    public function __construct()
    {
        $this->products_id = '/products/{id}';
        $this->users_id = '/users/{id}';
        $this->roles_id = '/roles/{id}';
    }

}

Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'products'])->name('products.all');
Route::get(Api::products_id, [ProductController::class, 'show'])->name('products.show');

Route::post('/auth/auth', [AuthController::class, 'me'])->name('auth.me');

// Grupo Administrador 'role:Administrador'
Route::middleware(['auth.api','jwt.auth'])->group(function () {    

    // Auth
    Route::post('/auth/logout', [AuthController::class,'logout'])->name('auth.logout');

    // Users
    Route::get('/users', [UserController::class, 'users'])->name('users.all')->middleware('permission:users.all');
    Route::get($users_id, [UserController::class, 'show'])->name('users.show')->middleware('permission:users.show');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.store');
    Route::put($users_id,[UserController::class,'update'])->name('users.update')->middleware('permission:users.update');
    Route::delete($users_id,[UserController::class,'delete'])->name('users.delete')->middleware('permission:users.delete');

    // Roles
    Route::get('/roles', [RoleController::class, 'roles'])->name('roles.all')->middleware('permission:roles.all');
    Route::get($roles_id, [RoleController::class, 'show'])->name('roles.show')->middleware('permission:roles.show');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.store'); 
    Route::put($roles_id,[RoleController::class,'update'])->name('roles.update')->middleware('permission:roles.update');
    Route::delete($roles_id,[RoleController::class,'delete'])->name('roles.delete')->middleware('permission:roles.delete');

    // Product
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:products.store');
    Route::put($products_id,[ProductController::class,'update'])->name('products.update')->middleware('permission:products.update');
    Route::delete($products_id,[ProductController::class,'delete'])->name('products.delete')->middleware('permission:products.delete');

    // Buy
    Route::get('/shopping', [BuyController::class, 'shopping'])->name('shopping.all')->middleware('permission:shopping.all');
    Route::post('/buy', [BuyController::class, 'buy'])->name('buy')->middleware('permission:buy');
    Route::put('/buy/{id}',[BuyController::class,'update'])->name('buy.update')->middleware('permission:buy.update');

    // Sales
    Route::get('/sales', [SaleController::class, 'sales'])->name('sales.all')->middleware('permission:sales.all');

});

Route::any('{any}', function(){
    return response()->json([
        'status'    => false,
        'message'   => 'Recurso no encontrado.',
    ], 404);
})->where('any', '.*');
    

