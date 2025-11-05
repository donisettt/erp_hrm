@extends('layouts.app')
@section('title', 'Tambah Proyek')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('proyek.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_proyek" class="form-label">ID Proyek</label>
                            <input type="text" class="form-control" id="id_proyek" value="(Pilih Perusahaan)" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Perusahaan (Customer)</label>
                            <select class="form-select" id="customer_id" name="customer_id" required>
                                <option value="">Pilih Perusahaan...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id_customer }}"
                                        {{ old('customer_id') == $customer->id_customer ? 'selected' : '' }}>
                                        {{ $customer->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="spbu_id" class="form-label">SPBU</label>
                            <select class="form-select" id="spbu_id" name="spbu_id" required {{ old('customer_id') ? '' : 'disabled' }}>

                                <option value="">
                                    {{ old('customer_id') ? 'Pilih SPBU...' : 'Pilih Perusahaan.' }}</option>

                                @foreach ($spbus as $spbu)
                                    <option value="{{ $spbu->id }}" {{ old('spbu_id') == $spbu->id ? 'selected' : '' }}>
                                        {{ $spbu->no_spbu }} - {{ $spbu->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_proyek" class="form-label">Nama Proyek</label>
                            <input type="text" class="form-control" id="nama_proyek" name="nama_proyek"
                                value="{{ old('nama_proyek') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_borongan" class="form-label">Harga Borongan (Rp)</label>
                            <input type="number" class="form-control" id="harga_borongan" name="harga_borongan"
                                value="{{ old('harga_borongan', 0) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                value="{{ old('tanggal_selesai') }}" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('proyek.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const customerSelect = document.getElementById('customer_id');
        const proyekIdInput = document.getElementById('id_proyek');
        const spbuSelect = document.getElementById('spbu_id');

        customerSelect.addEventListener('change', function() {
            const customerId = this.value;

            if (customerId) {
                proyekIdInput.value = 'Memuat...';
                fetch(`{{ route('proyek.getNextId') }}?customer_id=${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        proyekIdInput.value = data.nextId;
                    })
                    .catch(error => {
                        console.error('Error fetching next ID:', error);
                        proyekIdInput.value = 'Error!';
                    });

                spbuSelect.disabled = true;
                spbuSelect.innerHTML = '<option value="">Memuat SPBU...</option>';

                fetch(`{{ route('proyek.getSpbuByCustomer') }}?customer_id=${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        spbuSelect.disabled = false;
                        spbuSelect.innerHTML = '<option value="">Pilih SPBU...</option>';

                        data.forEach(function(spbu) {
                            const option = document.createElement('option');
                            option.value = spbu.id;
                            option.textContent = `${spbu.no_spbu} - ${spbu.nama_lokasi}`;
                            spbuSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching SPBU:', error);
                        spbuSelect.innerHTML = '<option value="">Gagal memuat SPBU</option>';
                    });

            } else {
                proyekIdInput.value = '(Pilih Perusahaan)';
                spbuSelect.disabled = true;
                spbuSelect.innerHTML = '<option value="">Pilih Perusahaan Dulu...</option>';
            }
        });
    });
</script>
@endpush
