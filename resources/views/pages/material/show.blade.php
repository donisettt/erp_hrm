@extends('layouts.app')
@section('title', 'Detail Material')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4 p-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">ID Material</label>
                        <input type="text" class="form-control" value="{{ $material->id_material }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Material</label>
                        <input type="text" class="form-control" value="{{ $material->nama }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Supplier</label>
                        <input type="text" class="form-control" value="{{ $material->supplier->nama ?? 'N/A' }}"
                            disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <input type="text" class="form-control" value="{{ $material->satuan }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Satuan</label>
                        <input type="text" class="form-control"
                            value="Rp {{ number_format($material->harga_satuan, 0, ',', '.') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="text" class="form-control" value="{{ $material->stok }}" disabled>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('material.index') }}" class="btn btn-primary">Kembali ke data material</a>
            </div>
        </div>
    </div>
@endsection
