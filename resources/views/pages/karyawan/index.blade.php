@extends('layouts.app')
@section('title', 'Data Karyawan')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <form action="#" method="GET" class="w-50">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari karyawan..." name="search">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <a href="{{ route('karyawan.create') }}" class="btn btn-primary text-white" style="border-radius: 0.5rem">
                    <i class="fas fa-plus me-2"></i>Tambah Karyawan
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID Karyawan</th>
                            <th scope="col">Nama Karyawan</th>
                            <th scope="col">Jabatan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($karyawan as $data)
                            <tr>
                                <td>
                                    <span
                                        class="badge bg-primary-subtle text-primary-emphasis">{{ $data->id_karyawan }}</span>
                                </td>
                                <td>{{ $data->nama }}</td>
                                <td>{{ $data->jabatan }}</td>
                                <td>
                                    @if ($data->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('karyawan.show', $data->id_karyawan) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('karyawan.edit', $data->id_karyawan) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $data->id_karyawan) }}" method="POST"
                                        class="d-inline" id="delete-form-{{ $data->id_karyawan }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDelete('{{ $data->id_karyawan }}')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data karyawan belum tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $karyawan->links() }}
            </div>

        </div>
    </div>

@endsection
