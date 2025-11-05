@extends('layouts.app')
@section('title', 'Edit SPBU')
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

            <form action="{{ route('spbu.update', $spbu->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_spbu" class="form-label">No SPBU</label>
                            <input type="text" class="form-control" id="no_spbu" name="no_spbu"
                                value="{{ old('no_spbu', $spbu->no_spbu) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                            <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi"
                                value="{{ old('nama_lokasi', $spbu->nama_lokasi) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="manajer" class="form-label">Manajer / Penanggung Jawab</label>
                            <input type="text" class="form-control" id="manajer" name="manajer"
                                value="{{ old('manajer', $spbu->manajer) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No Handphone</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ old('no_hp', $spbu->no_hp) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer (Perusahaan Induk)</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">Pilih Perusahaan...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id_customer }}"
                                        {{ old('customer_id', $spbu->customer_id) == $customer->id_customer ? 'selected' : '' }}>
                                        {{ $customer->nama_perusahaan }} ({{ $customer->id_customer }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jam_operasional" class="form-label">Jam Operasional</label>
                            <input type="text" class="form-control" id="jam_operasional" name="jam_operasional"
                                value="{{ old('jam_operasional', $spbu->jam_operasional) }}"
                                placeholder="Contoh: 07:00 - 22:00">
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat SPBU</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $spbu->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('spbu.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
