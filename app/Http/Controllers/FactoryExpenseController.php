<?php

namespace App\Http\Controllers;

use App\Models\FactoryExpense;
use Illuminate\Http\Request;

class FactoryExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = FactoryExpense::query();

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->filled('payment_method') && $request->payment_method !== 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $records = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $summary = [
            'total_expenses' => $records->total() > 0 ? $query->get()->sum('amount') : 0,
            'this_month' => $records->total() > 0 ? $query->get()->whereBetween('date', [now()->startOfMonth()->toDateString(), now()->endOfMonth()->toDateString()])->sum('amount') : 0,
            'today' => $records->total() > 0 ? $query->get()->where('date', now()->toDateString())->sum('amount') : 0,
            'categories' => $records->total() > 0 ? $query->get()->groupBy('category')->count() : 0,
        ];

        $editing = $request->filled('edit_id') ? FactoryExpense::find($request->edit_id) : null;

        return view('factory.expenses.index', compact('records', 'summary', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        FactoryExpense::create($data);

        return redirect()->route('factory.expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function update(Request $request, FactoryExpense $factoryExpense)
    {
        $data = $request->validate([
            'category' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $factoryExpense->update($data);

        return redirect()->route('factory.expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(FactoryExpense $factoryExpense)
    {
        $factoryExpense->delete();

        return redirect()->route('factory.expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
