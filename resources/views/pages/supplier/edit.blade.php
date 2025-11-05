@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')

    <a href="{{ route('supplier.index') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-arrow-left me-2"></i> Kembali
    </a>
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

            <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_supplier" class="form-label">ID Supplier</label>
                            <input type="text" class="form-control" value="{{ $supplier->id_supplier }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                value="{{ old('nama', $supplier->nama) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Handphone</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $supplier->no_hp) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $supplier->email) }}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="4">{{ old('alamat', $supplier->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
