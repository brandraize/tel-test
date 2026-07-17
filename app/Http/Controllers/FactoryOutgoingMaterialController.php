<?php

namespace App\Http\Controllers;

use App\Models\OutgoingMaterial;
use Illuminate\Http\Request;

class FactoryOutgoingMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingMaterial::query();

        if ($request->filled('search')) {
            $query->where('material_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('customer')) {
            $query->where('customer_name', 'like', '%' . $request->customer . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('date', '<=', $request->to_date);
        }

        $records = $query->orderByDesc('date')->orderByDesc('created_at')->paginate(15)->appends($request->query());

        $summary = [
            'total_price' => $records->total() > 0 ? $query->get()->sum('total_price') : 0,
            'total_received' => $records->total() > 0 ? $query->get()->sum('received_amount') : 0,
            'total_pending' => $records->total() > 0 ? $query->get()->sum('pending_amount') : 0,
            'customers' => $records->total() > 0 ? $query->get()->pluck('customer_name')->unique()->count() : 0,
        ];

        $editing = $request->filled('edit_id') ? OutgoingMaterial::find($request->edit_id) : null;

        return view('factory.outgoing.index', compact('records', 'summary', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        OutgoingMaterial::create($data);

        return redirect()->route('factory.outgoing.index')->with('success', 'Outgoing material recorded successfully.');
    }

    public function update(Request $request, OutgoingMaterial $outgoingMaterial)
    {
        $data = $this->validateData($request);

        $outgoingMaterial->update($data);

        return redirect()->route('factory.outgoing.index')->with('success', 'Outgoing material updated successfully.');
    }

    public function destroy(OutgoingMaterial $outgoingMaterial)
    {
        $outgoingMaterial->delete();

        return redirect()->route('factory.outgoing.index')->with('success', 'Outgoing material deleted successfully.');
    }

    protected function validateData(Request $request): array
    {
        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'material_name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_status' => 'required|in:received,partial,not_received',
            'received_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['total_price'] = round((float) $data['quantity'] * (float) $data['unit_price'], 2);
        $data['received_amount'] = (float) ($data['received_amount'] ?? 0);

        if ($data['payment_status'] === 'received') {
            $data['received_amount'] = $data['total_price'];
        } elseif ($data['payment_status'] === 'not_received') {
            $data['received_amount'] = 0;
        }

        if ($data['received_amount'] > $data['total_price']) {
            abort(422, 'Received amount cannot exceed the total price.');
        }

        return $data;
    }
}
