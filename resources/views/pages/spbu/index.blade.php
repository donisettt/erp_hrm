@extends('layouts.app')
@section('title', 'Data SPBU')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <input type="text" class="form-control" placeholder="Cari SPBU..." name="search">
                </form>
                <a href="{{ route('spbu.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah SPBU
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No SPBU</th>
                            <th scope="col">Customer (Perusahaan)</th>
                            <th scope="col">Nama Lokasi</th>
                            <th scope="col">Manajer</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($spbu as $data)
                            <tr>
                                <td><span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->no_spbu }}</span></td>
                                <td>{{ $data->customer->nama_perusahaan ?? 'N/A' }}</td>
                                <td>{{ $data->nama_lokasi }}</td>
                                <td>{{ $data->manajer }}</td>
                                <td>{{ $data->no_hp }}</td>
                                <td>
                                    <form action="{{ route('spbu.destroy', $data->id) }}" method="POST" class="d-inline"
                                        id="delete-form-{{ $data->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('spbu.show', $data->id) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('spbu.edit', $data->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data SPBU belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $spbu->links() }}</div>
        </div>
    </div>
@endsection
