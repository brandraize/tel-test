<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function profitLoss()
    {
        return response()->json([
            'message' => 'Profit and loss report is not implemented yet.',
        ]);
    }

    public function categoryWise($category)
    {
        return response()->json([
            'category' => $category,
            'message' => 'Category report is not implemented yet.',
        ]);
    }

    public function dateRange(Request $request)
    {
        return response()->json([
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'message' => 'Date range report is not implemented yet.',
        ]);
    }

    public function monthly()
    {
        return response()->json([
            'message' => 'Monthly summary is not implemented yet.',
        ]);
    }

    public function yearly()
    {
        return response()->json([
            'message' => 'Yearly summary is not implemented yet.',
        ]);
    }

    public function customer($name)
    {
        return response()->json([
            'customer' => $name,
            'message' => 'Customer report is not implemented yet.',
        ]);
    }
}
