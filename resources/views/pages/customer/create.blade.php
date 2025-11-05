@extends('layouts.app')
@section('title', 'Tambah Customer')
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

            <form action="{{ route('customer.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_customer" class="form-label">ID Customer</label>
                            <input type="text" class="form-control" value="{{ $nextId }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                value="{{ old('nama_perusahaan') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_penanggung_jawab" class="form-label">Nama Penanggung Jawab</label>
                            <input type="text" class="form-control" id="nama_penanggung_jawab"
                                name="nama_penanggung_jawab" value="{{ old('nama_penanggung_jawab') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Handphone</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
