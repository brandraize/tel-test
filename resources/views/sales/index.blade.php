{{-- resources/views/sales/index.blade.php --}}
@extends('layouts.app')

@section('title', ucfirst(str_replace('_', ' ', $category)) . ' Sales')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
    <div>
        <h4 class="mb-1"><i class="fas fa-shopping-cart me-2"></i>{{ ucfirst(str_replace('_', ' ', $category)) }} Sales</h4>
        <p class="text-muted mb-0">Track sales, profit, and pending amounts for this category.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('sales.create', ['category' => $category]) }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Add Sale
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
        </a>
    </div>
</div>

<div class="mb-4">
    <div class="btn-group" role="group" aria-label="Sales categories">
            @foreach(['gress','jalee','bailt','gonde','panjaee','tagharee','saber_band','max_katha'] as $salesCategory)
            </a>
        @endforeach
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stats-card primary">
            <h6>Total Sales</h6>
            <h3>PKR {{ number_format($summary['total_amount'] ?? 0, 2) }}</h3>
            <p class="mb-0 text-white-50">Total revenue for this category.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card success">
            <h6>Total Profit</h6>
            <h3>PKR {{ number_format($summary['total_profit'] ?? 0, 2) }}</h3>
            <p class="mb-0 text-white-50">Net profit across recorded sales.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card info">
            <h6>Collected</h6>
            <h3>PKR {{ number_format($summary['total_wasool'] ?? 0, 2) }}</h3>
            <p class="mb-0 text-white-50">Amount collected from custome$.</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card warning">
            <h6>Pending</h6>
            <h3>PKR {{ number_format($summary['total_baqii'] ?? 0, 2) }}</h3>
            <p class="mb-0 text-white-50">Outstanding balance due.</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="table-container shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-0">Sales Transactions</h5>
                    <small class="text-muted">Latest {{ ucfirst(str_replace('_', ' ', $category)) }} sales.</small>
                </div>
                <span class="badge bg-secondary py-2 px-3">{{ number_format($sales->count()) }} records</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Profit</th>
                            <th>Collected</th>
                            <th>Pending</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sale->name }}</td>
                                <td>{{ $sale->date ? $sale->date->format('d/m/Y') : '—' }}</td>
                                <td>{{ $sale->total_items ?? '—' }}</td>
                                <td>PKR {{ number_format($sale->total_amount, 2) }}</td>
                                <td>PKR {{ number_format($sale->net_profit, 2) }}</td>
                                <td>PKR {{ number_format($sale->wasool, 2) }}</td>
                                <td>
                                    @if($sale->baqii > 0)
                                        <span class="badge bg-danger">PKR {{ number_format($sale->baqii, 2) }}</span>
                                    @else
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-outline-warning me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this sale?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div>
                                        <h6 class="mb-1">No sales found.</h6>
                                        <p class="text-muted mb-0">Add a new {{ ucfirst(str_replace('_', ' ', $category)) }} sale to begin tracking.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Category Summary</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Total Revenue</span>
                        <strong>PKR {{ number_format($summary['total_amount'] ?? 0, 2) }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Collected</span>
                        <strong>PKR {{ number_format($summary['total_wasool'] ?? 0, 2) }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $summary['total_amount'] > 0 ? min(100, ($summary['total_wasool'] / max(1, $summary['total_amount'])) * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Pending</span>
                        <strong>PKR {{ number_format($summary['total_baqii'] ?? 0, 2) }}</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $summary['total_amount'] > 0 ? min(100, ($summary['total_baqii'] / max(1, $summary['total_amount'])) * 100) : 0 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Transactions</span>
                        <strong>{{ number_format($summary['count'] ?? 0) }}</strong>
                    </div>
                    <p class="text-muted small mb-0">Keep the dashboard updated by adding each new sale.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
