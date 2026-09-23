<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffOrderController;
use Illuminate\Support\Facades\Route;


// Dashboard
Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('staff.dashboard');

})->middleware('auth')->name('dashboard');


// Customer
Route::get('/', function () {
    return view('customer.landing');
})->name('customer.landing');

Route::get('/check-laundry', [CustomerController::class, 'showCheckForm'])
    ->name('customer.check-laundry');

Route::post('/check-laundry', [CustomerController::class, 'searchLaundry'])
    ->name('customer.search-laundry');

Route::get('/avail-service', [CustomerController::class, 'showAvailService'])
    ->name('customer.avail-service');

Route::post('/avail-service', [CustomerController::class, 'createOrder'])
    ->name('customer.create-order');


// Authenticated users
Route::middleware('auth')->group(function () {

    // Admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');

    // Staff dashboard
    Route::get('/staff/dashboard', [StaffController::class, 'index'])
        ->name('staff.dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Staff Orders
    Route::get('/staff/orders', [StaffOrderController::class, 'index'])
        ->name('staff.orders.index');

    Route::get('/staff/orders/{order}/edit', [StaffOrderController::class, 'edit'])
        ->name('staff.orders.edit');

    Route::put('/staff/orders/{order}', [StaffOrderController::class, 'update'])
        ->name('staff.orders.update');

    Route::get('/admin/inventory', [InventoryController::class, 'index'])
        ->name('admin.inventory.index');

    Route::post('/admin/inventory', [InventoryController::class, 'store'])
        ->name('admin.inventory.store');

    Route::get('/admin/inventory/{inventoryItem}/edit', [InventoryController::class, 'edit'])
        ->name('admin.inventory.edit');

    Route::put('/admin/inventory/{inventoryItem}', [InventoryController::class, 'update'])
        ->name('admin.inventory.update');

    Route::delete('/admin/inventory/{inventoryItem}', [InventoryController::class, 'destroy'])
        ->name('admin.inventory.destroy');

    Route::get(
        '/admin/inventory/stock-in',
        [InventoryTransactionController::class, 'create']
    )->name('admin.inventory.stock-in');

    Route::post(
        '/admin/inventory/stock-in',
        [InventoryTransactionController::class, 'storeStockIn']
    )->name('admin.inventory.stock-in.store');

    Route::get(
        '/admin/inventory/stock-out',
        [InventoryTransactionController::class, 'createStockOut']
    )->name('admin.inventory.stock-out');

    Route::post(
        '/admin/inventory/stock-out',
        [InventoryTransactionController::class, 'storeStockOut']
    )->name('admin.inventory.stock-out.store');

    Route::get(
        '/admin/inventory/monitor',
        [InventoryController::class, 'monitor']
    )->name('admin.inventory.monitor');

    Route::get(
        '/admin/inventory/view',
        [InventoryController::class, 'view']
    )->name('admin.inventory.view');
});


// Breeze authentication
require __DIR__.'/auth.php';