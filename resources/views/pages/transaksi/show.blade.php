@extends('layouts.app')
@section('title', 'Kelola Transaksi: ' . $transaksi->proyek->id_proyek)

@push('styles')
<style>
    .info-grid { display: grid; grid-template-columns: 150px 1fr; gap: 0.5rem 1rem; }
    .info-grid dt { font-weight: 600; }
    .info-grid dd { margin-bottom: 0; }
    .total-row { border-top: 2px solid #eee; font-weight: bold; }

    /* [PERBAIKAN 1] Tambahkan 3 class ini */
    .table-detail {
        font-size: 0.8rem; /* <-- Ini akan mengecilkan tulisan */
        vertical-align: middle;
    }
    .table-detail tfoot td {
        font-size: 0.8rem; /* Sedikit lebih besar untuk Total */
    }
    .table-detail .btn-xs {
        font-size: 0.7rem;
        padding: 0.1rem 0.25rem;
    }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <h5 class="alert-heading">Validasi Gagal!</h5>
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<div class="card shadow-sm border-0" style="border-radius: 1rem">
<div class="card-body p-4 p-md-5">

    @php $proyek = $transaksi->proyek; @endphp
    <div class="row mb-4">
        <div class="col-md-6">
            <dl class="info-grid">
                <dt>ID Proyek</dt>
                <dd>{{ $proyek->id_proyek }}</dd>
                <dt>Invoice</dt>
                <dd>{{ $proyek->invoice }}</dd>
                <dt>Perusahaan</dt>
                <dd>{{ $proyek->customer->nama_perusahaan ?? 'N/A' }}</dd>
                <dt>SPBU</dt>
                <dd>{{ $proyek->spbu->no_spbu ?? 'N/A' }} ({{ $proyek->spbu->nama_lokasi ?? '' }})</dd>
            </dl>
        </div>
        <div class="col-md-6">
             <dl class="info-grid">
                <dt>Tanggal Mulai</dt>
                <dd>{{ $proyek->tanggal_mulai->format('d F Y') }}</dd>
                <dt>Tanggal Selesai</dt>
                <dd>{{ $proyek->tanggal_selesai->format('d F Y') }}</dd>
                <dt>Harga Borongan</dt>
                <dd><span class="fw-bold text-success">Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}</span></dd>
            </dl>
        </div>
    </div>

    <hr class="my-4">

    <div class="row g-4">
        
        <div class="col-lg-4">
            <h5 class="fw-bold">Kebutuhan Material</h5>
            <form action="{{ route('transaksi.addMaterial', $transaksi->id) }}" method="POST" class="d-flex gap-2 mb-3">
                @csrf
                <select name="material_id" class="form-select form-select-sm" required>
                    <option value="">Pilih Material</option>
                    @foreach($all_materials as $mat)
                    <option value="{{ $mat->id_material }}">{{ $mat->nama }} (Stok: {{ $mat->stok }})</option>
                    @endforeach
                </select>
                <input type="number" name="qty" class="form-control form-control-sm" placeholder="Qty" style="width: 60px;" required>
                <button type="submit" class="btn btn-primary btn-sm">+</button>
            </form>
            
            <table class="table table-sm table-detail">
                <tbody>
                    @php $total_material = 0; @endphp
                    @forelse($transaksi->detailMaterials as $item)
                    <tr>
                        <td>{{ $item->material->nama ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0) }} x {{ $item->qty }}</td>
                        <td class="text-end">
                            <form action="{{ route('transaksi.removeMaterial', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger btn-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @php $total_material += $item->harga_satuan * $item->qty; @endphp
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada material</td></tr>
                    @endforelse
                </tbody>
                <tfoot class="total-row">
                    <tr>
                        <td colspan="2">Total Material</td>
                        <td class="text-end">{{ number_format($total_material, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-lg-4">
            <h5 class="fw-bold">Teknisi Lapangan</h5>
            <form action="{{ route('transaksi.addKaryawan', $transaksi->id) }}" method="POST" class="d-flex gap-2 mb-3">
                @csrf
                <select name="karyawan_id" class="form-select form-select-sm" required>
                    <option value="">Pilih Teknisi</option>
                    @foreach($all_karyawan as $k)
                    <option value="{{ $k->id_karyawan }}">{{ $k->nama }}</option>
                    @endforeach
                </select>
                <input type="number" name="qty_hari" class="form-control form-control-sm" value="1" style="width: 60px;" required>
                <button type="submit" class="btn btn-primary btn-sm">+</button>
            </form>
            
            <table class="table table-sm table-detail">
                <tbody>
                    @php $total_karyawan = 0; @endphp
                    @forelse($transaksi->detailTeknisi as $item)
                    <tr>
                        <td>{{ $item->karyawan->nama ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($item->upah_satuan, 0) }} x {{ $item->qty_hari }}</td>
                        <td class="text-end">
                             <form action="{{ route('transaksi.removeKaryawan', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger btn-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                     @php $total_karyawan += $item->upah_satuan * $item->qty_hari; @endphp
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada teknisi</td></tr>
                    @endforelse
                </tbody>
                <tfoot class="total-row">
                    <tr>
                        <td colspan="2">Total Upah Tukang</td>
                        <td class="text-end">{{ number_format($total_karyawan, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-lg-4">
            <h5 class="fw-bold">Pengeluaran Tambahan</h5>
            <form action="{{ route('transaksi.addPengeluaran', $transaksi->id) }}" method="POST" class="d-flex gap-2 mb-3">
                @csrf
                <input type="text" name="nama_pengeluaran" class="form-control form-control-sm" placeholder="Nama" required>
                <input type="number" name="qty" class="form-control form-control-sm" value="1" style="width: 50px;" required>
                <input type="number" name="harga_satuan" class="form-control form-control-sm" placeholder="Harga" style="width: 80px;" required>
                <button type="submit" class="btn btn-primary btn-sm">+</button>
            </form>
            
            <table class="table table-sm table-detail">
                <tbody>
                    @php $total_tambahan = 0; @endphp
                    @forelse($transaksi->detailTambahan as $item)
                    <tr>
                        <td>{{ $item->nama_pengeluaran }}</td>
                        <td>Rp {{ number_format($item->harga_satuan, 0) }} x {{ $item->qty }}</td>
                        <td class="text-end">
                            <form action="{{ route('transaksi.removePengeluaran', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-outline-danger btn-xs"><i class="fas fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @php $total_tambahan += $item->harga_satuan * $item->qty; @endphp
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">Belum ada pengeluaran</td></tr>
                    @endforelse
                </tbody>
                <tfoot class="total-row">
                    <tr>
                        <td colspan="2">Total Tambahan</td>
                        <td class="text-end">{{ number_format($total_tambahan, 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <hr class="my-4">

    <form action="{{ route('transaksi.updateStatus', $transaksi->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row align-items-end">
            <div class="col-md-3">
                <label for="pembayaran" class="form-label fw-bold">Pembayaran</label>
                <select name="pembayaran" class="form-select">
                    <option value="Belum Bayar" {{ $transaksi->pembayaran == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="DP" {{ $transaksi->pembayaran == 'DP' ? 'selected' : '' }}>DP 50%</option>
                    <option value="Lunas" {{ $transaksi->pembayaran == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="status_transaksi" class="form-label fw-bold">Status</label>
                 <select name="status_transaksi" class="form-select">
                    <option value="Diproses" {{ $transaksi->status_transaksi == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ $transaksi->status_transaksi == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ $transaksi->status_transaksi == 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            
            @php
                $total_semua = $total_material + $total_karyawan + $total_tambahan;
            @endphp
            <div class="col-md-3">
                <label for="jumlah_uang" class="form-label fw-bold">Total Pengeluaran</label>
                <input type="text" class="form-control" value="Rp {{ number_format($total_semua, 0) }}" disabled>
            </div>

            <div class="col-md-3 d-flex justify-content-end">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
    
</div>
</div>
@endsection