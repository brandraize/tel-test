<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expenses.index', ['expenses' => []]);
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('expenses.index')->with('success', 'Expense saved.');
    }

    public function show($expense)
    {
        return view('expenses.show', ['expense' => $expense]);
    }

    public function edit($expense)
    {
        return view('expenses.edit', ['expense' => $expense]);
    }

    public function update(Request $request, $expense)
    {
        return redirect()->route('expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy($expense)
    {
        return redirect()->route('expenses.index')->with('success', 'Expense deleted.');
    }
}
