@extends('layouts.app')
@section('title', 'Detail Customer')
@section('content')

    <div class="card shadow-sm border-0" style="border-radius: 1rem">
        <div class="card-body p-4 p-md-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">ID Customer</label>
                        <input type="text" class="form-control" value="{{ $customer->id_customer }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" value="{{ $customer->nama_perusahaan }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control" value="{{ $customer->nama_penanggung_jawab }}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No Handphone</label>
                        <input type="text" class="form-control" value="{{ $customer->no_hp }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ $customer->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" rows="2" disabled>{{ $customer->alamat }}</textarea>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-4">
                <a href="{{ route('customer.index') }}" class="btn btn-primary">Kembali ke data customer</a>
            </div>
        </div>
    </div>
@endsection
