<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials.
     */
    public function index()
    {
        // Get all materials with latest fi$t
        $materials = Material::orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalCost = $materials->sum('total_cost');
        $totalItems = $materials->sum('no_of_items');
        $count = $materials->count();

        return view('materials.index', compact('materials', 'totalCost', 'totalItems', 'count'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        return view('materials.create');
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'no_of_items' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new material
        $material = Material::create([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'no_of_items' => $request->no_of_items,
            'price' => $request->price,
            'date' => $request->date ?? now()
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Material added successfully!');
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'no_of_items' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'date' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update material
        $material->update([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'no_of_items' => $request->no_of_items,
            'price' => $request->price,
            'date' => $request->date
        ]);

        return redirect()->route('materials.index')
            ->with('success', 'Material updated successfully!');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Material deleted successfully!');
    }

    /**
     * Search materials.
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $materials = Material::search($search)->get();

        return view('materials.index', compact('materials'));
    }
}
