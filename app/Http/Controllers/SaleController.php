<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB; // ← ADD THIS LINE

class SaleController extends Controller
{
    /**
     * Display a listing of the sales.
     */
    public function index(Request $request)
    {
        // Get category from request or route defaults
        $category = $request->get('category', $request->route('category', 'gress'));

        // Valid categories
        $validCategories = ['gress', 'jalee', 'bailt', 'gonde', 'panjaee', 'tagharee', 'saber_band', 'max_katha'];
        if (!in_array($category, $validCategories)) {
            $category = 'gress';
        }

        // Get sales for this category
        $sales = Sale::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate summary
        $summary = [
            'total_items' => $sales->sum('total_items'),
            'total_amount' => $sales->sum('total_amount'),
            'total_profit' => $sales->sum('net_profit'),
            'total_wasool' => $sales->sum('wasool'),
            'total_baqii' => $sales->sum('baqii'),
            'count' => $sales->count()
        ];

        return view('sales.index', compact('sales', 'category', 'summary'));
    }

    /**
     * Load a category sales page.
     */
    protected function loadCategorySales(string $category)
    {
        $validCategories = ['gress', 'jalee', 'bailt', 'gonde', 'panjaee', 'tagharee', 'saber_band', 'max_katha'];
        if (!in_array($category, $validCategories)) {
            abort(404);
        }

        $sales = Sale::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->get();

        $summary = [
            'total_items' => $sales->sum('total_items'),
            'total_amount' => $sales->sum('total_amount'),
            'total_profit' => $sales->sum('net_profit'),
            'total_wasool' => $sales->sum('wasool'),
            'total_baqii' => $sales->sum('baqii'),
            'count' => $sales->count()
        ];

        return view('sales.index', compact('sales', 'category', 'summary'));
    }

    public function gress()
    {
        return $this->loadCategorySales('gress');
    }

    public function jalee()
    {
        return $this->loadCategorySales('jalee');
    }

    public function bailt()
    {
        return $this->loadCategorySales('bailt');
    }

    public function gonde()
    {
        return $this->loadCategorySales('gonde');
    }

    public function panjaee()
    {
        return $this->loadCategorySales('panjaee');
    }

    public function tagharee()
    {
        return $this->loadCategorySales('tagharee');
    }

    public function saberBand()
    {
        return $this->loadCategorySales('saber_band');
    }

    public function maxKatha()
    {
        return $this->loadCategorySales('max_katha');
    }

    public function pendingMonthly(Request $request)
    {
        $month = $request->get('month', now()->format('m'));
        $year = $request->get('year', now()->year);

        $pendingSales = Sale::withPending()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        $totalPending = $pendingSales->sum('baqii');
        $pendingByCategory = $pendingSales->groupBy('category');

        return view('sales.pending_monthly', compact(
            'pendingSales',
            'pendingByCategory',
            'totalPending',
            'month',
            'year'
        ));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create(Request $request)
    {
        $category = $request->get('category', 'gress');
        return view('sales.create', compact('category'));
    }

    /**
     * Store a newly created sale in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'category' => 'required|in:gress,jalee,bailt,gonde,panjaee,tagharee,max_katha',
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'total_items' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'net_profit' => 'required|numeric|min:0',
            'wasool' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data
        $data = $request->all();
        $data['wasool'] = $data['wasool'] ?? 0;

        // Create sale
        $sale = Sale::create($data);

        return redirect()->route('sales.index', ['category' => $request->category])
            ->with('success', 'Sale recorded successfully!');
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sale $sale)
    {
        return view('sales.edit', compact('sale'));
    }

    /**
     * Update the specified sale in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'nullable|date',
            'total_items' => 'nullable|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'net_profit' => 'required|numeric|min:0',
            'wasool' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Prepare data
        $data = $request->all();
        $data['wasool'] = $data['wasool'] ?? 0;

        // Update sale
        $sale->update($data);

        return redirect()->route('sales.index', ['category' => $sale->category])
            ->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified sale from storage.
     */
    public function destroy(Sale $sale)
    {
        $category = $sale->category;
        $sale->delete();

        return redirect()->route('sales.index', ['category' => $category])
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Dashboard
     */

public function dashboard()
{
    // Get total material cost
    $totalMaterialCost = Material::sum(DB::raw('no_of_items * price'));
    $totalMaterialItems = Material::sum('no_of_items');

    // Get overall sales
    $overallSales = Sale::select(
        DB::raw('SUM(total_amount) as total_sales'),
        DB::raw('SUM(net_profit) as total_profit'),
        DB::raw('SUM(wasool) as total_wasool'),
        DB::raw('SUM(total_amount - wasool) as total_baqii'),
        DB::raw('COUNT(*) as total_transactions')
    )->first();

    // Get sales by category
    $salesByCategory = Sale::select(
        'category',
        DB::raw('SUM(total_amount) as total_sales'),
        DB::raw('SUM(net_profit) as total_profit'),
        DB::raw('SUM(wasool) as total_wasool'),
        DB::raw('SUM(total_amount - wasool) as total_baqii'),
        DB::raw('COUNT(*) as count')
    )
    ->groupBy('category')
    ->orderBy('category')
    ->get();

    // Get recent sales
    $recentSales = Sale::orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

    // Get all sales grouped by category (for detailed view)
    $allCategories = [
        'gress' => Sale::where('category', 'gress')->get(),
        'jalee' => Sale::where('category', 'jalee')->get(),
        'bailt' => Sale::where('category', 'bailt')->get(),
        'gonde' => Sale::where('category', 'gonde')->get(),
        'panjaee' => Sale::where('category', 'panjaee')->get(),
        'tagharee' => Sale::where('category', 'tagharee')->get(),
        'saber_band' => Sale::where('category', 'saber_band')->get(),
        'max_katha' => Sale::where('category', 'max_katha')->get(),
    ];

    // Calculate totals for each category
    $categoryTotals = [];
    foreach ($allCategories as $category => $sales) {
        $categoryTotals[$category] = [
            'total_amount' => $sales->sum('total_amount'),
            'total_profit' => $sales->sum('net_profit'),
            'total_wasool' => $sales->sum('wasool'),
            'total_baqii' => $sales->sum(function($sale) {
                return $sale->baqii;
            }),
            'count' => $sales->count(),
            'sales' => $sales,
        ];
    }

    // 🔥 FIXED: Show ONLY customers with pending amount > 0
    $topCustomers = Sale::select(
        'name',
        DB::raw('SUM(total_amount) as total_amount'),
        DB::raw('SUM(net_profit) as total_profit'),
        DB::raw('SUM(wasool) as total_wasool'),
        DB::raw('SUM(total_amount - wasool) as total_pending'),
        DB::raw('COUNT(*) as transaction_count')
    )
    ->groupBy('name')
    ->having('total_pending', '>', 0) // ← ONLY show customers with pending amount
    ->orderBy('total_pending', 'desc') // ← Sort by highest pending first
    ->limit(50)
    ->get();

    return view('dashboard', compact(
        'totalMaterialCost',
        'totalMaterialItems',
        'overallSales',
        'salesByCategory',
        'recentSales',
        'allCategories',
        'categoryTotals',
        'topCustomers'
    ));
}

    /**
     * Add payment to a sale
     */
    public function addPayment(Request $request, Sale $sale)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $newWasool = $sale->wasool + $request->amount;
        $sale->update(['wasool' => $newWasool]);

        return redirect()->back()
            ->with('success', 'Payment added successfully!');
    }
}
