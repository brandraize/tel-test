<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesDataController extends Controller
{
    public function index()
    {
        // Get all sales grouped by category
        $categories = [
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
        $totals = [];
        foreach ($categories as $category => $sales) {
            $totals[$category] = [
                'total_amount' => $sales->sum('total_amount'),
                'total_profit' => $sales->sum('net_profit'),
                'total_wasool' => $sales->sum('wasool'),
                'total_baqii' => $sales->sum(function($sale) {
                    return $sale->baqii;
                }),
                'count' => $sales->count(),
            ];
        }

        return view('sales-data', compact('categories', 'totals'));
    }
}
