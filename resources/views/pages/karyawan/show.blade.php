@extends('layouts.app')
@section('title', 'Detail Karyawan')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4 p-md-5">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_karyawan" class="form-label">ID Karyawan</label>
                        <input type="text" class="form-control" value="{{ $karyawan->id_karyawan }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="no_ktp" class="form-label">No KTP</label>
                        <input type="text" class="form-control" value="{{ $karyawan->no_ktp }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" value="{{ $karyawan->nama }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <input type="text" class="form-control"
                            value="{{ $karyawan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" value="{{ $karyawan->jabatan }}" disabled>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No Handphone</label>
                        <input type="text" class="form-control" value="{{ $karyawan->no_hp }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $karyawan->email }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" value="{{ $karyawan->alamat }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="upah_harian" class="form-label">Upah Harian</label>
                        <input type="text" class="form-control"
                            value="Rp {{ number_format($karyawan->upah_harian, 0, ',', '.') }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control"
                            value="{{ $karyawan->status == 'aktif' ? 'Aktif' : 'Non-Aktif' }}" disabled>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('karyawan.index') }}" class="btn btn-primary">Kembali ke data karyawan</a>
            </div>

        </div>
    </div>
@endsection
