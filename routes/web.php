<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankLoanController;
use App\Http\Controllers\LoanTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\InventoryTypeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\LateFeeBalanceController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanEntryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Models\LoanType;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('admin/login');
});

/* Admin Routes */

/* Admin Routes without Authentication */

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/post-login', [AdminController::class, 'postLogin']);
});

/* Admin Routes with Authentication */

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/logout', [AdminController::class, 'logout']);

    /* Admin Routes with Authntication */
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    /* Category */
    Route::resource('category', CategoryController::class);

    /* Inventory Type */
    Route::resource('inventory-type', InventoryTypeController::class);

    /* Client Type */
    Route::resource('client-type', ClientTypeController::class);

    Route::post('/getState', [Controller::class, 'getState']);

    /* Inventory */
    Route::resource('inventory', InventoryController::class);
    Route::group(['prefix' => 'inventory'], function () {
        Route::post('data', [InventoryController::class, 'getInventoryData'])->name('inventory.data');
        Route::get('/{id}/edit/{step}', [InventoryController::class, 'edit']);
        Route::get('/{id}/detail', [InventoryController::class, 'show']);
        Route::post('/ajax-inventory-add-note', [InventoryController::class, 'ajaxSaveNotes']);
        Route::post('/ajax-inventory-update-note', [InventoryController::class, 'ajaxUpdateNotes']);
        Route::get('/notes/{id}', [InventoryController::class, 'getNoteDetails']);
        Route::DELETE('/ajax-inventory-delete-note/{id}', [InventoryController::class, 'ajaxDeleteNotes']);
        Route::post('/ajax-inventory-add-file', [InventoryController::class, 'ajaxSavefiles']);
        Route::DELETE('/ajax-inventory-delete-file/{id}', [InventoryController::class, 'ajaxDeletefile']);
        Route::post('/ajax-inventory-add-description', [InventoryController::class, 'ajaxSaveDescription']);
        Route::post('/validateFields', [InventoryController::class, 'validateFields']);
        Route::post('/verifyAddress', [InventoryController::class, 'verifyAddress']);
        Route::get('/getInventory/{id}', [InventoryController::class, 'getInventory']);
    });

    /* Clients */
    Route::resource('client', ClientController::class);
    Route::group(['prefix' => 'client'], function () {
        Route::post('/ajax-client-add-member', [ClientController::class, 'ajaxClientAddMember']);
        Route::post('/ajax-find-family-member', [ClientController::class, 'ajaxFindFamilyMember']);
        Route::get('/customer/email', [ClientController::class, 'sendCustomerEmail']);
    });

    /* Support */
    Route::group(['prefix' => 'support', 'as' => 'support'], function () {
        Route::get('/',[SupportController::class, 'index']);
        Route::get('/create',[SupportController::class, 'create'])->name('.create');
        Route::post('/store',[SupportController::class, 'store'])->name('.store');
        Route::put('/{id}/closeTicket',[SupportController::class, 'closeTicket'])->name('.closeTicket');
        Route::get('/{id}/chat',[SupportController::class, 'chat'])->name('.chat');
        Route::post('/{id}/chat/store',[SupportController::class, 'chatStore'])->name('.chat.store');
    });

    /* Profile */
    Route::group(['prefix' => 'profile', 'as' => 'profile'], function () {
        Route::get('/{id}/edit',[ProfileController::class, 'index']);
        Route::put('/{id}/update',[ProfileController::class, 'updateProfile'])->name('.update');
        Route::get('/{id}/change-password',[ProfileController::class, 'changePassword'])->name('.change-password');
        Route::put('/{id}/updatePassword',[ProfileController::class, 'updatePassword'])->name('.updatePassword');
    });
});



/* Customer Routes */

/* Customer Routes without Authentication */
Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
    Route::get('/login', [CustomerController::class, 'login'])->name('login');
    Route::post('/post-login', [CustomerController::class, 'postLogin']);
});

/* Customer Routes with Authentication */
Route::group(['prefix' => 'customer', 'middleware' => 'auth:customer', 'as' => 'customer.'], function () {
    Route::get('/logout', [CustomerController::class, 'logout']);

    Route::get('/dashboard', [CustomerController::class, 'dashboard']);

    /* Support */
    Route::group(['prefix' => 'support', 'as' => 'support'], function () {
        Route::get('/',[SupportController::class, 'index']);
        Route::get('/create',[SupportController::class, 'create'])->name('.create');
        Route::post('/store',[SupportController::class, 'store'])->name('.store');
        Route::get('/{id}/chat',[SupportController::class, 'chat'])->name('.chat');
        Route::post('/{id}/chat/store',[SupportController::class, 'chatStore'])->name('.chat.store');
    });

    /* Profile */
    Route::group(['prefix' => 'profile', 'as' => 'profile'], function () {
        Route::get('/{id}/edit',[ProfileController::class, 'index']);
        Route::put('/{id}/update',[ProfileController::class, 'updateProfile'])->name('.update');
        Route::get('/{id}/change-password',[ProfileController::class, 'changePassword'])->name('.change-password');
        Route::put('/{id}/updatePassword',[ProfileController::class, 'updatePassword'])->name('.updatePassword');
    });
});
