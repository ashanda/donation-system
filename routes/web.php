<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\GoodIssueController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::group(['middleware' => ['role:super-admin|admin']], function() {

   
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);
    Route::get('permissions/restore', [PermissionController::class, 'restoreAll'])->name('permissions.restoreAll');
    Route::patch('permissions/{permissionId}/restore', [PermissionController::class, 'restore'])->name('permissions.restore');
    Route::delete('permissions/{permissionId}/force-delete', [PermissionController::class, 'forceDelete'])->name('permissions.forceDelete');
    Route::resource('permissions', PermissionController::class);

    
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::delete('roles/{roleId}/force-delete', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');
    Route::get('roles/restore', [RoleController::class, 'restoreAll'])->name('roles.restoreAll');
    Route::get('roles/{roleId}/restore', [RoleController::class, 'restore'])->name('roles.restore');
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);
    Route::resource('roles', RoleController::class);

    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

    Route::get('products/{productsId}/delete', [ProductController::class, 'destroy']);
    Route::get('products/restore', [ProductController::class, 'restoreItems'])->name('products.restoreItems');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
    Route::post('products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::resource('products', ProductController::class);

    Route::get('inventories/{inventoriesId}/delete', [InventoryController::class, 'destroy']);
    Route::get('inventories/restore', [InventoryController::class, 'restoreItems'])->name('inventories.restoreItems');
    Route::delete('inventories/{id}/force-delete', [InventoryController::class, 'forceDelete'])->name('inventories.forceDelete');
    Route::post('inventories/{id}/restore', [InventoryController::class, 'restore'])->name('inventories.restore');
    Route::resource('inventories', InventoryController::class);

    

});


Route::group(['middleware' => ['role:super-admin|admin|donator']], function() {
    
    Route::get('/donate', [DonationController::class, 'create'])->name('donate.form');
    Route::post('/donate', [DonationController::class, 'store'])->name('donate');
    Route::resource('donations', DonationController::class);
});

Route::group(['middleware' => ['role:super-admin|admin|issuer']], function() {
    Route::get('/issue', [GoodIssueController::class, 'create'])->name('issue.form');
    Route::post('/issue', [GoodIssueController::class, 'store'])->name('issue.store');
    Route::resource('good-issues', GoodIssueController::class);
});