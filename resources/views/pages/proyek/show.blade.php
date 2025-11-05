@extends('layouts.app')
@section('title', 'Detail Proyek')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4 p-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">ID Proyek</label>
                        <input type="text" class="form-control" value="{{ $proyek->id_proyek }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Invoice</label>
                        <input type="text" class="form-control" value="{{ $proyek->invoice }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Perusahaan (Customer)</label>
                        <input type="text" class="form-control" value="{{ $proyek->customer->nama_perusahaan ?? 'N/A' }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SPBU</label>
                        <input type="text" class="form-control"
                            value="{{ $proyek->spbu->no_spbu ?? 'N/A' }} - {{ $proyek->spbu->nama_lokasi ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Proyek</label>
                        <input type="text" class="form-control" value="{{ $proyek->nama_proyek }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga Borongan</label>
                        <input type="text" class="form-control"
                            value="Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="text" class="form-control" value="{{ $proyek->tanggal_mulai->format('d F Y') }}"
                            disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" value="{{ $proyek->tanggal_selesai->format('d F Y') }}"
                            disabled>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                
                <div>
                    <a href="{{ route('proyek.index') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke data proyek
                    </a>
                </div>
                
                <div>
                    <a href="{{ route('proyek.printPdf', $proyek->id_proyek) }}" class="btn btn-outline-success" target="_blank">
                        <i class="fas fa-print me-2"></i>Cetak Struk
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection