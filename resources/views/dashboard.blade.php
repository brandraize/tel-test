{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .stats-card {
        padding: 20px;
        border-radius: 12px;
        color: white;
        margin-bottom: 20px;
        transition: transform 0.3s;
        cursor: pointer;
        min-height: 140px;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-card.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .stats-card.success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
    .stats-card.info { background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%); }
    .stats-card.warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
    .stats-card .opacity-50 { opacity: 0.5; }

    .badge-gress { background: #48bb78; }
    .badge-jalee { background: #4299e1; }
    .badge-bailt { background: #ed8936; }
    .badge-gonde { background: #9f7aea; }
    .badge-panjaee { background: #fc8181; }
    .badge-tagharee { background: #a0aec0; }
    .badge-saber_band { background: #68d391; }
    .badge-max_katha { background: #f6ad55; }

    .summary-box {
        background: #f7fafc;
        border-radius: 8px;
        padding: 15px;
        margin: 5px 0;
    }

    .category-tabs .nav-link {
        color: #4a5568;
        font-weight: 600;
    }
    .category-tabs .nav-link.active {
        color: #2b6cb0;
        background: #ebf8ff;
        border-color: #bee3f8;
    }

    .category-detail-table {
        font-size: 13px;
    }
    .category-detail-table th {
        background: #edf2f7;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table-hover tbody tr:hover {
        background: #f7fafc;
        cursor: pointer;
    }

    @media (max-width: 767.98px) {
        .stats-card {
            padding: 16px;
            min-height: auto;
        }

        .stats-card h3 {
            font-size: 1.1rem;
        }

        .card-header {
            font-size: 0.95rem;
        }

        .nav-tabs {
            flex-wrap: wrap;
        }

        .nav-tabs .nav-link {
            margin-bottom: 6px;
        }
    }
</style>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
            <a href="{{ route('factory.incoming.index') }}" class="btn btn-outline-primary">Incoming</a>
            <a href="{{ route('factory.outgoing.index') }}" class="btn btn-outline-success">Outgoing</a>
            <a href="{{ route('factory.expenses.index') }}" class="btn btn-outline-warning">Expenses</a>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Sales</a>
            <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary">Materials</a>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stats-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">Total Materials Cost</p>
                    <h3 class="mb-0">PKR {{ number_format($totalMaterialCost ?? 0, 2) }}</h3>
                </div>
                <i class="fas fa-boxes fa-2x opacity-50"></i>
            </div>
            <small class="text-white-50">{{ number_format($totalMaterialItems ?? 0) }} items</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stats-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">Total Sales</p>
                    <h3 class="mb-0">PKR {{ number_format($overallSales->total_sales ?? 0, 2) }}</h3>
                </div>
                <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
            </div>
            <small class="text-white-50">{{ number_format($overallSales->total_transactions ?? 0) }} transactions</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stats-card info">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">Net Profit</p>
                    <h3 class="mb-0">PKR {{ number_format($overallSales->total_profit ?? 0, 2) }}</h3>
                </div>
                <i class="fas fa-chart-line fa-2x opacity-50"></i>
            </div>
            <small class="text-white-50">Total earnings</small>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="stats-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="mb-1">Pending Amount</p>
                    <h3 class="mb-0">PKR {{ number_format($overallSales->total_baqii ?? 0, 2) }}</h3>
                </div>
                <i class="fas fa-clock fa-2x opacity-50"></i>
            </div>
            <small class="text-white-50">Unpaid balance</small>
        </div>
    </div>
</div>

<div class="row mt-4 g-3">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar me-2"></i> Sales by Category
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Sales</th>
                                <th>Profit</th>
                                <th>Collected</th>
                                <th>Pending</th>
                                <th>Transactions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($salesByCategory as $category)
                            <tr>
                                <td>
                                    <span class="badge badge-{{ $category->category }}">
                                        {{ ucfirst(str_replace('_', ' ', $category->category)) }}
                                    </span>
                                </td>
                                <td>PKR {{ number_format($category->total_sales, 2) }}</td>
                                <td>PKR {{ number_format($category->total_profit, 2) }}</td>
                                <td>PKR {{ number_format($category->total_wasool, 2) }}</td>
                                <td>
                                    @if($category->total_baqii > 0)
                                        <span class="badge bg-danger">PKR {{ number_format($category->total_baqii, 2) }}</span>
                                    @else
                                        <span class="badge bg-success">PKR 0.00</span>
                                    @endif
                                </td>
                                <td>{{ $category->count }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No sales data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock me-2"></i> Recent Transactions
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentSales ?? [] as $sale)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $sale->name }}</h6>
                                <small class="text-muted">
                                    <span class="badge badge-{{ $sale->category }}">{{ ucfirst($sale->category) }}</span>
                                    {{ $sale->date ? $sale->date->format('d/m/Y') : '' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <strong>PKR {{ number_format($sale->total_amount, 2) }}</strong>
                                <br>
                                <small class="text-muted">Profit: PKR {{ number_format($sale->net_profit, 2) }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item text-center text-muted">
                        No recent transactions
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

{{-- All Category Details with All Seeders Data --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-table me-2"></i> Complete Sales Data (All Categories)
                <span class="badge bg-primary ms-2">{{ $overallSales->total_transactions ?? 0 }} Total Records</span>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs category-tabs" id="categoryTabs" role="tablist">
                    @foreach($categoryTotals as $category => $data)
                        @if($data['count'] > 0)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $category }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#{{ $category }}"
                                        type="button"
                                        role="tab">
                                    {{ ucfirst(str_replace('_', ' ', $category)) }}
                                    <span class="badge bg-secondary">{{ $data['count'] }}</span>
                                </button>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div class="tab-content mt-3" id="categoryTabsContent">
                    @foreach($categoryTotals as $category => $data)
                        @if($data['count'] > 0)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                 id="{{ $category }}"
                                 role="tabpanel">

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap gap-3 summary-box">
                                            <div>
                                                <strong>Total:</strong>
                                                <span class="text-primary">PKR {{ number_format($data['total_amount'], 2) }}</span>
                                            </div>
                                            <div>
                                                <strong>Profit:</strong>
                                                <span class="text-success">PKR {{ number_format($data['total_profit'], 2) }}</span>
                                            </div>
                                            <div>
                                                <strong>Received:</strong>
                                                <span class="text-info">PKR {{ number_format($data['total_wasool'], 2) }}</span>
                                            </div>
                                            <div>
                                                <strong>Pending:</strong>
                                                <span class="text-danger">PKR {{ number_format($data['total_baqii'], 2) }}</span>
                                            </div>
                                            <div>
                                                <strong>Records:</strong>
                                                <span>{{ $data['count'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                                    <table class="table table-hover table-sm category-detail-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Date</th>
                                                <th>Items</th>
                                                <th class="text-end">Total</th>
                                                <th class="text-end">Profit</th>
                                                <th class="text-end">Wasool</th>
                                                <th class="text-end">Baqii</th>
                                                <th>Status</th>
                                                <th>Extra</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data['sales'] as $index => $sale)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $sale->name }}</strong></td>
                                                    <td>{{ $sale->date ? $sale->date->format('d/m/Y') : '-' }}</td>
                                                    <td class="text-center">{{ $sale->total_items ?? '-' }}</td>
                                                    <td class="text-end">PKR {{ number_format($sale->total_amount, 2) }}</td>
                                                    <td class="text-end">PKR {{ number_format($sale->net_profit, 2) }}</td>
                                                    <td class="text-end">PKR {{ number_format($sale->wasool, 2) }}</td>
                                                    <td class="text-end">
                                                        @if($sale->baqii > 0)
                                                            <strong class="text-danger">PKR {{ number_format($sale->baqii, 2) }}</strong>
                                                        @else
                                                            <span class="text-muted">PKR 0.00</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($sale->isFullyPaid())
                                                            <span class="badge bg-success">✅ Paid</span>
                                                        @elseif($sale->wasool > 0)
                                                            <span class="badge bg-warning text-dark">⚠️ Partial</span>
                                                        @else
                                                            <span class="badge bg-danger">❌ Pending</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($sale->extra_fields)
                                                            @foreach($sale->extra_fields as $key => $value)
                                                                <span class="badge bg-light text-dark me-1">
                                                                    {{ $key }}: {{ $value }}
                                                                </span>
                                                            @endforeach
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Top Customers --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy me-2"></i> Top Customers
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th class="text-end">Total Purchases</th>
                                <th class="text-end">Total Profit</th>
                                <th class="text-end">Total Paid</th>
                                <th class="text-end">Pending</th>
                                <th class="text-center">Transactions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCustomers ?? [] as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $customer->name }}</strong></td>
                                    <td class="text-end">PKR {{ number_format($customer->total_amount, 2) }}</td>
                                    <td class="text-end">PKR {{ number_format($customer->total_profit, 2) }}</td>
                                    <td class="text-end">PKR {{ number_format($customer->total_wasool, 2) }}</td>
                                    <td class="text-end">
                                        @php $pending = $customer->total_amount - $customer->total_wasool; @endphp
                                        @if($pending > 0)
                                            <span class="text-danger">PKR {{ number_format($pending, 2) }}</span>
                                        @else
                                            <span class="text-success">PKR 0.00</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $customer->transaction_count }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No customer data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Summary --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calculator me-2"></i> Quick Summary
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <h4>PKR {{ number_format($totalMaterialCost ?? 0, 2) }}</h4>
                        <p class="text-muted">Total Investment</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4>PKR {{ number_format($overallSales->total_sales ?? 0, 2) }}</h4>
                        <p class="text-muted">Total Revenue</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4 class="text-success">PKR {{ number_format($overallSales->total_profit ?? 0, 2) }}</h4>
                        <p class="text-muted">Total Profit</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <h4 class="text-danger">PKR {{ number_format($overallSales->total_baqii ?? 0, 2) }}</h4>
                        <p class="text-muted">Pending Amount</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
