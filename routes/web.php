<?php

    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\GoogleAuthController;
    use App\Http\Controllers\GroupController;
    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('search_customer', [CustomerController::class, 'search'])->name('search_customer');
    Route::post('update_customer', [CustomerController::class, 'update'])->name('update_customer');
    Route::get('get_customer/{customer_id}', [CustomerController::class, 'get_customer'])->name('get_customer');
    Route::get('customer/{customer}', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::patch('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('customer_destroy/{customer_id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    Route::post('customers.send_invoice', [CustomerController::class, 'send_invoice'])->name('customers.send_invoice');

    Route::get('new_invoice', [InvoiceController::class, 'create'])->name('invoices.create');

    Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('preview_pdf/{invoice}', [InvoiceController::class, 'preview_pdf'])->name('invoices.preview_pdf');
    Route::post('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::post('invoices_update_status', [InvoiceController::class, 'update_status'])->name('invoices.update_status');
    Route::post('invoices_send_email', [InvoiceController::class, 'send_email'])->name('invoices.send_email');
    Route::get('invoices_search_by_status/{status}', [InvoiceController::class, 'search_by_status'])->name('invoices.invoices_search_by_status');
    Route::post('massive_invoices_send_email', [InvoiceController::class, 'send_email'])->name('invoices.massive_send_email');
    Route::get('invoice_destroy/{invoice_id}', [InvoiceController::class, 'invoice_destroy'])->name('invoices.destroy');


    Route::resource('groups', GroupController::class);
    Route::get('group_destroy/{group_id}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::post('groups_manage_customer', [GroupController::class, 'manage_customer'])->name('groups.manage_customer');

    Route::get('status_invoice_send', [InvoiceController::class, 'status_invoice_send'])->name('status_invoice_send');
});

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.auth');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);

require __DIR__.'/auth.php';
