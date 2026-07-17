@extends('layouts.app')

@section('title', 'Factory Incoming Materials')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
        <div>
            <h3 class="mb-1"><i class="fas fa-truck-loading me-2 text-primary"></i>Factory Incoming Materials</h3>
            <p class="text-muted mb-0">Track materials arriving at the factory with payment status.</p>
        </div>
        <a href="#incoming-form" class="btn btn-primary"><i class="fas fa-plus me-2"></i>New Incoming</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card border-primary">
                <div class="card-body">
                    <div class="text-muted small">Total Incoming</div>
                    <div class="h4 mb-0">PKR {{ number_format($summary['total_cost'] ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-success">
                <div class="card-body">
                    <div class="text-muted small">Total Paid</div>
                    <div class="h4 mb-0">PKR {{ number_format($summary['total_paid'] ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="text-muted small">Total Pending</div>
                    <div class="h4 mb-0">PKR {{ number_format($summary['total_pending'] ?? 0, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card border-info">
                <div class="card-body">
                    <div class="text-muted small">Number of Suppliers</div>
                    <div class="h4 mb-0">{{ $summary['suppliers'] ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4" id="incoming-form">
        <div class="card-header bg-primary text-white">{{ $editing ? 'Edit Incoming Material' : 'Add Incoming Material' }}</div>
        <div class="card-body">
            <form method="POST" action="{{ $editing ? route('factory.incoming.update', $editing->id) : route('factory.incoming.store') }}">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label">Supplier Name</label><input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name', $editing?->supplier_name ?? '') }}" required></div>
                    <div class="col-md-4"><label class="form-label">Material Name</label><input type="text" name="material_name" class="form-control" value="{{ old('material_name', $editing?->material_name ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Quantity</label><input type="number" step="0.01" name="quantity" class="form-control" value="{{ old('quantity', $editing?->quantity ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Unit Price</label><input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $editing?->unit_price ?? '') }}" required></div>
                    <div class="col-md-3"><label class="form-label">Date Received</label><input type="date" name="date_received" class="form-control" value="{{ old('date_received', $editing?->date_received?->format('Y-m-d') ?? now()->toDateString()) }}" required></div>
                    <div class="col-md-3"><label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="paid" {{ old('payment_status', $editing?->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ old('payment_status', $editing?->payment_status ?? '') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="unpaid" {{ old('payment_status', $editing?->payment_status ?? '') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-2"><label class="form-label">Paid Amount</label><input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ old('paid_amount', $editing?->paid_amount ?? '') }}"></div>
                    <div class="col-md-2"><label class="form-label">Due Date</label><input type="date" name="due_date" class="form-control" value="{{ old('due_date', $editing?->due_date?->format('Y-m-d') ?? '') }}"></div>
                    <div class="col-md-2"><label class="form-label">Invoice #</label><input type="text" name="invoice_number" class="form-control" value="{{ old('invoice_number', $editing?->invoice_number ?? '') }}"></div>
                    <div class="col-md-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $editing?->notes ?? '') }}</textarea></div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">{{ $editing ? 'Update' : 'Save' }}</button>
                    @if($editing)<a href="{{ route('factory.incoming.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>@endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Filter & Records</div>
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search material" value="{{ request('search') }}"></div>
                <div class="col-md-2"><input type="text" name="supplier" class="form-control" placeholder="Supplier" value="{{ request('supplier') }}"></div>
                <div class="col-md-2"><select name="status" class="form-select"><option value="all">All Status</option><option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option><option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option><option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option></select></div>
                <div class="col-md-2"><input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"></div>
                <div class="col-md-2"><input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-outline-primary w-100">Go</button></div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr><th>#</th><th>Date</th><th>Supplier</th><th>Material</th><th>Qty</th><th>Unit Price</th><th>Total Cost</th><th>Paid</th><th>Pending</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr>
                            <td>{{ $loop->iteration + ($records->currentPage()-1)*$records->perPage() }}</td>
                            <td>{{ $record->date_received->format('d/m/Y') }}</td>
                            <td>{{ $record->supplier_name }}</td>
                            <td>{{ $record->material_name }}</td>
                            <td>{{ $record->quantity }}</td>
                            <td>PKR {{ number_format($record->unit_price, 2) }}</td>
                            <td>PKR {{ number_format($record->total_cost, 2) }}</td>
                            <td>PKR {{ number_format($record->paid_amount, 2) }}</td>
                            <td>PKR {{ number_format($record->pending_amount, 2) }}</td>
                            <td><span class="badge bg-{{ $record->payment_status === 'paid' ? 'success' : ($record->payment_status === 'partial' ? 'warning text-dark' : 'danger') }}">{{ ucfirst($record->payment_status) }}</span></td>
                            <td>
                                <a href="{{ route('factory.incoming.index', ['edit_id' => $record->id]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="{{ route('factory.incoming.destroy', $record->id) }}" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="11" class="text-center text-muted py-4">No incoming materials found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $records->links() }}</div>
        </div>
    </div>
</div>
@endsection
