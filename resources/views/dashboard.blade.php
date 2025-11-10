@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
    <style>
        .kpi-card {
            background-color: #fff;
            border: 1px solid var(--bs-border-color-translucent, rgba(0, 0, 0, 0.1));
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }

        .kpi-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .kpi-card .card-body {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .kpi-card .icon-wrapper {
            font-size: 1.2rem;
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi-card .info p {
            margin-bottom: 0;
            color: #6c757d;
            font-size: 0.8rem;
            white-space: nowrap;
        }

        .kpi-card .info h3 {
            margin-bottom: 0;
            font-weight: 700;
            color: #212529;
            font-size: 1.10rem;
            white-space: nowrap;
            display: flex;
            align-items: baseline;
        }

        .kpi-card .info h3 .currency {
            font-weight: 500;
            font-size: 0.8rem;
            vertical-align: middle;
            margin-right: 4px;
        }

        .kpi-card .info .profit {
            color: #198754;
        }

        .kpi-card .info .loss {
            color: #dc3545;
        }

        .icon-primary {
            background-color: #eef0ff;
            color: #4a55c7;
        }

        .icon-success {
            background-color: #e8f3ee;
            color: #198754;
        }

        .icon-info {
            background-color: #e8f7fa;
            color: #0dcaf0;
        }

        .icon-warning {
            background-color: #fff8e6;
            color: #ffc107;
        }

        .list-proyek.list-group {
            font-size: 0.9rem;
        }

        .list-proyek.list-group .list-group-item {
            border-left: none;
            border-right: none;
            border-bottom: none;
            border-top: 1px solid #eee;
            padding-left: 0;
            padding-right: 0;
        }

        .list-proyek.list-group .list-group-item:first-child {
            border-top: none !important;
        }

        .list-proyek .list-group-item:first-child {
            padding-top: 0;
        }

        .list-proyek .list-group-item:last-child {
            padding-bottom: 0;
        }

        .list-proyek .list-group-item h6 {
            font-size: 0.95rem;
        }
    </style>
@endpush

@section('content')

    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="icon-wrapper icon-primary">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="info">
                        <p>Proyek Berjalan</p>
                        <h3>{{ $progresProyek }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="icon-wrapper {{ $totalProfitLoss >= 0 ? 'icon-success' : 'icon-danger' }}">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="info">
                        <p>Total Profit/Loss</p>
                        <h3 class="{{ $totalProfitLoss >= 0 ? 'profit' : 'loss' }}">
                            <span class="currency">Rp</span>
                            {{ number_format($totalProfitLoss, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="icon-wrapper icon-info">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="info">
                        <p>Total Customer</p>
                        <h3>{{ $totalCustomer }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card kpi-card">
                <div class="card-body">
                    <div class="icon-wrapper icon-warning">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="info">
                        <p>Total Teknisi</p>
                        <h3>{{ $totalTeknisi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 1rem">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h5 class="fw-bold">Ringkasan Finansial (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="financialChart" style="min-height: 250px; max-height: 290px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0" style="border-radius: 1rem">
                <div class="card-header bg-white border-0 pt-3 pb-0">
                    <h5 class="fw-bold">Proyek Sedang Berjalan</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-proyek">
                        @forelse ($proyekBerjalan as $proyek)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $proyek->nama_proyek }}</h6>
                                    <small
                                        class="text-muted d-block">{{ $proyek->customer->nama_perusahaan ?? 'N/A' }}</small>

                                    <small class="text-danger" style="font-size: 0.8rem;">
                                        Deadline: {{ $proyek->tanggal_selesai->format('d M Y') }}
                                    </small>
                                </div>
                                <a href="{{ route('transaksi.show', $proyek->transaksi->id) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    Kelola
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item px-0 text-center text-muted">
                                Tidak ada proyek yang sedang berjalan.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financialChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! $chartLabels !!},
                        datasets: [{
                                label: 'Pemasukan (Rp)',
                                data: {!! $chartPemasukan !!},
                                backgroundColor: 'rgba(74, 85, 199, 0.7)',
                                borderColor: 'rgba(74, 85, 199, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Pengeluaran (Rp)',
                                data: {!! $chartPengeluaran !!},
                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value, index, values) {
                                        if (value === 0) return 'Rp 0';
                                        return 'Rp ' + (value / 1000000) + ' Jt';
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        if (context.parsed.y !== null) {
                                            label += new Intl.NumberFormat('id-ID', {
                                                style: 'currency',
                                                currency: 'IDR',
                                                minimumFractionDigits: 0
                                            }).format(context.parsed.y);
                                        }
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush
