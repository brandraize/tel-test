{{-- resources/views/sales/pending_monthly.blade.php --}}
@extends('layouts.app')

@section('title', 'Monthly Pending Amounts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Monthly Pending Amounts</h4>
        <p class="text-muted mb-0">See all pending sales for the selected month with customer names and outstanding balances.</p>
    </div>
    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('sales.pending.monthly') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="month" class="form-label">Month</label>
                <select id="month" name="month" class="form-select">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label">Year</label>
                <select id="year" name="year" class="form-select">
                    @foreach(range(now()->year - 2, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stats-card warning">
            <h6>Total Pending</h6>
            <h3>PKR {{ number_format($totalPending, 2) }}</h3>
            <p class="mb-0 text-white-50">Total unpaid balance for {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}.</p>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Pending Amounts by Category</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Pending</th>
                                <th>Records</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingByCategory as $category => $entries)
                                <tr>
                                    <td>{{ ucfirst(str_replace('_', ' ', $category)) }}</td>
                                    <td>PKR {{ number_format($entries->sum('baqii'), 2) }}</td>
                                    <td>{{ $entries->count() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No pending sales for this month.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Pending Sales Details</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Collected</th>
                        <th>Pending</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingSales as $sale)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sale->name }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $sale->category)) }}</td>
                            <td>{{ $sale->date ? $sale->date->format('d/m/Y') : '—' }}</td>
                            <td>PKR {{ number_format($sale->total_amount, 2) }}</td>
                            <td>PKR {{ number_format($sale->wasool, 2) }}</td>
                            <td>PKR {{ number_format($sale->baqii, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">No pending sales found for the selected month.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
