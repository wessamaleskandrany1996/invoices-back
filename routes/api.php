<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\InvoicePaymentController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\api\SalesInvoiceController;
use App\Http\Controllers\Api\StoreProductController;
use App\Http\Controllers\api\PurchaseInvoiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['cors'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('products', ProductController::class);



Route::apiResource('categories', CategoryController::class);
Route::apiResource('suppliers', SupplierController::class);
Route::post('store_product', [StoreProductController::class, 'StoreProduct']);
Route::apiResource('invoices', InvoiceController::class);
// Route::apiResource('invoices', InvoiceController::class)->middleware(
//     'permission:create-invoice'
// );
Route::post('provide', [TransactionController::class, 'transaction']);
Route::get('transaction', [TransactionController::class, 'getTransaction']);
Route::get('/transactionbydate', [TransactionController::class, 'getTransactionByDate']);

Route::put('full_payment/{id}', [InvoicePaymentController::class, 'fullPayment']);
Route::put('partial_payment/{id}', [InvoicePaymentController::class, 'partialPayment']);

Route::post('purchaseInvoice', [PurchaseInvoiceController::class, 'purchaseInvoice']);
Route::post('sellInvoice', [SalesInvoiceController::class, 'sellInvoice']);
Route::get('salesInvoices', [SalesInvoiceController::class, 'getSalesInvoice']);


    // Route::group(['middleware' => ['auth']], function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    // });


    //     ['only' => ['index', 'store']],
    //     'permission:role-create',
    //     ['only' => ['create', 'store']],
    //     'permission:role-edit',
    //     ['only' => ['edit', 'update']],
    //     'permission:role-delete',
    //     ['only' => ['destroy']]

    // );


    // middleware to ensure that every request is authenticated
    // Route::middleware('auth:api')->group(function () {

    //     Route::post('logout', [AuthController::class, 'logout']);
    // });
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::get('/filter/{type}', [InvoiceController::class, 'filter']);
    Route::get('/postponedInvoices', [InvoiceController::class, 'postponedInvoices']);

});

Route::get('/dashboard',[DashboardController::class,'dashboard']);
Route::get('/lastInvoices',[DashboardController::class,'lastInvoices']);
