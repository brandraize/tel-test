{{-- resources/views/materials/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i> Edit Material
            </div>
            <div class="card-body">
                <form action="{{ route('materials.update', $material) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('item_name') is-invalid @enderror"
                               id="item_name" name="item_name" value="{{ old('item_name', $material->item_name) }}" required>
                        @error('item_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="2">{{ old('description', $material->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_of_items" class="form-label">Number of Items <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('no_of_items') is-invalid @enderror"
                                       id="no_of_items" name="no_of_items" value="{{ old('no_of_items', $material->no_of_items) }}" required>
                                @error('no_of_items')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price per Item <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                       id="price" name="price" value="{{ old('price', $material->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                               id="date" name="date" value="{{ old('date', optional($material->date)->format('Y-m-d')) }}">
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('materials.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
