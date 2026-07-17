<?php

namespace App\Http\Controllers;

use App\Models\IncomingMaterial;
use Illuminate\Http\Request;

class FactoryIncomingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingMaterial::query();

        if ($request->filled('search')) {
            $query->where('material_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('supplier')) {
            $query->where('supplier_name', 'like', '%' . $request->supplier . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('date_received', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date_received', '<=', $request->to_date);
        }

        $records = $query->orderByDesc('date_received')->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $summary = [
            'total_cost' => $records->total() > 0 ? $query->get()->sum('total_cost') : 0,
            'total_paid' => $records->total() > 0 ? $query->get()->sum('paid_amount') : 0,
            'total_pending' => $records->total() > 0 ? $query->get()->sum('pending_amount') : 0,
            'suppliers' => $records->total() > 0 ? $query->get()->pluck('supplier_name')->unique()->count() : 0,
        ];

        $editing = $request->filled('edit_id') ? IncomingMaterial::find($request->edit_id) : null;

        return view('factory.incoming.index', compact('records', 'summary', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        IncomingMaterial::create($data);

        return redirect()->route('factory.incoming.index')->with('success', 'Incoming material recorded successfully.');
    }

    public function update(Request $request, IncomingMaterial $incomingMaterial)
    {
        $data = $this->validateData($request);

        $incomingMaterial->update($data);

        return redirect()->route('factory.incoming.index')->with('success', 'Incoming material updated successfully.');
    }

    public function destroy(IncomingMaterial $incomingMaterial)
    {
        $incomingMaterial->delete();

        return redirect()->route('factory.incoming.index')->with('success', 'Incoming material deleted successfully.');
    }

    protected function validateData(Request $request): array
    {
        $data = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'material_name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'date_received' => 'required|date',
            'payment_status' => 'required|in:paid,partial,unpaid',
            'paid_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['total_cost'] = round((float) $data['quantity'] * (float) $data['unit_price'], 2);
        $data['paid_amount'] = (float) ($data['paid_amount'] ?? 0);

        if ($data['payment_status'] === 'paid') {
            $data['paid_amount'] = $data['total_cost'];
        } elseif ($data['payment_status'] === 'unpaid') {
            $data['paid_amount'] = 0;
        }

        if ($data['paid_amount'] > $data['total_cost']) {
            abort(422, 'Paid amount cannot exceed the total cost.');
        }

        return $data;
    }
}
