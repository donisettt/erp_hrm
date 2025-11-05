@extends('layouts.app')
@section('title', 'Data Supplier')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <input type="text" class="form-control" placeholder="Cari supplier..." name="search">
                </form>
                <a href="{{ route('supplier.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah Supplier
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Supplier</th>
                            <th scope="col">Nama Supplier</th>
                            <th scope="col">No HP</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supplier as $data)
                            <tr>
                                <td><span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->id_supplier }}</span>
                                </td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->no_hp }}</td>
                                <td>{{ $data->email }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>
                                    <form action="{{ route('supplier.destroy', $data->id_supplier) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $data->id_supplier }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('supplier.edit', $data->id_supplier) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id_supplier }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data supplier belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $supplier->links() }}</div>
        </div>
    </div>
@endsection
