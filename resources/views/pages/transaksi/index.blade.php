@extends('layouts.app')
@section('title', 'Data Transaksi')

@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="{{ route('transaksi.store') }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <select class="form-select" style="width: 250px;" name="proyek_id" required>
                        <option value="">Pilih Proyek</option>
                        @foreach ($proyekTersedia as $p)
                            <option value="{{ $p->id_proyek }}">
                                {{ $p->nama_proyek }} ({{ $p->id_proyek }})
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary text-white">
                        Buat Transaksi
                    </button>
                </form>

                <form action="#" method="GET" style="width: 300px;">
                    <input type="text" class="form-control" placeholder="Cari transaksi..." name="search">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Invoice</th>
                            <th scope="col">Nama Proyek</th>
                            <th scope="col">Harga Borongan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksiList as $transaksi)
                            @php
                                $proyek = $transaksi->proyek;

                                $total_biaya =
                                    $transaksi->total_material + $transaksi->total_teknisi + $transaksi->total_tambahan;
                                $profit = $proyek->harga_borongan - $total_biaya;
                            @endphp
                            <tr>
                                <td><span class="badge bg-primary-subtle text-primary-emphasis">{{ $proyek->invoice }}</span></td>
                                <td>{{ $proyek->nama_proyek }}</td>
                                <td>Rp {{ number_format($proyek->harga_borongan, 0, ',', '.') }}</td>
                                <td>
                                    <small>
                                        Status: <strong>{{ $transaksi->status_transaksi }}</strong><br>
                                        Payment: <strong>{{ $transaksi->pembayaran }}</strong>
                                    </small>
                                </td>
                                <td>
                                    @if ($profit >= 0)
                                        <span class="fw-bold text-success">Rp
                                            {{ number_format($profit, 0, ',', '.') }}</span>
                                    @else
                                        <span class="fw-bold text-danger">(Rp
                                            - {{ number_format(abs($profit), 0, ',', '.') }})</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('transaksi.show', $transaksi->id) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Kelola Transaksi">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Data transaksi belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $transaksiList->links() }}</div>
        </div>
    </div>
@endsection
