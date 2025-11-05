@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-10">
            <div class="card border-0 shadow-sm" style="border-radius: 1rem">
                <div class="card-body p-4 p-md-5">
                    <div class="row">

                        <div class="col-md-8 d-flex flex-column justify-content-center">
                            <h4 class="fw-bold text-primary mb-2">Selamat Datang, {{ Auth::user()->nama }}!</h4>
                            <p class="text-muted mb-0">
                                Semangat untuk hari ini, jangan lupa istirahat yang cukup!
                            </p>
                        </div>

                        <div class="col-md-4 text-center d-none d-md-block d-flex flex-column justify-content-end">
                            <img src="{{ asset('images/dashboard-logo.png') }}" alt="Ilustrasi Dashboard" class="img-fluid"
                                style="max-width: 100px;">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
