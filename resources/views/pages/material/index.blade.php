@extends('layouts.app')
@section('title', 'Data Material')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <input type="text" class="form-control" placeholder="Cari material..." name="search">
                </form>
                <a href="{{ route('material.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah Material
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Material</th>
                            <th scope="col">Nama Material</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Satuan</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($material as $data)
                            <tr>
                                <td><span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->id_material }}</span>
                                </td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->supplier->nama ?? 'N/A' }}</td>
                                <td>{{ $data->satuan }}</td>
                                <td>Rp {{ number_format($data->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $data->stok }}</td>
                                <td>
                                    <form action="{{ route('material.destroy', $data->id_material) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $data->id_material }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('material.show', $data->id_material) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('material.edit', $data->id_material) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id_material }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data material belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $material->links() }}</div>
        </div>
    </div>
@endsection
