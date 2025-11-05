@extends('layouts.app')
@section('title', 'Data Proyek')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <input type="text" class="form-control" placeholder="Cari proyek..." name="search">
                </form>
                <a href="{{ route('proyek.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah Proyek
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Proyek</th>
                            <th scope="col">Perusahaan</th>
                            <th scope="col">SPBU</th>
                            <th scope="col">Nama Proyek</th>
                            <th scope="col">Harga Borongan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proyek as $data)
                            <tr>
                                <td><span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->id_proyek }}</span>
                                </td>
                                <td>{{ $data->customer->nama_perusahaan ?? 'N/A' }}</td>
                                <td>{{ $data->spbu->no_spbu ?? 'N/A' }}</td>
                                <td>{{ $data->nama_proyek }}</td>
                                <td>Rp {{ number_format($data->harga_borongan, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('proyek.destroy', $data->id_proyek) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $data->id_proyek }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('proyek.show', $data->id_proyek) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('proyek.edit', $data->id_proyek) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id_proyek }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data proyek belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $proyek->links() }}</div>
        </div>
    </div>
@endsection
