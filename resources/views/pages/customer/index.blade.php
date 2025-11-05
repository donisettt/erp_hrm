@extends('layouts.app')
@section('title', 'Data Customer')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <input type="text" class="form-control" placeholder="Cari customer..." name="search">
                </form>
                <a href="{{ route('customer.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah Customer
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Perusahaan</th>
                            <th scope="col">Penanggung Jawab</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customer as $data)
                            <tr>
                                <td><span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->id_customer }}</span>
                                </td>
                                <td>{{ $data->nama_perusahaan }}</td>
                                <td>{{ $data->nama_penanggung_jawab }}</td>
                                <td>{{ $data->alamat }}</td>
                                <td>
                                    <form action="{{ route('customer.destroy', $data->id_customer) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $data->id_customer }}">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('customer.show', $data->id_customer) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customer.edit', $data->id_customer) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id_customer }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data customer belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $customer->links() }}</div>
        </div>
    </div>
@endsection
