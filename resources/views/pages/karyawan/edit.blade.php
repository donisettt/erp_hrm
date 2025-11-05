@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('content')

<div class="card shadow-sm border-0" style="border-radius: 1rem">
    <div class="card-body p-4">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5 class="alert-heading">Validasi Gagal!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_karyawan" class="form-label">ID Karyawan</label>
                        <input type="text" class="form-control" id="id_karyawan" 
                               value="{{ $karyawan->id_karyawan }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" class="form-control" id="no_ktp" name="no_ktp" 
                               value="{{ old('no_ktp', $karyawan->no_ktp) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama', $karyawan->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" 
                               value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No Handphone</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" 
                               value="{{ old('no_hp', $karyawan->no_hp) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $karyawan->email) }}">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" 
                               value="{{ old('alamat', $karyawan->alamat) }}">
                    </div>

                    <div class="mb-3">
                        <label for="upah_harian" class="form-label">Upah Harian</label>
                        <input type="number" class="form-control" id="upah_harian" name="upah_harian" 
                               value="{{ old('upah_harian', $karyawan->upah_harian) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" {{ old('status', $karyawan->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ old('status', $karyawan->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</Batal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('karyawan.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>

    </div>
</div>
@endsection