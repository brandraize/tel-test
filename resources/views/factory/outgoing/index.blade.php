@extends('layouts.app')

@section('title', 'Factory Outgoing Materials')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
        <div>
            <h3 class="mb-1"><i class="fas fa-truck me-2 text-success"></i>Factory Outgoing Materials</h3>
            <p class="text-muted mb-0">Track materials leaving the factory with payment status.</p>
        </div>
        <a href="#outgoing-form" class="btn btn-success"><i class="fas fa-plus me-2"></i>New Outgoing</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6"><div class="card border-success"><div class="card-body"><div class="text-muted small">Total Outgoing</div><div class="h4 mb-0">PKR {{ number_format($summary['total_price'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-success"><div class="card-body"><div class="text-muted small">Total Received</div><div class="h4 mb-0">PKR {{ number_format($summary['total_received'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-danger"><div class="card-body"><div class="text-muted small">Total Pending</div><div class="h4 mb-0">PKR {{ number_format($summary['total_pending'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-info"><div class="card-body"><div class="text-muted small">Number of Customers</div><div class="h4 mb-0">{{ $summary['customers'] ?? 0 }}</div></div></div></div>
    </div>

    <div class="card mb-4" id="outgoing-form">
        <div class="card-header bg-success text-white">{{ $editing ? 'Edit Outgoing Material' : 'Add Outgoing Material' }}</div>
        <div class="card-body">
            <form method="POST" action="{{ $editing ? route('factory.outgoing.update', $editing->id) : route('factory.outgoing.store') }}">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Customer/Buyer Name</label><input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $editing?->customer_name ?? '') }}" required></div>
                    <div class="col-md-4"><label class="form-label">Material Name</label><input type="text" name="material_name" class="form-control" value="{{ old('material_name', $editing?->material_name ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Quantity</label><input type="number" step="0.01" name="quantity" class="form-control" value="{{ old('quantity', $editing?->quantity ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Unit Price</label><input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $editing?->unit_price ?? '') }}" required></div>
                    <div class="col-md-3"><label class="form-label">Date</label><input type="date" name="date" class="form-control" value="{{ old('date', $editing?->date?->format('Y-m-d') ?? now()->toDateString()) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="received" {{ old('payment_status', $editing?->payment_status ?? '') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="partial" {{ old('payment_status', $editing?->payment_status ?? '') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="not_received" {{ old('payment_status', $editing?->payment_status ?? '') == 'not_received' ? 'selected' : '' }}>Not Received</option>
                        </select>
                    </div>
                    <div class="col-md-2"><label class="form-label">Received Amount</label><input type="number" step="0.01" name="received_amount" class="form-control" value="{{ old('received_amount', $editing?->received_amount ?? '') }}"></div>
                    <div class="col-md-2"><label class="form-label">Due Date</label><input type="date" name="due_date" class="form-control" value="{{ old('due_date', $editing?->due_date?->format('Y-m-d') ?? '') }}"></div>
                    <div class="col-md-2"><label class="form-label">Invoice #</label><input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number', $editing?->invoice_number ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $editing?->notes ?? '') }}</textarea></div>
                </div>
                <div class="mt-3"><button type="submit" class="btn btn-success">{{ $editing ? 'Update' : 'Save' }}</button>@if($editing)<a href="{{ route('factory.outgoing.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>@endif</div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Filter & Records</div>
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search material" value="{{ request('search') }}"></div>
                <div class="col-md-2"><input type="text" name="customer" class="form-control" placeholder="Customer" value="{{ request('customer') }}"></div>
                <div class="col-md-2"><select name="status" class="form-select"><option value="all">All Status</option><option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option><option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option><option value="not_received" {{ request('status') == 'not_received' ? 'selected' : '' }}>Not Received</option></select></div>
                <div class="col-md-2"><input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"></div>
                <div class="col-md-2"><input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-outline-success w-100">Go</button></div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr><th>#</th><th>Date</th><th>Customer</th><th>Material</th><th>Qty</th><th>Unit Price</th><th>Total Price</th><th>Received</th><th>Pending</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr>
                            <td>{{ $loop->iteration + ($records->currentPage()-1)*$records->perPage() }}</td>
                            <td>{{ $record->date->format('d/m/Y') }}</td>
                            <td>{{ $record->customer_name }}</td>
                            <td>{{ $record->material_name }}</td>
                            <td>{{ $record->quantity }}</td>
                            <td>PKR {{ number_format($record->unit_price, 2) }}</td>
                            <td>PKR {{ number_format($record->total_price, 2) }}</td>
                            <td>PKR {{ number_format($record->received_amount, 2) }}</td>
                            <td>PKR {{ number_format($record->pending_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $record->payment_status === 'received' ? 'success' : ($record->payment_status === 'partial' ? 'warning text-dark' : 'danger') }}">{{ str_replace('_',' ', ucfirst($record->payment_status)) }}</span></td>
                            <td>
                                <a href="{{ route('factory.outgoing.index', ['edit_id' => $record->id]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="{{ route('factory.outgoing.destroy', $record->id) }}" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center text-muted py-4">No outgoing materials found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $records->links() }}</div>
        </div>
    </div>
</div>
@endsection
