@extends('layouts.app')

@section('title', 'Factory Expenses')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-2">
        <div>
            <h3 class="mb-1"><i class="fas fa-wallet me-2 text-warning"></i>Factory Expenses</h3>
            <p class="text-muted mb-0">Track labor, maintenance, fuel, utilities, transport, and other factory costs.</p>
        </div>
        <a href="#expense-form" class="btn btn-warning"><i class="fas fa-plus me-2"></i>New Expense</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6"><div class="card border-warning"><div class="card-body"><div class="text-muted small">Total Expenses</div><div class="h4 mb-0">PKR {{ number_format($summary['total_expenses'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-secondary"><div class="card-body"><div class="text-muted small">This Month</div><div class="h4 mb-0">PKR {{ number_format($summary['this_month'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-info"><div class="card-body"><div class="text-muted small">Today</div><div class="h4 mb-0">PKR {{ number_format($summary['today'] ?? 0, 2) }}</div></div></div></div>
        <div class="col-md-3 col-sm-6"><div class="card border-primary"><div class="card-body"><div class="text-muted small">Categories</div><div class="h4 mb-0">{{ $summary['categories'] ?? 0 }}</div></div></div></div>
    </div>

    <div class="card mb-4" id="expense-form">
        <div class="card-header bg-warning text-dark">{{ $editing ? 'Edit Expense' : 'Add Expense' }}</div>
        <div class="card-body">
            <form method="POST" action="{{ $editing ? route('factory.expenses.update', $editing->id) : route('factory.expenses.store') }}">
                @csrf
                @if($editing) @method('PUT') @endif
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">Category</label><select name="category" class="form-select" required><option value="">Select</option><option value="Labor/Wages" {{ old('category', $editing?->category ?? '') == 'Labor/Wages' ? 'selected' : '' }}>Labor/Wages</option><option value="Repair & Maintenance" {{ old('category', $editing?->category ?? '') == 'Repair & Maintenance' ? 'selected' : '' }}>Repair & Maintenance</option><option value="Petrol/Fuel" {{ old('category', $editing?->category ?? '') == 'Petrol/Fuel' ? 'selected' : '' }}>Petrol/Fuel</option><option value="Transportation" {{ old('category', $editing?->category ?? '') == 'Transportation' ? 'selected' : '' }}>Transportation</option><option value="Utilities" {{ old('category', $editing?->category ?? '') == 'Utilities' ? 'selected' : '' }}>Utilities</option><option value="Packaging" {{ old('category', $editing?->category ?? '') == 'Packaging' ? 'selected' : '' }}>Packaging</option><option value="Cleaning" {{ old('category', $editing?->category ?? '') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option><option value="Tools & Equipment" {{ old('category', $editing?->category ?? '') == 'Tools & Equipment' ? 'selected' : '' }}>Tools & Equipment</option><option value="Stationery" {{ old('category', $editing?->category ?? '') == 'Stationery' ? 'selected' : '' }}>Stationery</option><option value="Rent" {{ old('category', $editing?->category ?? '') == 'Rent' ? 'selected' : '' }}>Rent</option><option value="Miscellaneous" {{ old('category', $editing?->category ?? '') == 'Miscellaneous' ? 'selected' : '' }}>Miscellaneous</option></select></div>
                    <div class="col-md-3"><label class="form-label">Description</label><input type="text" name="description" class="form-control" value="{{ old('description', $editing?->description ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Amount</label><input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $editing?->amount ?? '') }}" required></div>
                    <div class="col-md-2"><label class="form-label">Date</label><input type="date" name="date" class="form-control" value="{{ old('date', $editing?->date?->format('Y-m-d') ?? now()->toDateString()) }}" required></div>
                    <div class="col-md-2"><label class="form-label">Payment Method</label><select name="payment_method" class="form-select" required><option value="Cash" {{ old('payment_method', $editing?->payment_method ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option><option value="Bank Transfer" {{ old('payment_method', $editing?->payment_method ?? '') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option><option value="Cheque" {{ old('payment_method', $editing?->payment_method ?? '') == 'Cheque' ? 'selected' : '' }}>Cheque</option></select></div>
                    <div class="col-md-3"><label class="form-label">Reference</label><input type="text" name="reference" class="form-control" value="{{ old('reference', $editing?->reference ?? '') }}"></div>
                    <div class="col-md-9"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes', $editing?->notes ?? '') }}</textarea></div>
                </div>
                <div class="mt-3"><button type="submit" class="btn btn-warning">{{ $editing ? 'Update' : 'Save' }}</button>@if($editing)<a href="{{ route('factory.expenses.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>@endif</div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Filter & Records</div>
        <div class="card-body">
            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="Search description" value="{{ request('search') }}"></div>
                <div class="col-md-2"><select name="category" class="form-select"><option value="all">All Categories</option><option value="Labor/Wages" {{ request('category') == 'Labor/Wages' ? 'selected' : '' }}>Labor/Wages</option><option value="Repair & Maintenance" {{ request('category') == 'Repair & Maintenance' ? 'selected' : '' }}>Repair & Maintenance</option><option value="Petrol/Fuel" {{ request('category') == 'Petrol/Fuel' ? 'selected' : '' }}>Petrol/Fuel</option><option value="Transportation" {{ request('category') == 'Transportation' ? 'selected' : '' }}>Transportation</option><option value="Utilities" {{ request('category') == 'Utilities' ? 'selected' : '' }}>Utilities</option><option value="Packaging" {{ request('category') == 'Packaging' ? 'selected' : '' }}>Packaging</option><option value="Cleaning" {{ request('category') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option><option value="Tools & Equipment" {{ request('category') == 'Tools & Equipment' ? 'selected' : '' }}>Tools & Equipment</option><option value="Stationery" {{ request('category') == 'Stationery' ? 'selected' : '' }}>Stationery</option><option value="Rent" {{ request('category') == 'Rent' ? 'selected' : '' }}>Rent</option><option value="Miscellaneous" {{ request('category') == 'Miscellaneous' ? 'selected' : '' }}>Miscellaneous</option></select></div>
                <div class="col-md-2"><select name="payment_method" class="form-select"><option value="all">All Payments</option><option value="Cash" {{ request('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option><option value="Bank Transfer" {{ request('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option><option value="Cheque" {{ request('payment_method') == 'Cheque' ? 'selected' : '' }}>Cheque</option></select></div>
                <div class="col-md-2"><input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"></div>
                <div class="col-md-2"><input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"></div>
                <div class="col-md-1"><button type="submit" class="btn btn-outline-warning w-100">Go</button></div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead><tr><th>#</th><th>Date</th><th>Category</th><th>Description</th><th>Amount</th><th>Payment Method</th><th>Reference</th><th>Notes</th><th>Actions</th></tr></thead>
                    <tbody>
                        @forelse($records as $record)
                        <tr>
                            <td>{{ $loop->iteration + ($records->currentPage()-1)*$records->perPage() }}</td>
                            <td>{{ $record->date->format('d/m/Y') }}</td>
                            <td>{{ $record->category }}</td>
                            <td>{{ $record->description }}</td>
                            <td>PKR {{ number_format($record->amount, 2) }}</td>
                            <td>{{ $record->payment_method }}</td>
                            <td>{{ $record->reference ?? '-' }}</td>
                            <td>{{ $record->notes ?? '-' }}</td>
                            <td>
                                <a href="{{ route('factory.expenses.index', ['edit_id' => $record->id]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form method="POST" action="{{ route('factory.expenses.destroy', $record->id) }}" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted py-4">No expenses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $records->links() }}</div>
        </div>
    </div>
</div>
@endsection
