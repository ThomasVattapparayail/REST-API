<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CustomerController;
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




   //Customer Route
   
    Route::post('register', [CustomerController::class, 'register']);
    Route::post('login', [CustomerController::class, 'login']);
    Route::get('products', [CustomerController::class, 'viewProductList']);

    //Admin Route

    
    Route::post('admin/vendors_add', [AdminController::class, 'store']);
    Route::put('admin/vendors_edit/{vendor}', [AdminController::class, 'update']);
    Route::delete('admin/vendors_delete/{vendor}', [AdminController::class, 'destroy']);

    Route::post('admin/products_add', [AdminController::class, 'addProduct']);
    Route::put('admin/products_edit/{product}', [AdminController::class, 'editProduct']);
    Route::delete('admin/products_delete/{product}', [AdminController::class, 'deleteProduct']);

    Route::post('admin/stocks_add', [AdminController::class, 'addStock']);
    Route::put('admin/stocks_edit/{stock}', [AdminController::class, 'editStock']);
    Route::delete('admin/stocks_delete/{stock}', [AdminController::class, 'deleteStock']);


// Vendor routes

    Route::post('vendor/vendors_add', [VendorController::class, 'addProduct']);
    Route::put('vendor/vendors_edit/{vendor}', [VendorController::class, 'editProduct']);