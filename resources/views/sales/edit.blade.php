{{-- resources/views/sales/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit {{ ucfirst($sale->category) }} Sale</h4>
        <p class="text-muted mb-0">Update transaction details for {{ $sale->name }}.</p>
    </div>
    <a href="{{ route('sales.index', ['category' => $sale->category]) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to {{ ucfirst($sale->category) }} Sales
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('sales.update', $sale) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Customer / Project Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $sale->name) }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter customer or project name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $sale->date?->format('Y-m-d')) }}"
                           class="form-control @error('date') is-invalid @enderror">
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="total_items" class="form-label">Total Items</label>
                    <input type="number" id="total_items" name="total_items" value="{{ old('total_items', $sale->total_items) }}"
                           class="form-control @error('total_items') is-invalid @enderror"
                           min="0" step="0.01" placeholder="0">
                    @error('total_items')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="total_amount" class="form-label">Total Amount <span class="text-danger">*</span></label>
                    <input type="number" id="total_amount" name="total_amount" value="{{ old('total_amount', $sale->total_amount) }}"
                           class="form-control @error('total_amount') is-invalid @enderror"
                           min="0" step="0.01" placeholder="0.00" required>
                    @error('total_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="net_profit" class="form-label">Net Profit <span class="text-danger">*</span></label>
                    <input type="number" id="net_profit" name="net_profit" value="{{ old('net_profit', $sale->net_profit) }}"
                           class="form-control @error('net_profit') is-invalid @enderror"
                           min="0" step="0.01" placeholder="0.00" required>
                    @error('net_profit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="wasool" class="form-label">Collected Amount</label>
                    <input type="number" id="wasool" name="wasool" value="{{ old('wasool', $sale->wasool) }}"
                           class="form-control @error('wasool') is-invalid @enderror"
                           min="0" step="0.01" placeholder="0.00">
                    @error('wasool')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              class="form-control" placeholder="Optional notes or details">{{ old('notes', $sale->extra_fields['notes'] ?? '') }}</textarea>
                </div>
            </div>

            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Pending Amount:</strong> PKR {{ number_format($sale->baqii, 2) }}
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('sales.index', ['category' => $sale->category]) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Sale
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
