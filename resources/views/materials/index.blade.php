{{-- resources/views/materials/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Materials Inventory')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="fas fa-box me-2"></i>Materials Inventory</h4>
    <a href="{{ route('materials.create') }}" class="btn btn-primary">
        <i class="fas fa-plus-circle me-1"></i> Add Material
    </a>
</div>

<!-- Stats Cards -->
<div class="row">
    <div class="col-md-4">
        <div class="stats-card primary">
            <h5>Total Items</h5>
            <h3>{{ number_format($totalItems) }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card success">
            <h5>Total Cost</h5>
            <h3>PKR {{ number_format($totalCost, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stats-card info">
            <h5>Total Entries</h5>
            <h3>{{ number_format($count) }}</h3>
        </div>
    </div>
</div>

<!-- Materials Table -->
<div class="table-container">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total Cost</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materials as $material)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $material->item_name }}</td>
                    <td>{{ $material->description ?? '-' }}</td>
                    <td>{{ $material->no_of_items }}</td>
<td>PKR {{ number_format($material->price, 2) }}</td>
                    <td><strong>PKR {{ number_format($material->total_cost, 2) }}</strong></td>
                    <td>{{ $material->date ? $material->date->format('d/m/Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('materials.edit', $material) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No materials found</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-primary">
                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                    <td><strong>PKR {{ number_format($totalCost, 2) }}</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
