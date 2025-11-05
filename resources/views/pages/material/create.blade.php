@extends('layouts.app')
@section('title', 'Tambah Material')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('material.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_material" class="form-label">ID Material</label>
                            <input type="text" class="form-control" value="{{ $nextId }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Material</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select class="form-select" id="supplier_id" name="supplier_id" required>
                                <option value="">Pilih Supplier...</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id_supplier }}"
                                        {{ old('supplier_id') == $supplier->id_supplier ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan"
                                value="{{ old('satuan') }}" placeholder="Contoh: Pcs, Unit, Box" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_satuan" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan"
                                value="{{ old('harga_satuan', 0) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Awal</label>
                            <input type="number" class="form-control" id="stok" name="stok"
                                value="{{ old('stok', 0) }}" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('material.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
