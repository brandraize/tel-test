<?php
// routes/web.php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesDataController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\FactoryIncomingMaterialController;
use App\Http\Controllers\FactoryOutgoingMaterialController;
use App\Http\Controllers\FactoryExpenseController;
use Illuminate\Http\Request;
use App\Http\Middleware\EnsureAdminAuthenticated;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/admin-login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin-login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    if ($email === 'admin1' && $password === 'password123') {
        $request->session()->put('admin_auth', true);

        return redirect()->route('dashboard');
    }

    return back()->withErrors(['email' => 'Invalid admin credentials.']);
})->name('admin.login.post');

Route::post('/admin-logout', function (Request $request) {
    $request->session()->forget('admin_auth');

    return redirect()->route('admin.login');
})->name('admin.logout');


Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [SaleController::class, 'dashboard'])->name('dashboard')->middleware(EnsureAdminAuthenticated::class);
    Route::get('/sales-data', [SalesDataController::class, 'index'])->name('sales.data')->middleware(EnsureAdminAuthenticated::class);

    Route::prefix('factory')->name('factory.')->group(function () {
    Route::get('/incoming', [FactoryIncomingMaterialController::class, 'index'])->name('incoming.index');
    Route::post('/incoming', [FactoryIncomingMaterialController::class, 'store'])->name('incoming.store');
    Route::put('/incoming/{incomingMaterial}', [FactoryIncomingMaterialController::class, 'update'])->name('incoming.update');
    Route::delete('/incoming/{incomingMaterial}', [FactoryIncomingMaterialController::class, 'destroy'])->name('incoming.destroy');

    Route::get('/outgoing', [FactoryOutgoingMaterialController::class, 'index'])->name('outgoing.index');
    Route::post('/outgoing', [FactoryOutgoingMaterialController::class, 'store'])->name('outgoing.store');
    Route::put('/outgoing/{outgoingMaterial}', [FactoryOutgoingMaterialController::class, 'update'])->name('outgoing.update');
    Route::delete('/outgoing/{outgoingMaterial}', [FactoryOutgoingMaterialController::class, 'destroy'])->name('outgoing.destroy');

    Route::get('/expenses', [FactoryExpenseController::class, 'index'])->name('expenses.index');
    Route::post('/expenses', [FactoryExpenseController::class, 'store'])->name('expenses.store');
    Route::put('/expenses/{factoryExpense}', [FactoryExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{factoryExpense}', [FactoryExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    // ============================================
    // MATERIAL ROUTES (Full CRUD)
    // ============================================

    Route::prefix('materials')->name('materials.')->group(function () {
        // List all materials
        Route::get('/', [MaterialController::class, 'index'])->name('index');

        // Show create form
        Route::get('/create', [MaterialController::class, 'create'])->name('create');

        // Store new material
        Route::post('/', [MaterialController::class, 'store'])->name('store');

        // Show single material
        Route::get('/{material}', [MaterialController::class, 'show'])->name('show');

        // Show edit form
        Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('edit');

        // Update material
        Route::put('/{material}', [MaterialController::class, 'update'])->name('update');

        // Delete material
        Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy');

        // Search materials
        Route::get('/search', [MaterialController::class, 'search'])->name('search');

        // Export materials
        Route::get('/export/pdf', [MaterialController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/export/excel', [MaterialController::class, 'exportExcel'])->name('export.excel');
    });

    // ============================================
    // SALE ROUTES (Full CRUD with category)
    // ============================================

    Route::prefix('sales')->name('sales.')->group(function () {
        // List sales by category
        Route::get('/', [SaleController::class, 'index'])->name('index');

        // Show create form with category
        Route::get('/create', [SaleController::class, 'create'])->name('create');

        // Store new sale
        Route::post('/', [SaleController::class, 'store'])->name('store');

        // Show single sale
        Route::get('/{sale}', [SaleController::class, 'show'])->whereNumber('sale')->name('show');

        // Show edit form
        Route::get('/{sale}/edit', [SaleController::class, 'edit'])->whereNumber('sale')->name('edit');

        // Update sale
        Route::put('/{sale}', [SaleController::class, 'update'])->whereNumber('sale')->name('update');

        // Delete sale
        Route::delete('/{sale}', [SaleController::class, 'destroy'])->whereNumber('sale')->name('destroy');

        // Add payment to sale
        Route::post('/{sale}/payment', [SaleController::class, 'addPayment'])->whereNumber('sale')->name('add.payment');

        // Filter sales by date range
        Route::get('/filter', [SaleController::class, 'filter'])->name('filter');

        // Export sales report
        Route::get('/export/{category}', [SaleController::class, 'export'])->name('export');
    });

    // ============================================
    // CATEGORY-SPECIFIC SALE ROUTES (Shortcuts)
    // ============================================

    Route::prefix('sales')->name('sales.')->group(function () {
        // Gress Sales
        Route::get('/gress', [SaleController::class, 'index'])->defaults('category', 'gress')->name('gress');

        // Jalee Sales
        Route::get('/jalee', [SaleController::class, 'index'])->defaults('category', 'jalee')->name('jalee');

        // Bailt Sales
        Route::get('/bailt', [SaleController::class, 'index'])->defaults('category', 'bailt')->name('bailt');

        // Gonde Sales
        Route::get('/gonde', [SaleController::class, 'index'])->defaults('category', 'gonde')->name('gonde');

        // Panjaee Sales
        Route::get('/panjaee', [SaleController::class, 'index'])->defaults('category', 'panjaee')->name('panjaee');

        // Tagharee Sales
        Route::get('/tagharee', [SaleController::class, 'index'])->defaults('category', 'tagharee')->name('tagharee');

        // Saber Band Sales
        Route::get('/saber-band', [SaleController::class, 'index'])->defaults('category', 'saber_band')->name('saber_band');

        // Max Katha Sales
        Route::get('/max-katha', [SaleController::class, 'index'])->defaults('category', 'max_katha')->name('max_katha');

        // Pending monthly amounts
        Route::get('/pending-monthly', [SaleController::class, 'pendingMonthly'])->name('pending.monthly');
    });

    // ============================================
    // EXPENSE ROUTES
    // ============================================

    Route::prefix('expenses')->name('expenses.')->group(function () {
        // List all expenses
        Route::get('/', [ExpenseController::class, 'index'])->name('index');

        // Show create form
        Route::get('/create', [ExpenseController::class, 'create'])->name('create');

        // Store new expense
        Route::post('/', [ExpenseController::class, 'store'])->name('store');

        // Show single expense
        Route::get('/{expense}', [ExpenseController::class, 'show'])->name('show');

        // Show edit form
        Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');

        // Update expense
        Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');

        // Delete expense
        Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
    });

    // ============================================
    // REPORT ROUTES
    // ============================================

    Route::prefix('reports')->name('reports.')->group(function () {
        // Profit & Loss Report
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');

        // Category-wise Report
        Route::get('/category/{category}', [ReportController::class, 'categoryWise'])->name('category-wise');

        // Date Range Report
        Route::get('/date-range', [ReportController::class, 'dateRange'])->name('date-range');

        // Monthly Summary
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');

        // Yearly Summary
        Route::get('/yearly', [ReportController::class, 'yearly'])->name('yearly');

        // Customer Report
        Route::get('/customer/{name}', [ReportController::class, 'customer'])->name('customer');
    });

    // ============================================
    // API-LIKE ROUTES (for AJAX)
    // ============================================

    Route::prefix('api')->name('api.')->group(function () {
        // Get material details
        Route::get('/material/{id}', [MaterialController::class, 'getDetails'])->name('material.details');

        // Get sales summary
        Route::get('/sales-summary', [SaleController::class, 'getSummary'])->name('sales.summary');

        // Get dashboard data
        Route::get('/dashboard-data', [SaleController::class, 'getDashboardData'])->name('dashboard.data');

        // Search customers
        Route::get('/customers/search', [SaleController::class, 'searchCustomers'])->name('customers.search');
    });

    // ============================================
    // PROFILE ROUTES (if using authentication)
    // ============================================

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // ============================================
    // SETTINGS ROUTES
    // ============================================

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/update', [SettingsController::class, 'update'])->name('update');
    });
});

// ============================================
// AUTHENTICATION ROUTES (if using Laravel Breeze/Jetstream)
// ============================================
// Uncomment if you have authentication installed
/*
Auth::routes();

Route::middleware(['auth'])->group(function () {
    // All protected routes here
});
*/

// ============================================
// MATERIAL ROUTES (Full CRUD)
// ============================================

Route::prefix('materials')->name('materials.')->group(function () {
    // List all materials
    Route::get('/', [MaterialController::class, 'index'])->name('index');

    // Show create form
    Route::get('/create', [MaterialController::class, 'create'])->name('create');

    // Store new material
    Route::post('/', [MaterialController::class, 'store'])->name('store');

    // Show single material
    Route::get('/{material}', [MaterialController::class, 'show'])->name('show');

    // Show edit form
    Route::get('/{material}/edit', [MaterialController::class, 'edit'])->name('edit');

    // Update material
    Route::put('/{material}', [MaterialController::class, 'update'])->name('update');

    // Delete material
    Route::delete('/{material}', [MaterialController::class, 'destroy'])->name('destroy');

    // Search materials
    Route::get('/search', [MaterialController::class, 'search'])->name('search');

    // Export materials
    Route::get('/export/pdf', [MaterialController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/export/excel', [MaterialController::class, 'exportExcel'])->name('export.excel');
});

// ============================================
// SALE ROUTES (Full CRUD with category)
// ============================================

Route::prefix('sales')->name('sales.')->group(function () {
    // List sales by category
    Route::get('/', [SaleController::class, 'index'])->name('index');

    // Show create form with category
    Route::get('/create', [SaleController::class, 'create'])->name('create');

    // Store new sale
    Route::post('/', [SaleController::class, 'store'])->name('store');

    // Show single sale
    Route::get('/{sale}', [SaleController::class, 'show'])->whereNumber('sale')->name('show');

    // Show edit form
    Route::get('/{sale}/edit', [SaleController::class, 'edit'])->whereNumber('sale')->name('edit');

    // Update sale
    Route::put('/{sale}', [SaleController::class, 'update'])->whereNumber('sale')->name('update');

    // Delete sale
    Route::delete('/{sale}', [SaleController::class, 'destroy'])->whereNumber('sale')->name('destroy');

    // Add payment to sale
    Route::post('/{sale}/payment', [SaleController::class, 'addPayment'])->whereNumber('sale')->name('add.payment');

    // Filter sales by date range
    Route::get('/filter', [SaleController::class, 'filter'])->name('filter');

    // Export sales report
    Route::get('/export/{category}', [SaleController::class, 'export'])->name('export');
});

// ============================================
// CATEGORY-SPECIFIC SALE ROUTES (Shortcuts)
// ============================================

Route::prefix('sales')->name('sales.')->group(function () {
    // Gress Sales
    Route::get('/gress', [SaleController::class, 'index'])->defaults('category', 'gress')->name('gress');

    // Jalee Sales
    Route::get('/jalee', [SaleController::class, 'index'])->defaults('category', 'jalee')->name('jalee');

    // Bailt Sales
    Route::get('/bailt', [SaleController::class, 'index'])->defaults('category', 'bailt')->name('bailt');

    // Gonde Sales
    Route::get('/gonde', [SaleController::class, 'index'])->defaults('category', 'gonde')->name('gonde');

    // Panjaee Sales
    Route::get('/panjaee', [SaleController::class, 'index'])->defaults('category', 'panjaee')->name('panjaee');

    // Tagharee Sales
    Route::get('/tagharee', [SaleController::class, 'index'])->defaults('category', 'tagharee')->name('tagharee');

    // Saber Band Sales
    Route::get('/saber-band', [SaleController::class, 'index'])->defaults('category', 'saber_band')->name('saber_band');

    // Max Katha Sales
    Route::get('/max-katha', [SaleController::class, 'index'])->defaults('category', 'max_katha')->name('max_katha');

    // Pending monthly amounts
    Route::get('/pending-monthly', [SaleController::class, 'pendingMonthly'])->name('pending.monthly');
});

// ============================================
// EXPENSE ROUTES
// ============================================

Route::prefix('expenses')->name('expenses.')->group(function () {
    // List all expenses
    Route::get('/', [ExpenseController::class, 'index'])->name('index');

    // Show create form
    Route::get('/create', [ExpenseController::class, 'create'])->name('create');

    // Store new expense
    Route::post('/', [ExpenseController::class, 'store'])->name('store');

    // Show single expense
    Route::get('/{expense}', [ExpenseController::class, 'show'])->name('show');

    // Show edit form
    Route::get('/{expense}/edit', [ExpenseController::class, 'edit'])->name('edit');

    // Update expense
    Route::put('/{expense}', [ExpenseController::class, 'update'])->name('update');

    // Delete expense
    Route::delete('/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
});

// ============================================
// REPORT ROUTES
// ============================================

Route::prefix('reports')->name('reports.')->group(function () {
    // Profit & Loss Report
    Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('profit-loss');

    // Category-wise Report
    Route::get('/category/{category}', [ReportController::class, 'categoryWise'])->name('category-wise');

    // Date Range Report
    Route::get('/date-range', [ReportController::class, 'dateRange'])->name('date-range');

    // Monthly Summary
    Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');

    // Yearly Summary
    Route::get('/yearly', [ReportController::class, 'yearly'])->name('yearly');

    // Customer Report
    Route::get('/customer/{name}', [ReportController::class, 'customer'])->name('customer');
});

// ============================================
// API-LIKE ROUTES (for AJAX)
// ============================================

Route::prefix('api')->name('api.')->group(function () {
    // Get material details
    Route::get('/material/{id}', [MaterialController::class, 'getDetails'])->name('material.details');

    // Get sales summary
    Route::get('/sales-summary', [SaleController::class, 'getSummary'])->name('sales.summary');

    // Get dashboard data
    Route::get('/dashboard-data', [SaleController::class, 'getDashboardData'])->name('dashboard.data');

    // Search customers
    Route::get('/customers/search', [SaleController::class, 'searchCustomers'])->name('customers.search');
});

// ============================================
// PROFILE ROUTES (if using authentication)
// ============================================

Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// ============================================
// SETTINGS ROUTES
// ============================================

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
    Route::post('/update', [SettingsController::class, 'update'])->name('update');
});

// ============================================
// HELPER ROUTES
// ============================================

// Clear cache route (for development)
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return redirect()->back()->with('success', 'Cache cleared successfully!');
})->name('clear.cache');

// Test database connection
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection successful!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});

// ============================================
// FALLBACK ROUTE (404 page)
// ============================================

Route::fallback(function () {
    return view('errors.404');
});
