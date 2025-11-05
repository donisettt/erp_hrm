@extends('layouts.app')
@section('title', 'Detail SPBU')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4 p-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No SPBU</label>
                        <input type="text" class="form-control" value="{{ $spbu->no_spbu }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer (Perusahaan Induk)</label>
                        <input type="text" class="form-control" value="{{ $spbu->customer->nama_perusahaan ?? 'N/A' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lokasi</label>
                        <input type="text" class="form-control" value="{{ $spbu->nama_lokasi }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Manajer / Penanggung Jawab</label>
                        <input type="text" class="form-control" value="{{ $spbu->manajer }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No Handphone</label>
                        <input type="text" class="form-control" value="{{ $spbu->no_hp }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam Operasional</label>
                        <input type="text" class="form-control" value="{{ $spbu->jam_operasional }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat SPBU</label>
                        <textarea class="form-control" rows="3" disabled>{{ $spbu->alamat }}</textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('spbu.index') }}" class="btn btn-primary">Kembali ke data SPBU</a>
            </div>
        </div>
    </div>
@endsection
